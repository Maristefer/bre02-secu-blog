<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class AuthController extends AbstractController
{
    
    //private CSRFTokenManager $ctm;
    
    /*public function __construct()
    {
        $this->ctm = new CSRFTokenManager();
    }*/
    
    public function login() : void
    {
        $this->render("login", []);
    }

    public function checkLogin() : void
    {
        // si j'ai bien un token
        if (isset($_POST['csrf-token'])) //|| !$this->ctm->validateCSRFToken($_POST['csrf_token'])) 
        {
            $tokenManager = new CSRFTokenManager();
            
            //si le token est valide
            if($tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                // si le login est valide => connecter puis rediriger vers la home
                //Vérifie si les champs du formulaire($_POST) "email" et "password" existent 
                if(isset($_POST["email"]) && isset($_POST["password"]))
                {
                    // Nettoyez les entrées utilisateur pour prévenir les attaques XSS
                    //Convertit les caractères spéciaux en entités HTML
                    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
                    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
         
            
                    //j'intancie ma classe UserManager(me permet d'intéragir avec la base de donnée)
                    $userManager = new UserManager();
            
                    //on utilise la méthode findByEmail de UserManager pour trouver 1 utilisateur par son mail
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
                            //$this->redirect("index.php?route=login");
                            var_dump ("password non valide");
                        }
   
                    } 
                    else//si l'id est null le user sera redirigé vers page de connexion
                    {
                        //$this->redirect("index.php?route=login");
                        echo ("pas bon id");
                    }
                }
                else//si le champs email et password n'existent pas le user sera redirigé vers page de connexion
                {
                    //$this->redirect("index.php?route=login");
                    echo ("n'existe pas");
                }
       
            }
            else
            {
                
            }
        
        }
        else
        {
            
        }
    
    }  
    
    public function register() : void
    {
        $this->render("register", []);
    }

    public function checkRegister() : void
    {
        if (isset($_POST['csrf-token'])) 
        {
           $tokenManager = new CSRFTokenManager();
           
           //si le token est valide
            if($tokenManager->validateCSRFToken($_POST["csrf-token"])) //&& $tokenManager->validatePassword($password))
            {
                if($tokenManager->validatePassword($password))
                {
                    if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["username"]) && isset($_POST["confirm-password"])) 
                    {
                    
                        $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
                        $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
                        $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
                        $confirmPassword = htmlspecialchars($_POST["confirm-password"], ENT_QUOTES, 'UTF-8');

        
                
                        $userManager = new UserManager();
                
                        $user = new User($username, $email, password_hash($password, PASSWORD_BCRYPT));

                        $userManager->create($user);
                
                        $_SESSION["user"] = $user;
                
                        $this->redirect("index.php");
    
                    }  
                    else 
                    {
                    $this->redirect("index.php?route=register");
                    }
                }
                else
                {
                    var_dump("format mdp non valide");
                }
            }
            else
            {
              var_dump("token non valide");  
            }
                
        }
        else
        {
            var_dump("token n'existe pas ");
        }

        
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