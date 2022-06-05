<?php
$articleModel = new ArticleModel;
$article = $articleModel->getArticleById($id);
?>
<?php if ($article) { include 'view/components/header.php'; ?>
<div>
  <h1><?php echo htmlspecialchars($article['name']) ?></h1>
  <span>Origin: <?php echo htmlspecialchars($article['origin']) ?></span>
</div>
<p><?php echo htmlspecialchars($article['content']) ?></p>
<div>
  <a class="button" href='<?php echo BASE . "article-edit/" . $article['article_id'] ?>'>Edit</a>
  <a class="button" href='<?php echo BASE . "articles" ?>'>Back to articles</a>
</div>
<?php } else {
    include 'view/pages/not_found.php';
} ?>
