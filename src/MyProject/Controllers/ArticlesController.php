<?php 

namespace MyProject\Controllers;
// namespace MyProject\Models\Users\User;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;

class ArticlesController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this -> view = new View(__DIR__ . '/../../../templates');
    }
// Данный код отвечает за отображение конкретной статьи
    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);
        // ошибка 404
        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }
// Изменение записи в БД
    public function edit(int $articleId): void
    {
        /** @var Article $article */
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->setName('Новое название Первой статьи');
        $article->setText('Новый текст Первой статьи');

        $article->save();
    }

// Добавление записи в БД
    public function add(): void 
    {
        $author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи ДОБ');
        $article->setText('Новый текст статьи ДОБ');

        $article->save();

        $article->delete();

        var_dump($article);
    }

// Удаление записи из БД
    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            http_response_code(404);
            echo 'Статья была удалена или отсутствовала. Данных нет.';
            return;
        }

        $article->delete();

        var_dump($article);
    }
}
