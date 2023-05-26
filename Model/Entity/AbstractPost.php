<?php

namespace App\Model\Entity;

class AbstractPost
{
    private int $id;
    private string $content;
    private int $author_id;
    private string $creation_date_time;
    private int $likes;
}