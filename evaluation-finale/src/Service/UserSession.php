<?php 

namespace App\Service;

class UserSession {

    public function __construct()
    {
        $this->initSession();
    }

    /**
     * Initialise la session si besoin
     */
    function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Enregistre les données de l'utilisateur connecté en session
     */
    function userSessionRegister(int $id, string $firstname, string $lastname, string $email, string $role)
    {
        $_SESSION['user'] = [
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'role' => $role
        ];
    }

    /**
     * Vérifie si l'utilisateur est connecté
     */
    function isAuthenticated(): bool
    {
        return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
    }

    /**
     * Déconnexion utilisateur
     */
    function logout()
    {
        if ($this->isAuthenticated()) {

            // On efface les données qu'on avait enregistrées
            $_SESSION['user'] = null; // ou bien : unset($_SESSION['user])
            
            // On ferme la session
            session_destroy();
        }
    }


    function getUserFullname(): ?string
    {
        // Si l'utilisateur n'est pas connecté
        if (!$this->isAuthenticated()) {
            return null;
        }

        // S'il est connecté
        return $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
    }


    function getUserId(): ?int 
    {
        // Si l'utilisateur n'est pas connecté
        if (!$this->isAuthenticated()) {
            return null;
        }

        // S'il est connecté
        return $_SESSION['user']['id'];
    }
}