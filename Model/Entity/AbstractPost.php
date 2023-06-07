<?php

namespace App\Model\Entity;

abstract class AbstractPost
{
    private int $id;
    private string $content;
    private int $author_id;
    private string $creation_date_time;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AbstractPost
     */
    public function setId(int $id): AbstractPost
    {
        $this->id = $id;
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
     * @return AbstractPost
     */
    public function setContent(string $content): AbstractPost
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param int $author_id
     * @return AbstractPost
     */
    public function setAuthorId(int $author_id): AbstractPost
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreationDateTime(): string
    {
        return $this->creation_date_time;
    }

    /**
     * @param string $creation_date_time
     * @return AbstractPost
     */
    public function setCreationDateTime(string $creation_date_time): AbstractPost
    {
        $this->creation_date_time = $creation_date_time;
        return $this;
    }


}