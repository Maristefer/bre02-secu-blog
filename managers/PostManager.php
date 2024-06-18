<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class PostManager extends AbstractManager
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function findLatest() : array //retourne les 4 derniers posts
    {
        $query = $this->db->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT 4");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        
        foreach ($result as $item) 
        {
            $post = new Post($item["title"], $item["excerpt"], $item["content"], $item["author"], DateTime::createFromFormat('Y-m-d H:i:s', $postOne["created_at"]));//new DateTime($item["created_at"])
            $post->setId($item["id"]);
            
            $posts[] = $post;
        }

        return $posts;
    }
    
    public function findOnePost(int $id) : ? Post //retourne le post qui a l'id passé en paramètre, null si il n'existe pas 
    {
        //Prépare une requête SQL pour sélectionner une catégorie en fonction de son identifiant
        $query=$this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        
        // // Récupère les résultats de la requête sous forme de tableau associatif
        $postOne = $query->fetch(PDO::FETCH_ASSOC);
        
        if($postOne)
        {
            $postt = new Post($postOne["title"], $postOne["excerpt"], $postOne["content"], $postOne["author"], DateTime::createFromFormat('Y-m-d H:i:s', $postOne["created_at"]));
            $postt->setId($postOne["id"]);
             return $postt;
        }
        else
        {
            // Si aucune donnée n'est trouvée, retourne null
            return null;
        }
    }
    
    public function findByCategory(int $categoryId)//retourne les posts ayant la catégorie dont l'id est passé en paramètre
    {
        //selectionne toute les colonnes de table posts
        // jointure 1 : la colonne post_id de la table posts_categories doit correspondre à la colonne id de la table posts.
        //jointure 2 : la colonne category_id de la table posts_categories doit correspondre à la colonne id de la table categories.
        //spécifie que seules les lignes où la colonne id de la table categories correspond à une valeur spécifique (:idcategory) doivent être sélectionnées. 
        //:idcategory est un paramètre qui sera remplacé par une valeur spécifique lorsque la requête sera exécutée.
        $query = $this->db->prepare("SELECT posts.* FROM posts  
        JOIN posts_categories ON posts_categories.post_id=posts.id
        JOIN categories ON posts_categories.category_id=categories.id
        WHERE categories.id = :idcategory");
        $parameters = [
            
            "category_id" => $categoryId
            
            ];
        $query->execute($parameters);
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        
        foreach ($result as $item) 
        {
            $post = new Post($item["title"], $item["excerpt"], $item["content"], $item["author"], DateTime::createFromFormat('Y-m-d H:i:s', $item["created_at"]));
            $post->setId($item["id"]);
            
            $posts[] = $post;
        }

        return $posts;
    }
}