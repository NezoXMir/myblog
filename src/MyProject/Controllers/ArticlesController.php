<?php 

namespace MyProject\Controllers;
// namespace MyProject\Models\Users\User;

use InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class ArticlesController extends AbstractController
{
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
// Редактирование статьи
public function edit(int $articleId)
{
    $article = Article::getById($articleId);

    if ($article === null) {
        throw new NotFoundException();
    }

    if ($this->user === null) {
        throw new UnauthorizedException();
    }

    if (!empty($_POST)) {
        try {
            $article->updateFromArray($_POST);
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
            return;
        }

        header('Location: /myproject/www/articles/' . $article->getId(), true, 302);
        exit;
    }

    $this->view->renderHtml('articles/edit.php', ['article' => $article]);
}


// Добавление записи в БД
    public function add(): void 
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if(!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e){
                $this->view->renderHtml('articles/add.php', [
                    'error' => $e->getMessage(),
                ]);
                return;
            }
            header('Location: /myproject/www/articles/' . $article->getId(), true, 302);
            exit();
        }


        $this->view->renderHtml('articles/add.php');
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
?>
