<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;

Class MainController
{
    /** @var View */
    private $view;

    /** @var Db*/
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }
// Главная страница
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}
?>