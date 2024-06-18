<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Comment
{
    private ? int $id= null;
    private User $user;
    private Post $post;
     

    public function __construct(private string $content, private int $userId, private int $postId)
    {
        $this->user = new User(0, "", "", "", "", 0);
        $this->post = new Post(0, "", "", "", 0, 0);
        
    }
    
    public function getId(): ? int //return int|null
    {
        return $this->id;
    }
    
    public function setId(? int $id): void
    {
        $this->id = $id;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    
    public function getUserId(): int
    {
        return $this->userId;
    }
    
    public function setUserId(int $userId): void
    {
        $this->userId = userId;
    }
    
     public function getPostId(): int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): void
    {
        $this->postId = $postId;
    }
    
     public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    
     public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }
    
}