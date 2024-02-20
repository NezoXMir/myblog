<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Exceptions\InvalidArgumentException;
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

    public static function createFromArray(array $fields, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не переданано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();
        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();

        return $article;
    }

    public function updateFromArray(array $fields): Article
{
    if (empty($fields['name'])) {
        throw new InvalidArgumentException('Не передано название статьи');
    }

    if (empty($fields['text'])) {
        throw new InvalidArgumentException('Не передан текст статьи');
    }

    $this->setName($fields['name']);
    $this->setText($fields['text']);
    $this->save();

    return $this;
}

}

?>