<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CSRFTokenManager
{
    public function generateCSRFToken() : string //génération du token CSRF
    {
        $token = bin2hex(random_bytes(32));

        return $token;
    }

    public function validateCSRFToken($token) : bool //Vérifiez la validité du jeton CSRF
    {

        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function validatePassword() : string
    {
        $password = $_POST['password'];
    
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) 
        {
            /*Cette expression régulière vérifie que le mot de passe contient :
            Au moins une lettre minuscule (?=.*[a-z])
            Au moins une lettre majuscule (?=.*[A-Z])
            Au moins un chiffre (?=.*\d)
            Au moins un caractère spécial (?=.*[\W_])
            Au moins 8 caractères au total (.{8,})*/
            
        // Rediriger avec une erreur si le mot de passe ne respecte pas les critères de complexité
        $this->redirect("index.php?route=register&error=invalid_password");
        }
    }
    
}