<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class AuthController extends AbstractController
{
    public function login() : void
    {
        $this->render("login", []);
    }

    public function checkLogin() : void
    {
        
        // Vérifiez la validité du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $this->redirect("index.php?route=login&error=invalid_csrf");
        return;
    }
    
        // si le login est valide => connecter puis rediriger vers la home
        //Vérifie si les champs du formulaire($_POST) "email" et "password" existent 
        if(isset($_POST["email"]) && isset($_POST["password"]))
        {
            // Nettoyez les entrées utilisateur pour prévenir les attaques XSS
            $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
         
            if (empty($_SESSION['csrf_token'])) 
            {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            
            //j'intancie ma classe UserManager(me permet d'intéragir avec la base de donnée)
            $userManager = new UserManager();
            
            //on utilise la méthode findOne de UserManager pour trouver 1 utilisateur par son mail
            $user = $userManager->findByEmail($_POST["email"]);
        
            if ($user->getId() !== null) //vérifie si l'id de l'utilisateur n'est pas null
            {
                //Vérifie si le mot de passe soumis correspond à celui stocké dans la base de données
                if (password_verify($_POST["password"], $user->getPassword())) 
                {
                // Si tout le mdp est bon, le user est stocker dans $_SESSION pour indiqué q'il est connecté
                $_SESSION["user"] = $user;
                
                // $this->redirect("index.php");
                $this->redirect("index.php");
            
                }
                else// si mauvaise code le user est redirigé vers la page de connexion 
                {
                    // sinon rediriger vers login
                    $this->redirect("index.php?route=login");
                    
                }
   
            } 
            else//si l'id est null le user sera redirigé vers page de connexion
            {
                $this->redirect("index.php?route=login");
                
            }
        }
        else//si le champs email et password n'existent pas le user sera redirigé vers page de connexion
        {
            $this->redirect("index.php?route=login");
        }
       
    
    }  
    
}

    public function register() : void
    {
        $this->render("register", []);
    }

    public function checkRegister() : void
    {
        // si le register est valide => connecter puis rediriger vers la home
        // $this->redirect("index.php");

        // sinon rediriger vers register
        // $this->redirect("index.php?route=register");
    }

    public function logout() : void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}