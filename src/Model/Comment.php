<?php

namespace App\Model;

class Comment
{
    protected int $id_comment;
    protected int $article_id;
    protected ?int $user_id;
    protected ?User $user;
    protected string $content;
    protected string $created_at;

    /**
     * @return int
     */
    public function getIdComment(): int
    {
        return $this->id_comment;
    }

    /**
     * @param int $id_comment
     * @return self
     */
    public function setIdComment(int $id_comment): self
    {
        $this->id_comment = $id_comment;

        return $this;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->article_id;
    }

    /**
     * @return self
     */
    public function setArticleId(int $article_id): self
    {
        $this->article_id = $article_id;

        return $this;
    }

    /**
     * @return ?int
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param ?int $user_id
     * @return self
     */
    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return self
     */
    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return ?User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param ?User $user
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
