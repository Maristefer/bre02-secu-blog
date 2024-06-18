<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Post
{
    private ? int $id= null;
    //composition qui correspond au jointure de la base de données.
    //l'attribut de la classe Post à pour attributs aussi les classes User et Category
    private User $user;
    private Category $category;
    

    public function __construct(private string $title, private string $excerpt, private string $content, private int $author, private DateTime $createdAt)
    {
        $this->user = new User(0, "", "", "", "", 0);
        $this->category = new Category(0, "", "");
        
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
    
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }
    
    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    
    public function getAuthor(): int
    {
        return $this->author;
    }
    
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
    
     public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    
    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

}