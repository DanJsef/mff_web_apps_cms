<?php

class ArticleController
{
    private $articleModel;

    function __construct()
    {
        $this->articleModel = new ArticleModel;
    }

    private function nameValid($name)
    {
        if(strlen($name) > 32) {
            return false;
        }
        return true;
    }

    private function contentValid($content)
    {
        if(strlen($content) > 1024) {
            return false;
        }
        return true;
    }

    private function originValid($origin)
    {
        if(filter_var($origin, FILTER_VALIDATE_URL)) {
            return true;
        } 
        return false;
    }

    public function createArticle($data)
    {
        $data['content'] = '';
        if(!$this->nameValid($data['name']) || !$this->originValid($data['origin'])|| !$this->contentValid($data['content'])) {
            http_response_code(422);
            return json_encode(['message' => 'invalid name/origin format']);
        }
        $res = $this->articleModel->createArticle($data['name'], $data['content'], $data['origin']);
        if(!$res) {
            http_response_code(422);
            return json_encode(['message' => 'creation failed']);
        }
        return json_encode(['message' => 'article created', 'payload' => $res]);
    }

    public function getArticle($id)
    {
        $res = $this->articleModel->getArticleById($id);
        if(!$res) {
            http_response_code(404);
            return json_encode(['message' => 'article not found']);
        }
        return json_encode(['message' => 'article found', 'payload' => $res]);
    }

    public function getArticles()
    {
        $res = $this->articleModel->getAllArticlesForApi();
        return json_encode(['articles' => $res]);
    }

    public function removeArticle($id)
    {
        $res = $this->articleModel->removeArticle($id);
        if(!$res) {
            http_response_code(404);
            return json_encode(['message' => 'article not found']);
        }
        return json_encode(['message' => 'article deleted']);
    }

    public function editArticle($id, $data)
    {
        if(!$this->nameValid($data['name']) || !$this->contentValid($data['content'])) {
            http_response_code(422);
            return json_encode(['message' => 'invalid name/content format']);
        }
        $res = $this->articleModel->editArticle($id, $data['name'], $data['content']);
        if(!$res) { 
            http_response_code(404);
            return json_encode(['message' => 'no data affected']);
        }
        http_response_code(200);
        return json_encode(['message' => 'article data changed', 'payload' => $res]);
    }

    public function importArticles($data)
    {
        if(!$this->originValid($data['url'])) {
            http_response_code(422);
            return json_encode(['message' => 'invalid url format']);
        }
        $obj = json_decode(file_get_contents($data['url']), true);
        if(!$obj || !is_array($obj['articles'])) {
            http_response_code(422);
            return json_encode(['message' => 'invalid json']);
        } else {
            foreach($obj['articles'] as $article) {
                if(empty($article['origin'])) {
                    $article['origin'] = $data['url'];
                }
                if(!$this->originValid($article['origin'])) {

                    $article['origin'] = 'https://' . $article['origin'];
                }
                if(!$this->nameValid($article['title']) || !$this->originValid($article['origin'])|| !$this->contentValid($article['content'])) {
                    http_response_code(422);
                    return json_encode(['message' => "import failed on article $article[title]"]);
                }
                $res = $this->articleModel->createArticle($article['title'], $article['content'], $article['origin']);
                if(!$res) {
                    http_response_code(422);
                    return json_encode(['message' => "creation failed on $article[title]"]);
                }
            }
        }
        return json_encode(['message' => 'articles imported']);
    }
}
