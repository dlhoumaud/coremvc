<?php
/**
 * @ Author: 
 * @ Create Time: 2024-12-18 08:31:23
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-18 15:42:14
 * @ Description: 
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Error;
use App\Services\APIUserService;

class APIUserController extends Controller
{
    /**
     * Gère le processus de connexion pour les utilisateurs d'API.
     * 
     * Cette méthode vérifie si la méthode de demande est publiée et si l'e-mail et le mot de passe
     * Les paramètres sont définis.Il appelle ensuite la méthode `connex
     * Pour authentifier l'utilisateur.Si la connexion est réussie, elle supprime le mot de passe
     * À partir des données de l'utilisateur, ajoute «API» vers le nom de premier et le nom, formats le
     * Date de naissance, et sortira les données de l'utilisateur.Si la connexion échoue, il publie l'erreur
     * Informations avec le code d'état HTTP approprié.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $user = APIUserService::login();
                if (!isset($user['error'])) {
                    unset($user['password']);
                    // $user['firstname'] .= ' API';
                    // $user['lastname'] .= ' API';
                    $user['birthdate'] = date('d/m/Y', strtotime($user['birthdate']));
                    $user['created_at'] = date('d/m/Y à H:i', strtotime($user['created_at']));
                    self::output($user);
                }
                self::output($user, $user['code']);
            }
            /**
             * En-tête de réponse HTTP avec un code d'erreur de 400, indiquant une mauvaise demande.
             */
            self::output(Error::api(400, 'Bad request'), 400);
        }
        /**
         * En-tête de réponse HTTP avec un code d'erreur 405, indiquant une méthode non autorisée.
         */
        self::output(Error::api(405, 'Method not allowed'), 405);
        
    }

    public function articles($id){
        $articles = APIUserService::getArticles($id);
        self::output($articles);
    }

}