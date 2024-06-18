<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */
require "config/autoload.php";

session_start();
//si le token n'existe pas dans la session, il va généré un token
if(!isset($_SESSION["csrf_token"]))
{
    $tokenManager = new CSRFTokenManager();
    $token = $tokenManager->generateCSRFToken();
    
    //et va stocké le token dan sla session
    $_SESSION["csrf_token"] = $token;
}



$router = new Router();

$router->handleRequest($_GET);