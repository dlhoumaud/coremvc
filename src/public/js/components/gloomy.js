export default (app) => {
    app.component("gloomy", {
        template: `<canvas ref="animationCanvas" id="animationCanvas" width="300" height="300"></canvas>`,

        mounted() {
            const canvas = this.$refs.animationCanvas;
            const scaleFactor = window.devicePixelRatio || 1;
            canvas.width = canvas.width * scaleFactor;
            canvas.height = canvas.height * scaleFactor;
            const gloomy_ctx = canvas.getContext("2d");
            // gloomy_ctx.imageSmoothingEnabled = true;

            if (!canvas || !gloomy_ctx) {
                console.error("Canvas non trouvé !");
                return;
            }

            // Charger les frames avant de démarrer l'animation
            Promise.all([
                loadFrames("assets/images/frames/gloomy-talk", 2),
                loadFrames("assets/images/frames/gloomy-eyes", 2)
            ]).then(([talkFrames, eyesFrames]) => {
                startAnimation(canvas, gloomy_ctx, talkFrames, eyesFrames);
            }).catch(error => {
                console.error("Erreur lors du chargement des frames:", error);
            });
        }
    });
};

// Charger les frames au démarrage du script, une seule fois
function loadFrames(baseName, frameCount) {
    const frames = [];
    const promises = [];

    for (let i = 0; i < frameCount; i++) {
        const img = new Image();
        img.src = `${baseName}-${i}.png`;

        const imgPromise = new Promise((resolve, reject) => {
            img.onload = () => resolve(img); // Résolution de la promesse quand l'image est chargée
            img.onerror = () => reject(`Erreur de chargement : ${img.src}`); // Rejet en cas d'erreur
        });

        frames.push(img); // Ajoute l'image à l'array frames
        promises.push(imgPromise); // Ajoute la promesse à l'array promises
    }

    return Promise.all(promises).then(() => frames); // On attend que toutes les images soient chargées
}

// Fonction pour animer les frames
function playAnimation(frames, gloomy_ctx, canvas, frameRate, callback) {
    let currentFrame = 0;
    let lastFrameTime = 0;
    function animate(timestamp) {
        if (timestamp - lastFrameTime > 1000 / frameRate) {
            gloomy_ctx.clearRect(0, 0, canvas.width, canvas.height);
            gloomy_ctx.drawImage(frames[currentFrame], 0, 0, canvas.width, canvas.height);
            // console.log("NEW Frame dessinée : " + frames[currentFrame].src);
            currentFrame++;

            if (currentFrame >= frames.length) {
                callback(); // Retour à la frame 0 après l'animation "eyes"
                return;
            }
            lastFrameTime = timestamp;
        }
        requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);
}

// Fonction principale pour démarrer l'animation
function startAnimation(canvas, gloomy_ctx, talkFrames, eyesFrames) {
    // Affiche la première frame de "eyes"
    drawSingleFrame(gloomy_ctx, canvas, eyesFrames[0]);
    // Fonction pour vérifier et lancer l'animation "eyes"
    function triggerEyesAnimation() {
        setInterval(() => {
            if (Math.random() < 0.5) {
                // console.log("Animation 'eyes' déclenchée !");
                playAnimation(eyesFrames, gloomy_ctx, canvas, 4, () => {
                    // console.log("Retour à la frame 0 après 'eyes'");
                    // Ajout d'un délai pour simuler un "frameRate" avant de revenir à la frame 0 de "talk"
                    setTimeout(() => {
                        drawSingleFrame(gloomy_ctx, canvas, eyesFrames[0]); // Retourne à la première frame "eyes"
                    }, 1000 / 4); // Délai pour respecter le frameRate
                });
            } else {
                drawSingleFrame(gloomy_ctx, canvas, eyesFrames[0]);
                // console.log("Pas d'animation 'eyes' cette fois.");
            }
        }, 5000); // Vérifie toutes les 5 secondes
    }

    triggerEyesAnimation();
}

// Fonction pour afficher une seule image
function drawSingleFrame(gloomy_ctx, canvas, frame) {
    if (!frame.complete) {
        console.log("L'image n'est pas encore chargée, on attend...");
        return; // On attend si l'image n'est pas prête
    }
    gloomy_ctx.clearRect(0, 0, canvas.width, canvas.height);
    gloomy_ctx.drawImage(frame, 0, 0, canvas.width, canvas.height);
    // console.log("START Frame dessinée : " + frame.src);
}