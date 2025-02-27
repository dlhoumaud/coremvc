export default (app) => {
    app.component("bubbles", {
        props: {
            number: {
                type: Number,
                default: 15
            }
        },
        data() {
            return {
                bubbles: [] // Un tableau pour stocker les positions des bulles
            };
        },
        template: `
            <div>
                <!-- Création des bulles en fonction du nombre spécifié -->
                <div
                    v-for="(bubble, index) in bubbles"
                    :key="index"
                    class="bubble"
                    :style="bubble.style"
                    @animationend="handleAnimationEnd($event)"
                    :data-index="index"
                ></div>
            </div>
        `,
        methods: {
            // Méthode pour générer des styles dynamiques pour chaque bulle
            getBubbleStyle(index) {
                const size = this.getRandomSize();
                const position = this.getRandomPosition(index);  // On passe l'index pour vérifier les collisions
                const animationName = `float_${index}`;
                const animationDuration = this.getRandomDuration();
                const borderRadius = this.getRandomBorderRadius();
                const color = this.getRandomColor();

                // Créer dynamiquement des keyframes pour chaque bulle
                const translateY = this.getRandomTranslateY();
                const translateX = this.getRandomTranslateX();
                const scale = this.getRandomScale();

                // Injecter les keyframes dans le style
                this.injectKeyframes(animationName, translateY, translateX, scale);

                // Ajouter la bulle dans le tableau des bulles pour éviter les collisions
                this.bubbles.push({
                    style: {
                        width: `${size.width}px`,
                        height: `${size.height}px`,
                        top: `${position.top}%`,
                        left: `${position.left}%`,
                        animation: `${animationName} ${animationDuration}s ease-in-out`,
                        transition: `background-color 3s ease-in-out`,
                        borderRadius: borderRadius,
                        filter: "blur(3px)",
                        opacity: 0.5,
                        backgroundColor: `${color}`, //'#26d9e4',
                        position: 'fixed'
                    },
                    position: position, // Stocke aussi la position pour la vérification des collisions
                    animation: animationName,
                    backgroundColor: color,
                    y: translateY,
                    x: translateX,
                    s: scale,
                    duration: animationDuration
                });
            },

            // Fonction pour injecter des keyframes CSS dynamiques
            injectKeyframes(animationName, translateY, translateX, scale) {
                const styleSheet = document.styleSheets[0];

                // Créer une règle @keyframes dynamique pour chaque bulle
                const keyframes = `
                    @keyframes ${animationName} {
                        0% {
                            transform: translateY(0) scale(1);
                        }
                        50% {
                            transform: translateY(${translateY}px) translateX(${translateX}px) scale(${scale});
                        }
                        100% {
                            transform: translateY(0) scale(1);
                        }
                    }
                `;

                // Ajouter la règle @keyframes à la feuille de style
                styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
            },


            // Fonction pour gérer la fin de l'animation
            handleAnimationEnd(event) {
                event.target.style.animationPlayState = 'paused'; 
                event.target.style.animation = 'none';
                const index = parseInt(event.target.getAttribute('data-index'));
                const bubble = this.bubbles[index];

                // Générer de nouvelles valeurs aléatoires pour translateY, translateX et scale
                const newTranslateY = this.getRandomTranslateY();
                const newTranslateX = this.getRandomTranslateX();
                const newScale = this.getRandomScale();
                const color = this.getRandomColor();

                // Mettre à jour les keyframes avec les nouvelles valeurs
                this.injectKeyframes(bubble.animation, newTranslateY, newTranslateX, newScale);

                // Mettre à jour la bulle dans le tableau
                const newDuration = this.getRandomDuration();
                
                // Ensuite, redémarrer l'animation après un petit délai pour la réinitialisation
                setTimeout(() => {
                    event.target.style.backgroundColor = color; // Mettre à jour la couleur de fond
                    // Appliquer la nouvelle animation après le délai
                    event.target.style.animation = `${bubble.animation} ${newDuration}s ease-in-out`; // Réapplique l'animation
                    event.target.style.animationPlayState = 'running'; // Reprendre l'animation
                }, 100); // Délai de 50ms pour forcer le redémarrage de l'animation

                // Mettre à jour les nouvelles transformations dans le tableau
                this.bubbles[index].y = newTranslateY;
                this.bubbles[index].x = newTranslateX;
                this.bubbles[index].s = newScale;
                this.bubbles[index].backgroundColor = color; // Nouvelle couleur de fond
                this.bubbles[index].duration = newDuration; // Nouvelle durée pour l'animation
            },

            // Fonction pour générer une taille aléatoire pour la bulle
            getRandomSize() {
                const width = Math.floor(Math.random() * (50 - 5 + 1) + 5); // Taille entre 15 et 150px
                // if (Math.random() < 0.5) {
                    return { width, height: width };
                // }
                // const height = Math.floor(Math.random() * (width - (width/1.5) + 1) + (width/1.5)); // Taille entre 15 et 150px
                // return { width, height };
            },

            // Fonction pour générer une position aléatoire sur l'écran
            getRandomPosition(index) {
                let top, left;
                let isCollision = true;
                let attempts = 0;

                // Réessayer plusieurs fois pour éviter les collisions
                while (isCollision && attempts < 50) {
                    top = Math.floor(Math.random() * (100 - 5 + 1) + 5);  // Position top entre 0% et 100%
                    left = Math.floor(Math.random() * 100); // Position left entre 0% et 100%
                    isCollision = this.checkCollision(top, left, index); // Vérifier les collisions
                    attempts++;
                }

                return { top, left };
            },

            // Vérifier si la nouvelle position entre en collision avec les bulles existantes
            checkCollision(top, left, index) {
                for (let i = 0; i < index; i++) {
                    const existingBubble = this.bubbles[i];
                    const distance = this.calculateDistance(top, left, existingBubble.position.top, existingBubble.position.left);

                    // Si la distance est inférieure à une certaine valeur (par exemple 10%), on considère qu'il y a collision
                    if (distance < 10) {
                        return true; // Collision
                    }
                }
                return false; // Pas de collision
            },

            // Calculer la distance entre deux points
            calculateDistance(top1, left1, top2, left2) {
                const dx = top1 - top2;
                const dy = left1 - left2;
                return Math.sqrt(dx * dx + dy * dy);
            },

            // Fonction pour générer une durée d'animation aléatoire
            getRandomDuration() {
                return (Math.random() * (12 - 6) + 6).toFixed(2); // Durée entre 6s et 12s
            },

            // Fonction pour générer un border-radius aléatoire
            getRandomBorderRadius() {
                return '50%';
                // const borderRadiusValues = [
                //     '50%', 
                //     '50%',
                //     '50%',
                //     '50%',
                //     '50%',
                //     '50%',
                //     '30% 50% 50% 30%', 
                //     '30% 45% 50% 50%', 
                //     '40% 45% 30% 40%', 
                //     '40% 30% 45% 40%', 
                //     '50% 50% 50% 30%'
                // ];
                // return borderRadiusValues[Math.floor(Math.random() * borderRadiusValues.length)];
            },

            getRandomColor() {
                const colors = [
                    '#26d9e4',
                    '#b730e0',
                    '#ffffff',
                    '#ac297a',
                    '#d68b5b',
                    '#5b8ad6',
                ];
                return colors[Math.floor(Math.random() * colors.length)];
            },

            // Fonction pour générer une valeur translateY aléatoire
            getRandomTranslateY() {
                // Valeur aléatoire entre -30px et 30px
                return Math.floor(Math.random() * (240 - (-240) + 1) + (-240));
            },

            // Fonction pour générer une valeur translateY aléatoire
            getRandomTranslateX() {
                // Valeur aléatoire entre -30px et 30px
                return Math.floor(Math.random() * (240 - (-240) + 1) + (-240));
            },

            // Fonction pour générer un facteur de scale aléatoire
            getRandomScale() {
                // Valeur aléatoire entre 1 et 1.5
                return (Math.random() * (2.8 - (-2.8) + 1) + (-2.8)).toFixed(2);
            }
        },
        mounted() {
            // Générer les bulles au montage du composant
            for (let i = 0; i < this.number; i++) {
                this.getBubbleStyle(i);
            }
        }
    });
};
