# Utilisation des Templates dans CoreMVC

---

## Introduction

CoreMVC intègre un moteur de template permettant de simplifier l'affichage des vues tout en conservant la flexibilité et la puissance de PHP. Cette documentation explique comment utiliser les templates dans votre projet CoreMVC.

---

## 1. Rendu des vues avec `view()`

La fonction `view()` permet d'inclure et d'afficher une vue en injectant des données dynamiques.

### **Utilisation :**
```php
echo view('home', ['title' => 'Accueil']);
```
Si le fichier **home.php** ou **home.view** existe dans `../app/views/`, il sera chargé et traité.

---

## 2. Syntaxe des Templates

CoreMVC fournit une syntaxe simplifiée pour certaines structures PHP :

| Balise Template | Équivalent PHP |
|-----------------|---------------|
| `@if(condition):@` | `<?php if(condition): ?>` |
| `@elseif(condition):@` | `<?php elseif(condition): ?>` |
| `@else` | `<?php else: ?>` |
| `@endif` | `<?php endif; ?>` |
| `@foreach($items as $item):@` | `<?php foreach($items as $item): ?>` |
| `@endforeach` | `<?php endforeach; ?>` |
| `@for($i = 0; $i < 10; $i++):@` | `<?php for($i = 0; $i < 10; $i++): ?>` |
| `@endfor` | `<?php endfor; ?>` |
| `@while(condition):@` | `<?php while(condition): ?>` |
| `@endwhile` | `<?php endwhile; ?>` |

### **Exemple :**
```php
@if($user):@
    <p>Bienvenue, <% $user['name'] %></p>
@else
    <p>Bienvenue, invité !</p>
@endif
```

---

## 3. Inclusion de Fichiers

Vous pouvez inclure d'autres fichiers de vue avec `@include()` et `@include_once()` :

```php
@include('header')
@include_once('sidebar')
```

Vous pouvez inclure une vue dans une vue avec `%view()` :

```php
%view('sidebar', ['menu' => ['Item 1', 'Item 2', 'Item 3']])
```

Lorsque vous passez un tableau associatif à view() ou %view(), chaque clé principale devient une variable disponible dans la vue correspondante.

exemple de fichier `sidebar.php` :
```php
<ul>
    @foreach($menu as $item):@
        <li><% $item %></li>
    @endforeach
</ul>
```

---

## 4. Variables et Affichage

### **Syntaxe simplifiée :**
| Balise | Description |
|--------|------------|
| `<% variable %>` | `<?= variable ?>` |
| `<@` `@>` | `<?php` `?>` |
| `:@` | `: ?>` |

- **@** démarre un bloc PHP (`<?php ... ?>`)
- **%** sert à afficher une expression (`<?= ... ?>`)

#### **Exemple :**
```php
<p>Bonjour, <% $nom %> !</p>
```
Génère :
```php
<p>Bonjour, <?= $nom ?> !</p>
```

---

## 5. Localisation (`l()`, `lh()`, `__()`)

Pour gérer la traduction des textes :

- `l('key')` : Récupère la traduction brute.
- `lh('key')` : Récupère la traduction et échappe les caractères HTML.
- `__('key')` : Alias de `l('key')`.

Exemple :
```php
<p>%l('welcome_message')</p>
<p>%lh('secure_text')</p>
```

---

## 6. Debugging et Débogage

CoreMVC fournit plusieurs fonctions de debugging :

| Fonction | Description |
|----------|------------|
| `dump($var)` | Affiche une variable avec `var_dump()` si `APP_DEBUG` est activé |
| `dbg($var)` | Alias de `dump()` |
| `dd($var)` | Affiche la variable puis arrête le script |

Exemple :
```php
@dbg($user);
// ou
@dump($user);
```

---

## 7. Minification HTML

Si `APP_DEBUG` est désactivé, les vues seront minifiées en supprimant les espaces inutiles et commentaires HTML pour améliorer la performance du rendu.

⚠️ Remarque : La minification des vues ne s'applique que si APP_DEBUG=false dans votre fichier .env.

---

## Conclusion

Le moteur de template de CoreMVC simplifie l'écriture des vues tout en restant performant. Il permet une séparation claire entre la logique et la présentation, et optimise le rendu HTML.

