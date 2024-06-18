<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CategoryManager extends AbstractManager
{
    public function __contruct()
    {
        parent:: __construct();
    }
    
    //méthode qui retourne toutes les catégories
    public function findAllCategories(): array
    {
        $categories = [];
        
        $query=$this->db->prepare("SELECT * FROM categories");
        $query->execute();
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        //transforme le résultat de données en Objets Category
        foreach ($result as $item) //Parcourt chaque élément du tableau $result.
        {
            $category = new Category($item["title"]);//crée un nouvel objet Category en utilisant la valeur du champ name de la base de données.
            $category->setId($item["id"]);//Utilise la méthode setId pour assigner l'ID de la catégorie à l'objet Category.

            $categories[] = $category;//Ajoute l'objet Category au tableau $categories.
        }
        
         return $categories;
    }
    
    public function findOneCategory(int $id) : ? Category //retourne la catégorie qui a l'id passé en paramètre, null si elle n'existe pas
     {
         //Prépare une requête SQL pour sélectionner une catégorie en fonction de son identifiant
        $query=$this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        
        // // Récupère les résultats de la requête sous forme de tableau associatif
        $cate = $query->fetch(PDO::FETCH_ASSOC);
        
        if($cate)
        {
            $category = new Category($cate["title"], $cate["description"]);
            $category->setId($cate["id"]);
             return $category;
        }
        else
        {
            // Si aucune donnée n'est trouvée, retourne null
            return null;
        }
        
     }
}