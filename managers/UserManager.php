<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findByEmail(string $email): ? User //Retourne l'utilisateur qui a l'email passé en paramètre, null s'il n'existe pas.
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        
        $query->execute([
            
            'email' => $email
            
            ]);

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) 
        {
            $item = new User($user["username"], $user["email"], $user["password"], $user["role"], DateTime::createFromFormat('Y-m-d H:i:s', $user["created_at"]));
            $item->setId($user["id"]);
            
            return $item;
        }

        return null;
    }
    
    public function create(User $user): void //Insère l'utilisateur passé en paramètres dans la base de données.
    {
        $currentDateTime = date('Y-m-d H:i:s');

        $query = $this->db->prepare("
            INSERT INTO users (username, email, password, role, created_at) 
            VALUES (:username, :email, :password, :role, :created_at)
        ");
        $parameters = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'created_at' => $currentDateTime,
        ];

        $query->execute($parameters);

        $user->setId($this->db->lastInsertId());
    }
}