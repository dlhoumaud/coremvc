# Documentation de la librairie Rick.js

Rick.js est une petite librairie JavaScript qui permet de manipuler facilement les éléments DOM, tout en offrant une API fluide et simple grâce au chainage. Voici un guide complet sur les méthodes disponibles.

## Table des matières

1. [Création d'une instance](#création-dune-instance)
2. [Méthodes principales](#méthodes-principales)
   - [html()](#html)
   - [text()](#text)
   - [css()](#css)
   - [addClass()](#addClass)
   - [removeClass()](#removeClass)
   - [hasClass()](#hasClass)
   - [attr()](#attr)
   - [on()](#on)
   - [off()](#off)
   - [show()](#show)
   - [hide()](#hide)
   - [toggleClass()](#toggleClass)
3. [Méthodes supplémentaires](#méthodes-supplémentaires)
   - [click()](#click)
   - [mouseenter()](#mouseenter)
   - [mouseleave()](#mouseleave)
   - [mouseover()](#mouseover)
   - [mouseout()](#mouseout)
   - [keydown()](#keydown)
   - [keyup()](#keyup)
   - [change()](#change)
4. [Animations et transitions](#animations-et-transitions)
   - [fadeOut()](#fadeOut)
   - [fadeIn()](#fadeIn)
   - [animate()](#animate)
5. [Méthodes de navigation DOM](#méthodes-de-navigation-dom)
   - [children()](#children)
   - [parent()](#parent)
   - [trigger()](#trigger)
   - [scrollTo()](#scrollTo)
6. [Méthodes utilitaires](#méthodes-utilitaires)
   - [count()](#count)
   - [isEmpty()](#isEmpty)
   - [isUndefined()](#isUndefined)
   - [isExist()](#isExist)

---

## Création d'une instance

Pour utiliser Rick.js, vous devez créer une instance en sélectionnant des éléments DOM via la fonction `$`. Celle-ci peut être utilisée de la manière suivante :

```javascript
const rick = $('selector'); // Sélectionne les éléments correspondant au sélecteur
```

Elle retourne une instance de `Rick` avec les éléments sélectionnés. Vous pouvez maintenant appeler les méthodes de la librairie sur cette instance.

## Méthodes principales

### `html(content)`
Permet de manipuler le contenu HTML des éléments sélectionnés.

- **Argument :** `content` (String) — Le contenu HTML à insérer.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
// Remplacer le contenu HTML
$('div').html('<p>Nouvelle contenu</p>');
```

### `text(content)`
Permet de manipuler le contenu texte des éléments sélectionnés.

- **Argument :** `content` (String) — Le texte à insérer.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
// Remplacer le contenu texte
$('p').text('Nouveau texte');
```

### `css(property, value)`
Permet de définir ou de récupérer les styles CSS des éléments.

- **Argument :**
  - `property` (String) : Le nom de la propriété CSS.
  - `value` (String) : La valeur de la propriété CSS.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
// Modifier le style d'un élément
$('div').css('color', 'red');

// Modifier plusieurs styles à la fois
$('div').css({ color: 'red', backgroundColor: 'yellow' });
```

### `addClass(className)`
Ajoute une ou plusieurs classes CSS aux éléments sélectionnés.

- **Argument :** `className` (String) — Le nom de la classe à ajouter.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('p').addClass('nouvelle-classe');
```

### `removeClass(className)`
Supprime une ou plusieurs classes CSS des éléments sélectionnés.

- **Argument :** `className` (String) — Le nom de la classe à supprimer.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('p').removeClass('ancienne-classe');
```

### `hasClass(className)`
Vérifie si un élément possède une classe donnée.

- **Argument :** `className` (String) — Le nom de la classe.
- **Retour :** `true` si l'élément possède la classe, `false` sinon.

Exemple :

```javascript
$('p').hasClass('nouvelle-classe'); // Retourne true ou false
```

### `attr(attribute, value)`
Définit ou récupère un attribut d'un élément.

- **Argument :**
  - `attribute` (String) : Le nom de l'attribut.
  - `value` (String) : La valeur de l'attribut.
- **Retour :** `this` pour chaîner les appels ou la valeur de l'attribut du premier élément.

Exemple :

```javascript
// Définir un attribut
$('input').attr('type', 'text');

// Récupérer un attribut
$('input').attr('type');
```

### `on(event, callback)`
Ajoute un gestionnaire d'événements aux éléments sélectionnés.

- **Argument :**
  - `event` (String) : Le type d'événement (ex. 'click', 'mouseover').
  - `callback` (Function) : La fonction à appeler lorsque l'événement se produit.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('button').on('click', () => alert('Cliquez sur le bouton'));
```

### `off(event, callback)`
Retire un gestionnaire d'événements.

- **Argument :**
  - `event` (String) : Le type d'événement.
  - `callback` (Function) : La fonction à retirer.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('button').off('click', maFonction);
```

### `show()`
Affiche les éléments sélectionnés.

- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('div').show();
```

### `hide()`
Cache les éléments sélectionnés.

- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('div').hide();
```

### `toggleClass(className)`
Ajoute ou supprime une classe en fonction de sa présence.

- **Argument :** `className` (String) — Le nom de la classe à alterner.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('div').toggleClass('visible');
```

---

## Méthodes supplémentaires

### `click(callback)`
Ajoute un gestionnaire d'événement `click` sur les éléments sélectionnés.

### `mouseenter(callback)`
Ajoute un gestionnaire d'événement `mouseenter` sur les éléments sélectionnés.

### `mouseleave(callback)`
Ajoute un gestionnaire d'événement `mouseleave` sur les éléments sélectionnés.

### `mouseover(callback)`
Ajoute un gestionnaire d'événement `mouseover` sur les éléments sélectionnés.

### `mouseout(callback)`
Ajoute un gestionnaire d'événement `mouseout` sur les éléments sélectionnés.

### `keydown(callback)`
Ajoute un gestionnaire d'événement `keydown` sur les éléments sélectionnés.

### `keyup(callback)`
Ajoute un gestionnaire d'événement `keyup` sur les éléments sélectionnés.

### `change(callback)`
Ajoute un gestionnaire d'événement `change` sur les éléments sélectionnés.

---

## Animations et transitions

### `fadeOut(duration)`
Anime une transition de disparition (opacité) des éléments sélectionnés.

- **Argument :** `duration` (Number) — Durée de l'animation en millisecondes.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('div').fadeOut(500);
```

### `fadeIn(duration, display)`
Anime une transition d'apparition (opacité) des éléments sélectionnés.

- **Argument :**
  - `duration` (Number) — Durée de l'animation en millisecondes.
  - `display` (String) — Le type d'affichage à utiliser (par défaut 'block').
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('div').fadeIn(500);
```

### `animate(styles, duration, callback)`
Anime les éléments en appliquant des styles CSS spécifiques.

- **Argument :**
  - `styles` (Object) — Les styles CSS à appliquer (ex. `{ left: '100px' }`).
  - `duration` (Number) — Durée de l'animation en millisecondes.
  - `callback` (Function) — Fonction de rappel après l'animation.
- **Retour :** `this` pour chaîner les appels.
  
Exemple :

```javascript
$('div').animate({ left: '100px' }, 500);
```

---

## Méthodes de navigation DOM

### `children()`
Retourne une nouvelle instance contenant tous les enfants des éléments sélectionnés.

### `parent()

`
Retourne une nouvelle instance contenant l'élément parent des éléments sélectionnés.

### `trigger(event)`
Déclenche un événement sur les éléments sélectionnés.

### `scrollTo()`
Permet de faire défiler l'écran vers un élément spécifié.

---

## Méthodes utilitaires

### `count()`
Retourne le nombre d'éléments sélectionnés.

### `isEmpty()`
Vérifie si la sélection est vide.

### `isUndefined()`
Vérifie si un élément est `undefined`.

### `isExist()`
Vérifie si un élément existe dans le DOM.