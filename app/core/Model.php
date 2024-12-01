<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:30:22
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-01 19:30:41
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

    /**
     * Initialise l'instance du modèle en définissant l'instance PDO partagée et le nom de la table si elle est définie.
     */
    public function __construct()
    {
        // Utiliser l'instance PDO partagée
        $this->pdo = self::getInstance();
        // Initialiser la table, si définie
        if (isset($this->table)) {
            $this->query = 'SELECT * FROM ' . $this->table;
        }
    }

    /**
     * Définit les colonnes pour sélectionner dans la requête.
     *
     * @param string $columns Les colonnes à sélectionner, par défaut «*» (toutes les colonnes).
     * @return $this L'instance de modèle actuelle, pour le chaînage de méthode.
     */
    public function select(string $columns = '*'): self
    {
        $this->select = $columns;
        return $this;
    }

    /**
     * Ajoute une condition où la requête.
     *
     * @param string $column The column to filter on.
     * @param string $operator The comparison operator (e.g. '=', '>', '<').
     * @param mixed $value The value to compare the column to.
     * @return $this The current model instance, for method chaining.
     */
    public function where(string $column, string $operator, $value): self
    {
        return $this->where_and_or('', $column, $operator, $value);
    }

    /**
     * Ajoute un état "IN" à la requête.
     *
     * @param string $column The column to filter on.
     * @param array $values The values to compare the column to.
     * @return $this The current model instance, for method chaining.
     */
    public function whereIn(string $column, array $values): self
    {
        $this->where[] = "$column IN (" . implode(',', array_fill(0, count($values), '?')) . ")";
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }

    /**
     * Ajoute une condition "AND" à la requête.
     *
     * @param string $column The column to filter on.
     * @param string $operator The comparison operator (e.g. '=', '>', '<').
     * @param mixed $value The value to compare the column to.
     * @return $this The current model instance, for method chaining.
     */
    public function and(string $column, string $operator, $value): self
    {
        return $this->where_and_or('AND ', $column, $operator, $value);
    }

    /**
     * Ajoute une condition "OR" à la requête.
     *
     * @param string $column The column to filter on.
     * @param string $operator The comparison operator (e.g. '=', '>', '<').
     * @param mixed $value The value to compare the column to.
     * @return $this The current model instance, for method chaining.
     */
    public function or(string $column, string $operator, $value): self
    {
        return $this->where_and_or('OR ', $column, $operator, $value);
    }

    /**
     * Ajoute une condition où la requête avec la colonne, l'opérateur et la valeur spécifiés.
     *
     * Il s'agit d'une méthode d'assistance utilisée par les méthodes «where()», `and()» et `or()» pour ajouter une condition à la requête.
     *
     * @param string $is The logical operator to use (e.g. 'AND', 'OR').
     * @param string $column The column to filter on.
     * @param string $operator The comparison operator (e.g. '=', '>', '<').
     * @param mixed $value The value to compare the column to.
     * @return $this The current model instance, for method chaining.
     */
    private function where_and_or(string $is, string $column, string $operator, $value): self
    {
        $this->where[] = "$is$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    /**
     * Encapsuler un groupe de conditions avec un opérateur logique (e.g. AND, OR).
     *
     * Cette méthode vous permet de regrouper plusieurs conditions ensemble en utilisant une logique
     * opérateur.La fonction de rappel transmise à cette méthode sera exécutée pour
     * Ajoutez les conditions à l'intérieur du groupe.
     *
     * @param callable $callback A callback function that will be executed to add
     *                          the conditions inside the group.
     * @return $this The current model instance, for method chaining.
     */
    public function whereGroup(callable $callback): self
    {
        return $this->groupCallback('', $callback);
    }

    /**
     * Encapsuler une condition AND avec une sous-condition OR.
     *
     * Cette méthode vous permet de regrouper plusieurs conditions ensemble en utilisant une logique
     * opérateur AND. La fonction de rappel transmise à cette méthode sera exécutée pour
     * Ajoutez les conditions à l'intérieur du groupe.
     *
     * @param callable $callback A callback function that will be executed to add
     *                          the conditions inside the group.
     * @return $this The current model instance, for method chaining.
     */
    public function andGroup(callable $callback): self
    {
        return $this->groupCallback('AND ', $callback);
    }

    /**
     * Encapsuler une condition OR avec une sous-condition AND.
     *
     * Cette méthode vous permet de regrouper plusieurs conditions ensemble en utilisant une logique
     * opérateur OR. La fonction de rappel transmise à cette méthode sera exécutée pour
     * Ajoutez les conditions à l'intérieur du groupe.
     *
     * @param callable $callback A callback function that will be executed to add
     *                          the conditions inside the group.
     * @return $this The current model instance, for method chaining.
     */
    public function orGroup(callable $callback): self
    {
        return $this->groupCallback('OR ', $callback);
    }

    /**
     * Encapsule un groupe de conditions avec un opérateur logique (e.g. AND, OR).
     *
     * This method allows you to group multiple conditions together using a logical
     * operator. The callback function passed to this method will be executed to
     * add the conditions inside the group.
     *
     * @param string $is The logical operator to use for the group (e.g. 'AND ', 'OR ').
     * @param callable $callback A callback function that will be executed to add
     *                          the conditions inside the group.
     * @return $this The current model instance, for method chaining.
     */
    private function groupCallback(string $is, callable $callback): self 
    {
        $this->where[] = $is."(";
        $this->bindings[] = null;  // Placeholder pour un "group"
        $callback($this);  // Exécute le callback pour ajouter les conditions à l'intérieur du groupe
        $this->where[] = ')';
        return $this;
    }

    /**
     * Ajoute une clause de jointure à la requête.
     *
     * @param string $table The table to join.
     * @param string $condition The join condition.
     * @param string $type The type of join to perform (e.g. 'INNER', 'LEFT', 'RIGHT').
     * @return $this The current model instance, for method chaining.
     */
    public function join(string $table, string $condition, string $type = 'INNER'): self
    {
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }

    /**
     * Ajoute une clause de jointure de gauche à la requête.
     *
     * @param string $table The table to join.
     * @param string $condition The join condition.
     * @return $this The current model instance, for method chaining.
     */
    public function leftJoin(string $table, string $condition): self
    {
        return $this->join($table, $condition, 'LEFT');
    }

    /**
     * Récupère le nombre d'enregistrements de la base de données en fonction des conditions de requête actuelles.
     *
     * @return int Le nombre d'enregistrements correspondant aux conditions de requête.
     */
    public function count(): int
    {
        // Construction de la requête de comptage avec les conditions de jointure et de filtrage
        $query = "SELECT COUNT(*) FROM {$this->table}" . $this->has_joins() . $this->has_where();

        return (int) $this->stmt($query, true)->fetchColumn();
    }

    /**
     * Récupère un enregistrement ou un ensemble d'enregistrements de la base de données.
     *
     * @param int $index L'indice de l'enregistrement à récupérer, ou -1 pour récupérer tous les enregistrements.
     * @return array Un éventail de tableaux associatifs représentant les dossiers récupérés.
     */
    public function get(int $index=-1): array
    {
        // Construction de la requête SELECT avec les clauses et jointures
        $query = "SELECT {$this->select} FROM {$this->table}" . $this->has_joins() . $this->has_where();
        if ($index >= 0) {
            // Si l'index est fourni, ajouter un LIMIT pour récupérer l'enregistrement à l'index donné
            $query .= " LIMIT 1 OFFSET $index";
            return $this->stmt($query, true)->fetch(PDO::FETCH_ASSOC);
        }
        return $this->stmt($query, true)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un ensemble paginé d'enregistrements de la base de données.
     *
     * @param int $limit Le nombre maximum d'enregistrements à retourner par page.
     * @param int $offset Le nombre d'enregistrements à sauter depuis le début.
     * @return array Un éventail de tableaux associatifs représentant les dossiers récupérés.
     */
    public function paginate(int $limit, int $offset): array
    {
        $query = "SELECT {$this->select} FROM {$this->table}" . $this->has_joins() . $this->has_where() . " LIMIT $limit OFFSET $offset";

        return $this->stmt($query, true)->fetchAll(PDO::FETCH_ASSOC);
    }
    

    /**
     * Supprime un enregistrement de la base de données en fonction des conditions de requête actuelles.
     *
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function delete(): bool
    {
        $query = "DELETE FROM {$this->table}" . $this->has_where();
        return $this->stmt($query);
    }

    /**
     * Met à jour un enregistrement dans la base de données avec les données fournies.
     *
     * @param array $data An associative array of column names and their corresponding values to update.
     * @return bool True if the update was successful, false otherwise.
     */
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

    /**
     * Génère la clause où la requête SQL en fonction des conditions stockées dans la propriété «$where».
     *
     * If there are no conditions in the `$where` property, this method will return an empty string.
     * Otherwise, it will return a string in the format `' WHERE condition1 AND condition2 AND ...`
     * where the conditions are joined with the `AND` operator.
     *
     * @return string The WHERE clause for the SQL query, or an empty string if there are no conditions.
     */
    private function has_where(): string
    {
        if (!empty($this->where)) {
            // Exemple d'ajout de parenthèses dans les conditions
            return ' WHERE ' . implode(' AND ', $this->where);
        }
        return '';
    }

    /**
     * Génère la clause de jointure pour la requête SQL en fonction des conditions stockées dans la propriété $joins.
     *
     * If there are no JOIN conditions in the `$joins` property, this method will return an empty string.
     * Otherwise, it will return a string in the format `' JOIN condition1 JOIN condition2 ...`
     * where the JOIN conditions are joined with the `JOIN` keyword.
     *
     * @return string The JOIN clause for the SQL query, or an empty string if there are no JOIN conditions.
     */
    private function has_joins(): string
    {
        if (!empty($this->joins)) {
            return ' ' . implode(' ', $this->joins);
        }
        return '';
    }

    /**
     * Insère un nouvel enregistrement dans la base de données avec les données fournies.
     *
     * @param array $data An associative array of column names and their corresponding values to insert.
     * @return bool True if the insert was successful, false otherwise.
     */
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $this->bindings = array_values($data);

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return $this->stmt($query);
    }

    /**
     * Récupère toutes les instances d'un modèle connexe qui correspondent à la clé étrangère spécifiée.
     *
     * @param string $relatedModel Le nom de classe du modèle connexe.
     * @param string $foreignKey Le nom de la colonne de clé étrangère dans le modèle connexe.
     * @param string $localKey Le nom de la colonne de clé locale dans le modèle actuel (par défaut est «id»).
     * @return array Un tableau d'instances du modèle connexe.
     */
    public function hasMany(string $relatedModel, string $foreignKey, string $localKey = 'id'): array
    {
        // Charger l'instance du modèle associé (par exemple "Post")
        $relatedModelInstance = new $relatedModel();

        // Requête pour récupérer toutes les instances de l'autre modèle avec la condition de clé étrangère
        return $relatedModelInstance
            ->where($foreignKey, '=', $this->$localKey)
            ->get();
    }

    /**
     * Récupère l'instance d'un modèle connexe qui correspond à la clé étrangère spécifiée.
     *
     * @param string $relatedModel Le nom de classe du modèle connexe.
     * @param string $foreignKey Le nom de la colonne de clé étrangère dans le modèle connexe.
     * @param string $ownerKey Le nom de la colonne de clé locale dans le modèle actuel (par défaut est «id»).
     * @return object L'instance du modèle connexe.
     */
    public function belongsTo(string $relatedModel, string $foreignKey, string $ownerKey = 'id')
    {
        // Charger l'instance du modèle associé (par exemple "User")
        $relatedModelInstance = new $relatedModel();

        // Requête pour récupérer l'instance associée (par exemple l'utilisateur pour un post)
        return $relatedModelInstance
            ->where($ownerKey, '=', $this->$foreignKey)
            ->get(0); // Récupérer le premier élément (une seule ligne)
    }

    /**
     * Exécute une requête SQL brute avec les liaisons fournies et renvoie le résultat en tant que tableau.
     *
     * @param string $query La requête SQL à exécuter.
     * @param array $bindings Le tableau de valeurs pour se lier aux paramètres de requête.
     * @return array Le résultat de la requête SQL comme tableau de tableaux associatifs.
     */
    public function raw(string $query, array $bindings = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exécute une requête SQL et renvoie le résultat.
     *
     * @param string $query The SQL query to execute.
     * @param bool $return_stmt Whether to return the PDOStatement object instead of the result.
     * @return bool|PDOStatement The result of the query or the PDOStatement object.
     */
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

    /**
     * Réinitialise l'état interne de l'instance du modèle.
     * This method sets the `$select`, `$where`, `$joins`, and `$bindings` properties to their default values.
     */
    private function reset(): void
    {
        $this->select = '*';
        $this->where = [];
        $this->joins = [];
        $this->bindings = [];
    }
}
