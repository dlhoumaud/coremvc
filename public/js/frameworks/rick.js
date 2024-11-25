/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-25 16:36:08
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-25 22:30:52
 * @ Description: Librairie RickJS
 */


class Rick {
    constructor(elements) {
        this.elements = elements;
    }

    // Remplace le contenu HTML
    html(content) {
        if (content !== undefined) {
            this.elements.forEach(el => el.innerHTML = content);
            return this; // Chainage
        }
        // Retourne le HTML du premier élément
        return this.elements[0]?.innerHTML || '';
    }

    // Remplace le contenu texte
    text(content) {
        if (content !== undefined) {
            this.elements.forEach(el => el.textContent = content);
            return this; // Chainage
        }
        // Retourne le texte du premier élément
        return this.elements[0]?.textContent || '';
    }

    // Change les styles CSS
    css(property, value) {
        if (typeof property === 'string' && value !== undefined) {
            this.elements.forEach(el => el.style[property] = value);
        } else if (typeof property === 'object') {
            // Applique plusieurs styles si un objet est fourni
            this.elements.forEach(el => {
                for (let key in property) {
                    el.style[key] = property[key];
                }
            });
        }
        return this; // Chainage
    }

    // Ajoute une classe
    addClass(className) {
        this.elements.forEach(el => el.classList.add(className));
        return this; // Chainage
    }

    // Supprime une classe
    removeClass(className) {
        this.elements.forEach(el => el.classList.remove(className));
        return this; // Chainage
    }

    // Vérifie si une classe est présente
    hasClass(className) {
        return this.elements[0]?.classList.contains(className) || false;
    }

    // Attribue ou récupère des attributs
    attr(attribute, value) {
        if (value !== undefined) {
            this.elements.forEach(el => el.setAttribute(attribute, value));
            return this; // Chainage
        }
        // Retourne l'attribut du premier élément
        return this.elements[0]?.getAttribute(attribute) || null;
    }

    // Gère les événements
    on(event, callback) {
        this.elements.forEach(el => el.addEventListener(event, callback));
        return this; // Chainage
    }

    // Retire les gestionnaires d'événements
    off(event, callback) {
        this.elements.forEach(el => el.removeEventListener(event, callback));
        return this; // Chainage
    }

    // Affiche les éléments
    show() {
        this.elements.forEach(el => el.style.display = '');
        return this; // Chainage
    }

    // Cache les éléments
    hide() {
        this.elements.forEach(el => el.style.display = 'none');
        return this; // Chainage
    }

    // Applique un toggle à la classe
    toggleClass(className) {
        this.elements.forEach(el => el.classList.toggle(className));
        return this; // Chainage
    }
}

// QuerySelector
function $(selector) {
    if (typeof selector === 'string') {
        return new Rick(document.querySelectorAll(selector));
    } else if (selector instanceof HTMLElement || selector instanceof NodeList) {
        return new Rick(selector instanceof NodeList ? selector : [selector]);
    }
    return new Rick([]);
}

// Prototype pour le click
Rick.prototype.click = function(callback) {
    this.elements.forEach(el => el.addEventListener('click', callback));
    return this;
};

// Prototype pour le mouseenter
Rick.prototype.mouseenter = function(callback) {
    this.elements.forEach(el => el.addEventListener('mouseenter', callback));
    return this;
};

// Prototype pour le mouseleave
Rick.prototype.mouseleave = function(callback) {
    this.elements.forEach(el => el.addEventListener('mouseleave', callback));
    return this;
};

// Prototype pour le mouseover
Rick.prototype.mouseover = function(callback) {
    this.elements.forEach(el => el.addEventListener('mouseover', callback));
    return this;
};

// Prototype pour le mouseout
Rick.prototype.mouseout = function(callback) {
    this.elements.forEach(el => el.addEventListener('mouseout', callback));
    return this;
};

// Prototype pour le keydown
Rick.prototype.keydown = function(callback) {
    this.elements.forEach(el => el.addEventListener('keydown', callback));
    return this;
};

// Prototype pour le keyup
Rick.prototype.keyup = function(callback) {
    this.elements.forEach(el => el.addEventListener('keyup', callback));
    return this;
};

// Prototype pour le change
Rick.prototype.change = function(callback) {
    this.elements.forEach(el => el.addEventListener('change', callback));
    return this;
};

Rick.prototype.fadeOut = function(duration) {
    this.elements.forEach(el => {
        el.style.transition = `opacity ${duration}ms`;
        el.style.opacity = 0;
        setTimeout(() => el.style.display = 'none', duration);
    });
    return this;
};

Rick.prototype.fadeIn = function(duration, display='block') {
    this.elements.forEach(el => {
        el.style.display = display;
        el.style.transition = `opacity ${duration}ms`;
        el.style.opacity = 1;
    });
    return this;
};

Rick.prototype.children = function() {
    const allChildren = [];
    this.elements.forEach(el => allChildren.push(...el.children));
    return new Rick(allChildren);
};

Rick.prototype.parent = function() {
    const parents = this.elements.map(el => el.parentNode).filter(Boolean);
    return new Rick(parents);
};

Rick.prototype.trigger = function(eventType) {
    this.elements.forEach(el => {
        const event = new Event(eventType);
        el.dispatchEvent(event);
    });
    return this;
};

Rick.prototype.scrollTo = function() {
    this.elements.forEach(el => el.scrollIntoView({ behavior: 'smooth' }));
    return this;
};

Rick.prototype.animate = function(styles, duration, callback) {
    this.elements.forEach(el => {
        Object.keys(styles).forEach(key => {
            el.style.transition = `${key} ${duration}ms`;
            el.style[key] = styles[key];
        });
    });
    if (callback) setTimeout(callback, duration);
    return this;
};

Rick.prototype.count = function() {
    return this.elements.length;
};

Rick.prototype.isEmpty = function() {
    return this.elements.length === 0;
};

Rick.prototype.isUndefined = function() {
    return this.elements.length === 0 || this.elements[0] === undefined;
};

Rick.prototype.isExist = function() {
    return this.elements.length > 0;
};