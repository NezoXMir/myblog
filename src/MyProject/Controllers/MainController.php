<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;

Class MainController extends AbstractController
{

    /** @var Db*/
    private $db;

// Главная страница
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}
?>