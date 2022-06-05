<?php 
$articleModel = new ArticleModel;
require 'view/components/articleListItem.php'; 
require 'view/components/header.php'; 
?>
<h1>Articles</h1>
<div id="articleList">
<?php
foreach($articleModel->getAllArticles() as $article) {
    echo artiticleListItem($article['article_id'], $article['name']);
}
?>
</div>
<div class="space-between">
  <div>
    <button class="button" id="pagination_prev" onclick=pagination.prevPage() disabled>Previous</button>
    <span id="page_count"></span>
    <button class="button" id="pagination_next" onclick=pagination.nextPage()>Next</button>
  </div>
  <div>
    <button class="button" onclick="toggleCreateModal()">Create article</button>
    <button class="button" onclick="toggleImportModal()">Import articles</button>
  </div>
</div>

<div id="createModal" class="modal hidden">
  <div class="modalContent">
    <form id="createForm" onsubmit="createArticle(event)">
      <label for="name">Name</label><br>
      <input oninput="disableSave(this.value)" maxlength="32" type="text" id="name" name="name" value=""/><br>
      <label for="origin">Origin</label><br>
      <input maxlength="255" type="url" id="origin" name="origin" value=""/>
      <input id="save" class="button" type="submit" value="Save" disabled/>
    </form>
    <button class="button" onclick="toggleCreateModal()">Cancel</button>
  </div>
</div>

<div id="importModal" class="modal hidden">
  <div class="modalContent">
    <form id="importForm" onsubmit="importArticles(event)">
      <label for="url">Url</label><br>
      <input maxlength="255" type="url" id="url" name="url" value=""/>
      <input id="saveImport" class="button" type="submit" value="Save"/>
    </form>
    <button class="button" onclick="toggleImportModal()">Cancel</button>
  </div>
</div>
<?php require 'view/components/footer.php' ?>
