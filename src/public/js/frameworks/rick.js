/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-25 16:36:08
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-18 13:54:41
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

    value(value) {
        if (value !== undefined) {
            this.elements.forEach(el => el.value = value);
            return this; // Chainage
        }
        return this.elements[0]?.value || null;
    }

    id(id) {
        if (id !== undefined) {
            this.elements.forEach(el => el.id = id);
            return this; // Chainage
        }
        return this.elements[0]?.id || null;
    }

    href(href) {
        if (href !== undefined) {
            this.elements.forEach(el => el.setAttribute('href', href));
            return this; // Chainage
        }
        return this.elements[0]?.getAttribute('href') || null;
    }

    action(action) {
        if (action !== undefined) {
            this.elements.forEach(el => el.setAttribute('action', action));
            return this; // Chainage
        }
        return this.elements[0]?.getAttribute('action') || null;
    }

    method(method) {
        if (method !== undefined) {
            this.elements.forEach(el => el.setAttribute('method', method));
            return this; // Chainage
        }
        return this.elements[0]?.getAttribute('method') || null;
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
    console.log('aaa');
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


/**
 * Sends an HTTP request and handles the response.
 *
 * @param {object} options - The request options.
 * @param {string} options.url - The URL to send the request to.
 * @param {string} [options.method='GET'] - The HTTP method to use for the request.
 * @param {object} [options.headers={}] - The headers to include in the request.
 * @param {any} [options.data=null] - The data to include in the request body.
 * @param {string} [options.responseType='json'] - The expected response type, either 'json' or the raw response.
 * @param {function} [options.callback=null] - The callback function to call when the request is complete.
 */
function sendRequest({ url, method = "GET", headers = {}, data = null, timeout=10000, responseType = "json", callback = null }) {
    const xhr = new XMLHttpRequest();

    // Configure la requête
    xhr.open(method, url, true);

    // Ajoute les headers fournis
    for (const key in headers) {
        if (headers.hasOwnProperty(key)) {
            xhr.setRequestHeader(key, headers[key]);
        }
    }

    // Gestion de l'état de la requête
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status >= 200 && this.status < 300) {
                // Requête réussie
                if (callback) callback(null, responseRequestToJSON(this.responseText, responseType));
            } else {
                // Gestion des erreurs HTTP
                if (callback) callback({ status: this.status, statusText: this.statusText}, responseRequestToJSON(this.responseText, responseType));
            }
        }
    });

    xhr.onerror = function () {
        if (callback) callback({ error: "Network error" }, null);
    };

    xhr.timeout = timeout; // Timeout de 10 secondes
    xhr.ontimeout = function () {
        if (callback) callback({ error: "Request timed out" }, null);
    };

    // Envoie les données (si présentes)
    xhr.withCredentials = true; // Optionnel : à activer si nécessaire
    xhr.send(data ? (typeof data === "string" ? data : JSON.stringify(data)) : null);
}

/**
 * Parses the response from an HTTP request and returns the data as a JavaScript object.
 *
 * @param {string} response - The response text from the HTTP request.
 * @param {string} [responseType='json'] - The expected response type, either 'json' or the raw response.
 * @returns {object} - The parsed response data, or an object with an 'error' property if the response is invalid JSON.
 */
function responseRequestToJSON(response, responseType='json') {
    try {
        return responseType === "json" ? JSON.parse(response) : response;
    } catch (error) {
        return { error: "Invalid JSON response" };
    }
}

/**
 sendRequest({
    url: "http://localhost:8000/api/user/login",
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    data: "email=xxxxxx%40example.com&password=***********",
    callback: (error, response) => {
        if (error) {
            console.error("Erreur:", error);
        } else {
            const APIElement = document.getElementById("API");
            if (response.error === undefined) {
                APIElement.innerHTML = `${response.firstname} ${response.lastname}`;
            } else {
                APIElement.innerHTML = response.error;
            }
        }
    }
});

sendRequest({
    url: "http://localhost:8000/api/user/info",
    method: "GET",
    callback: (error, response) => {
        if (error) {
            console.error("Erreur:", error);
        } else {
            console.log("User Info:", response);
        }
    }
});


sendRequest({
    url: "http://localhost:8000/api/user/update",
    method: "PUT",
    headers: {
        "Content-Type": "application/json"
    },
    data: { firstname: "John", lastname: "Doe" },
    callback: (error, response) => {
        if (error) {
            console.error("Erreur:", error);
        } else {
            console.log("Mise à jour réussie:", response);
        }
    }
});


sendRequest({
    url: "http://localhost:8000/api/user/delete",
    method: "DELETE",
    callback: (error, response) => {
        if (error) {
            console.error("Erreur:", error);
        } else {
            console.log("Suppression réussie:", response);
        }
    }
});


 */