<?php

class ApiRouter
{

    private $articleController;

    function __construct()
    {
        $this->articleController = new ArticleController;
    }

    private function getId($url)
    {
        return explode('/', $url)[1];
    }

    private function routes($url, $method)
    {
        if(preg_match('/^article$/', $url) && $method === 'POST') {
            echo $this->articleController->createArticle($_POST);
        } else if(preg_match('/^article\/[0-9]*$/', $url) && $method === 'GET') {
            echo $this->articleController->getArticle($this->getId($url));
        } else if(preg_match('/^articles$/', $url) && $method === 'GET') {
            echo $this->articleController->getArticles();
        } else if(preg_match('/^articles$/', $url) && $method === 'POST') {
            echo $this->articleController->importArticles($_POST);
        } else if(preg_match('/^article\/[0-9]*$/', $url) && $method === 'DELETE') {
            echo $this->articleController->removeArticle($this->getId($url));
        } else if(preg_match('/^article-edit\/[0-9]*$/', $url) && $method === 'POST') {
            echo $this->articleController->editArticle($this->getId($url), $_POST);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'endpoint not found']);
        }
    }
    public function dispatch($url, $method)
    {
        $url = substr($url, 4); 
        header('Content-Type: application/json');

        $this->routes($url, $method);
    }
}
