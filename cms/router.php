<?php
class Router
{
    private function getId($url)
    {
        return explode('/', $url)[1];
    }

    private function routes($url)
    {
        switch(true) {
        case preg_match('/^$/', $url):
            $to = BASE . 'articles';
            http_response_code(301);
            header("Location: $to");
            break;
        case preg_match("/^articles$/", $url):
            include './view/pages/articles.php';
            break;
        case preg_match('/^article\/[0-9]*$/', $url):
            $id = $this->getId($url);
            include './view/pages/article.php';
            break;
        case preg_match('/^article-edit\/[0-9]*$/', $url):
            $id = $this->getId($url);
            include './view/pages/article_edit.php';
            break;
        case preg_match('/^api(\/|$)/', $url):
            $apiRouter = new ApiRouter;
            $apiRouter->dispatch($url, $_SERVER['REQUEST_METHOD']);
            break;
        default: 
            http_response_code(404);
            include './view/pages/not_found.php';
            break;
        }
    }
    public function dispatch()
    {
        $url = substr($_SERVER['REQUEST_URI'], strlen(BASE)); 
        $url = trim($url, '/'); 

        $this->routes($url);
    }
}
