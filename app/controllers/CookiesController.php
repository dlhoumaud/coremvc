<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-29 12:30:46
 * @ Description: Controller pour la gestion  des cookies
 */
namespace App\Controllers;

use App\Core\Controller;

class CookiesController extends Controller
{
    public function setCookieConsent() {
        // Vérifier que la méthode HTTP est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json'); // Définir le type de réponse JSON
            
            // Récupérer la valeur envoyée via POST
            $consent = filter_input(INPUT_POST, 'consent', FILTER_SANITIZE_STRING);

            // Validation de la valeur
            if ($consent === 'accepted' || $consent === 'declined') {
                // Définir le cookie pour une durée d'un an
                if (setcookie('cookie_consent', $consent, time() + (365 * 24 * 60 * 60), "/")) {
                    echo json_encode(['status' => 'success', 'message' => 'Consentement enregistré']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Impossible de définir le cookie']);
                }
            } else {
                // Erreur si la valeur est invalide
                echo json_encode(['status' => 'error', 'message' => 'Valeur de consentement invalide']);
            }
        } else {
            // Réponse pour une méthode autre que POST
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['status' => 'error', 'message' => 'Méthode HTTP non autorisée']);
        }
        exit; // Arrêter le script après avoir renvoyé la réponse
    }
}
