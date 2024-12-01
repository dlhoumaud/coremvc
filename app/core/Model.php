<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:30:22
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-01 13:59:15
 * @ Description: Classe de base pour les modèles
 */

namespace App\Core;

use PDO;
use PDOStatement;

class Model extends Database
{
    protected PDO $pdo;
    protected $query;
    protected $select = '*';
    protected $where = [];
    protected $joins = [];
    protected $bindings = [];
    protected $table;

    public function __construct()
    {

        // Utiliser l'instance PDO partagée
        $this->pdo = self::getInstance();

        // Initialiser la table, si définie
        if (isset($this->table)) {
            $this->query = 'SELECT * FROM ' . $this->table;
        }
    }

    public function select(string $columns = '*'): self
    {
        $this->select = $columns;
        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        return $this->where_and_or('', $column, $operator, $value);
    }

    public function whereIn(string $column, array $values): self
    {
        $this->where[] = "$column IN (" . implode(',', array_fill(0, count($values), '?')) . ")";
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }

    public function and(string $column, string $operator, $value): self
    {
        return $this->where_and_or('AND ', $column, $operator, $value);
    }

    public function or(string $column, string $operator, $value): self
    {
        return $this->where_and_or('OR ', $column, $operator, $value);
    }

    private function where_and_or(string $is, string $column, string $operator, $value): self
    {
        $this->where[] = "$is$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    // Encapsuler une condition AND (ex: WHERE id=? AND (state=? OR state=?))
    public function whereGroup(callable $callback): self
    {
        return $this->groupCallback('', $callback);
    }

    // Encapsuler une condition AND avec une sous-condition OR
    public function andGroup(callable $callback): self
    {
        return $this->groupCallback('AND ', $callback);
    }

    // Encapsuler une condition OR avec une sous-condition AND
    public function orGroup(callable $callback): self
    {
        return $this->groupCallback('OR ', $callback);
    }

    private function groupCallback(string $is, callable $callback): self 
    {
        $this->where[] = $is."(";
        $this->bindings[] = null;  // Placeholder pour un "group"
        $callback($this);  // Exécute le callback pour ajouter les conditions à l'intérieur du groupe
        $this->where[] = ')';
        return $this;
    }

    public function join(string $table, string $condition, string $type = 'INNER'): self
    {
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }

    public function leftJoin(string $table, string $condition): self
    {
        return $this->join($table, $condition, 'LEFT');
    }

    public function count(): int
    {
        // Construction de la requête de comptage avec les conditions de jointure et de filtrage
        $query = "SELECT COUNT(*) FROM {$this->table}" . $this->has_joins() . $this->has_where();

        return (int) $this->stmt($query, true)->fetchColumn();
    }

    public function get(int $index=-1): array
    {
        // Construction de la requête SELECT avec les clauses et jointures
        $query = "SELECT {$this->select} FROM {$this->table}" . $this->has_joins() . $this->has_where();
        $results = $this->stmt($query, true)->fetchAll(PDO::FETCH_ASSOC);
        if ($index >= 0 && isset($results[$index])) {
            return $results[$index];
        }
        return $results;
    }

    public function paginate(int $limit, int $offset): array
    {
        $query = "SELECT {$this->select} FROM {$this->table}" . $this->has_joins() . $this->has_where() . " LIMIT ? OFFSET ?";
        $this->bindings[] = $limit;
        $this->bindings[] = $offset;

        return $this->stmt($query, true)->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function delete(): bool
    {
        $query = "DELETE FROM {$this->table}" . $this->has_where();
        return $this->stmt($query);
    }

    public function update(array $data): bool
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
            $this->bindings[] = $value;
        }
        $query = "UPDATE {$this->table} SET " . implode(', ', $set) . $this->has_where();
        return $this->stmt($query);
    }

    private function has_where(): string
    {
        if (!empty($this->where)) {
            // Exemple d'ajout de parenthèses dans les conditions
            return ' WHERE ' . implode(' AND ', $this->where);
        }
        return '';
    }

    private function has_joins(): string
    {
        if (!empty($this->joins)) {
            return ' ' . implode(' ', $this->joins);
        }
        return '';
    }

    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $this->bindings = array_values($data);

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return $this->stmt($query);
    }

    // Définir une relation "hasMany"
    public function hasMany(string $relatedModel, string $foreignKey, string $localKey = 'id'): array
    {
        // Charger l'instance du modèle associé (par exemple "Post")
        $relatedModelInstance = new $relatedModel();

        // Requête pour récupérer toutes les instances de l'autre modèle avec la condition de clé étrangère
        return $relatedModelInstance
            ->where($foreignKey, '=', $this->$localKey)
            ->get();
    }

    // Définir une relation "belongsTo"
    public function belongsTo(string $relatedModel, string $foreignKey, string $ownerKey = 'id')
    {
        // Charger l'instance du modèle associé (par exemple "User")
        $relatedModelInstance = new $relatedModel();

        // Requête pour récupérer l'instance associée (par exemple l'utilisateur pour un post)
        return $relatedModelInstance
            ->where($ownerKey, '=', $this->$foreignKey)
            ->get(0); // Récupérer le premier élément (une seule ligne)
    }

    private function stmt(string $query, bool $return_stmt = false): bool|PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute($this->bindings);
            $this->reset();
            return ($return_stmt ? $stmt : $result);
        } catch (\PDOException $e) {
            // Log l'erreur ou lever une exception personnalisée
            throw new \Exception("Erreur dans la requête SQL : " . $e->getMessage());
        }
    }

    private function reset(): void
    {
        $this->select = '*';
        $this->where = [];
        $this->joins = [];
        $this->bindings = [];
    }
}
