<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Category//classe Category qui correspond à la table `categories` de la base de données.
{
    private ? int $id = null;
    
    public function __construct(private string $title, private string $description)
    {
        
    }
    
    public function getId(): ? int //return int|null
    {
        return $this->id;
    }
    
    public function setId(? int $id): void
    {
        $this->id = $id;
    }
    
    public function getTitle(): string 
    {
        return $this->title;
    }
    
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
     public function getDescription(): string 
    {
        return $this->description;
    }
    
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}