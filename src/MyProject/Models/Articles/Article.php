<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

Class Article extends ActiveRecordEntity
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var string */
    protected $authorId;

    /** @var string */
    protected $createdAt;
    
    /** 
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }

    /** 
     * @return string
    */

    public function setName($value) 
    {
        $this->name = $value;
    }

    public function setText($value)
    {
        $this->text = $value;
    }

    public function getText(): string
    {
        return $this->text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    /**
     * @return int
     */

     public function getAuthorId(): int
    {
        return $this->authorId;
    }
    
    /**
     * @return User
     */
    public function getAuthor(): User 
    {
        return User::getById($this->authorId);
    }
    
    /** 
     * @param User $author
     */
    public function setAuthor(User $author): void 
    {
        $this->authorId = $author->getId();
    }
}

?>