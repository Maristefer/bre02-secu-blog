<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CommentManager extends AbstractManager
{
    public function __construct()
    {
        parent::construct();
    }
    
    public function findByPost(int $postId) : array //retourne les commentaires ayant le post dont l'id est passé en paramètre
    {
        $query = $this->db->prepare("SELECT comments.* FROM comments  
        JOIN posts ON posts.id = comments.post_id
        WHERE posts.id = :idcategory");
        $parameters = [
            
            "post_id" => $postId
            
            ];
        $query->execute($parameters);
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $comments = [];
        
        foreach ($result as $item) 
        {
            $comment = new Comment($item["content"], $item["user_id"], $item["post_id"]);
            $comment->setId($item["id"]);
            $comment->setPostId($item["post_id"]);
            
            $comments[] = $comment;
        }

        return $comments;
    }
    
    public function create(Comment $comment) :void //Insère le commentaire passé en paramètres dans la base de données.
    {
        $query = $this->db->prepare("INSERT INTO comments (NULL, content, user_id, post_id) 
            VALUES (:content, :user_id, :post_id)");
            
        $parameters = [
            'content' => $comment->getContent(),
            'user_id' => $comment->getuserId(),
            'post_id' => $comment->getPostId()
        ];

        $query->execute($parameters);
        
        $comment->setId($this->db->lastInsertId());
    }
}