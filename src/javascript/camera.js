let videoStream = null;
let model = null;

// Charger le modèle COCO-SSD au démarrage
async function loadModel() {
    try {
        model = await cocoSsd.load();
        console.log('Modèle COCO-SSD chargé');
        document.getElementById('start-button').disabled = false;
    } catch (err) {
        console.error('Erreur de chargement du modèle :', err);
        alert("Erreur de chargement du modèle. Veuillez réessayer.");
    }
}

// Fonction pour démarrer la caméra
function startCamera() {
    const cameraFeed = document.getElementById('camera-feed');
    const canvas = document.getElementById('prediction-canvas');
    const context = canvas.getContext('2d');

    if (!model) {
        alert("Le modèle n'est pas encore prêt.");
        return;
    }

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            videoStream = stream;
            cameraFeed.srcObject = stream;

            document.getElementById('start-button').disabled = true;
            document.getElementById('stop-button').disabled = false;

            detectObjects(cameraFeed, canvas, context);
        })
        .catch((err) => {
            console.error("Erreur d'accès à la caméra :", err);
            alert("Impossible d'accéder à la caméra. Vérifiez les autorisations.");
        });
}

// Fonction pour arrêter la caméra
function stopCamera() {
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
        videoStream = null;
    }

    document.getElementById('camera-feed').srcObject = null;
    document.getElementById('start-button').disabled = false;
    document.getElementById('stop-button').disabled = true;

    // Effacer le canvas
    const canvas = document.getElementById('prediction-canvas');
    const context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height);
}

// Fonction de détection en continu
async function detectObjects(video, canvas, context) {
    if (!model || !video.videoWidth || !video.videoHeight) {
        requestAnimationFrame(() => detectObjects(video, canvas, context));
        return;
    }

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    try {
        const predictions = await model.detect(video);
        drawPredictions(predictions, context);
    } catch (err) {
        console.error("Erreur pendant la détection :", err);
    }

    requestAnimationFrame(() => detectObjects(video, canvas, context));
}

// Dessiner les prédictions sur le canvas
function drawPredictions(predictions, context) {
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);

    predictions.forEach(pred => {
        const [x, y, width, height] = pred.bbox;

        // Dessin de la boîte
        context.beginPath();
        context.rect(x, y, width, height);
        context.lineWidth = 3;
        context.strokeStyle = '#00ff00';
        context.stroke();

        // Dessin de l'étiquette
        context.font = '16px Arial';
        context.fillStyle = '#00ff00';
        context.fillText(pred.class, x, y > 20 ? y - 10 : y + 20);
    });
}

// Charger le modèle dès le chargement de la page
window.addEventListener('DOMContentLoaded', loadModel);


/* detection du couteaux
function drawPredictions(predictions, context) {
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);

    let isDangerousToolDetected = false;

    predictions.forEach(pred => {
        const [x, y, width, height] = pred.bbox;

        // Dessin de la boîte
        context.beginPath();
        context.rect(x, y, width, height);
        context.lineWidth = 3;
        context.strokeStyle = '#00ff00';
        context.stroke();

        // Dessin de l'étiquette
        context.font = '16px Arial';
        context.fillStyle = '#00ff00';
        context.fillText(pred.class, x, y > 20 ? y - 10 : y + 20);

        // Vérification si un couteau ou un objet dangereux est détecté
        if (pred.class.toLowerCase() === "knife" || pred.class.toLowerCase() === "spoon") {
            isDangerousToolDetected = true; // Marquer comme détecté
        }
    });

    // Si un objet dangereux est détecté, jouer un bip
    if (isDangerousToolDetected) {
        console.log("Dangerous tool detected!");
        alert("Attention: Outil dangereux détecté !");
        // Ajoute un bip ici si tu veux un son
        // Par exemple, jouer un bip sonore
        const beep = new Audio('bip.mp3');
        beep.play();
    }
}*/
