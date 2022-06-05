<?php
$articleModel = new ArticleModel;
$article = $articleModel->getArticleById($id);
?>
<?php if ($article) { include 'view/components/header.php'; ?>
<h1>Editing: <?php echo htmlspecialchars($article['name']) ?></h1>
    <form id="editForm" onsubmit="editArticle(event, <?php echo $id ?> )">
  <div>
    <label for="name">Name</label><br>
    <input oninput="disableSave(this.value)" maxlength="32" type="text" id="name" name="name" value="<?php echo $article['name'] ?>"/><br>
  </div>
  <div>
    <label for="content">Content</label><br>
    <textarea maxlength="1024" id="content" name="content" ><?php echo $article['content'] ?></textarea>
  </div>
  <div>
    <input id="save" class="button" type="submit" value="Save"/>
        <a class="button" href="<?php echo BASE . "articles" ?>">Back to articles</a>
  </div>
</form>
    <?php include 'view/components/footer.php'; 
} else {
    include 'view/pages/not_found.php';
} ?>
