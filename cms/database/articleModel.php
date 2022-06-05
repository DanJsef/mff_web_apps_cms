<?php

class ArticleModel
{
    private $conn;

    function __construct()
    {
        include 'database/connection.php';
        $this->conn = $conn;
    }

    public function getAllArticles()
    {
        $query = "SELECT * FROM articles";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllArticlesForApi()
    {
        $query = "SELECT article_id, name AS title, content, origin FROM articles";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getArticleById($id)
    {
        $id = $this->conn->real_escape_string($id);
        $query = "SELECT * FROM articles WHERE article_id = $id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    public function createArticle($name, $content, $origin)
    {
        $name = $this->conn->real_escape_string($name);
        $content = $this->conn->real_escape_string($content);
        $origin = $this->conn->real_escape_string($origin);
        $query = "INSERT INTO articles (name, content, origin) VALUES ('$name', '$content', '$origin')";
        $this->conn->query($query);
        return $this->conn->insert_id;
    }

    public function removeArticle($id)
    {
        $id = $this->conn->real_escape_string($id);
        $query = "DELETE FROM articles WHERE article_id = $id";
        $result = $this->conn->query($query);
        return $result;
    }

    public function editArticle($id, $name, $content)
    {
        $id = $this->conn->real_escape_string($id);
        $name = $this->conn->real_escape_string($name);
        $content = $this->conn->real_escape_string($content);
        $query = "UPDATE articles SET name = '$name', content = '$content'  WHERE article_id = $id";
        $this->conn->query($query);
        return $this->conn->affected_rows;
    }
}
