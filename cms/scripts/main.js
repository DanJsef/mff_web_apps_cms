class Pagination {
  currentPage = 1;
  articles = document.getElementsByClassName("articleListItem");
  maxPage = Math.ceil(this.articles.length / 10);
  prevButton = document.getElementById("pagination_prev");
  nextButton = document.getElementById("pagination_next");
  pageCount = document.getElementById("page_count");

  updatePageCount() {
    this.pageCount.innerText = this.currentPage + "/" + this.maxPage;
  }

  showPage(page) {
    for (let i = 0; i < 10; ++i) {
      let idx = i + (page - 1) * 10;
      if (this.articles[idx]) this.articles[idx].classList.remove("hidden");
    }
    if (this.currentPage == this.maxPage)
      this.nextButton.setAttribute("disabled", true);
    if (this.currentPage == 1) this.prevButton.setAttribute("disabled", true);
  }

  hidePage(page) {
    for (let i = 0; i < 10; ++i) {
      let idx = i + (page - 1) * 10;
      if (this.articles[idx]) this.articles[idx].classList.add("hidden");
    }
  }

  nextPage() {
    this.prevButton.removeAttribute("disabled");
    this.hidePage(this.currentPage);
    ++this.currentPage;
    this.showPage(this.currentPage);
    this.updatePageCount();
  }

  prevPage() {
    this.nextButton.removeAttribute("disabled");
    this.hidePage(this.currentPage);
    --this.currentPage;
    this.showPage(this.currentPage);
    this.updatePageCount();
  }

  update() {
    this.maxPage = Math.ceil(this.articles.length / 10);
    if (this.maxPage == 0) this.maxPage = 1;
    if (this.maxPage < this.currentPage && this.currentPage != 1)
      this.prevPage();
    else this.showPage(this.currentPage);
    this.updatePageCount();
  }

  init() {
    for (let i = 0; i < this.articles.length; ++i) {
      this.articles[i].classList.add("hidden");
    }
    this.update();
  }
}

function constructUrl(url) {
  if (document.location.host == "localhost:8080") return "/" + url;
  else return "/~11238123/cms/" + url;
}

let pagination = new Pagination();
if (document.location.pathname == constructUrl("articles")) {
  pagination.init();
}

function remove(id) {
  fetch(constructUrl("api/article/") + id, { method: "DELETE" })
    .then((response) => response.json())
    .then(() => {
      document.querySelector("[data-id='" + id + "']").remove();
      pagination.update();
    })
    .catch((error) => console.log(error));
}

function toggleCreateModal() {
  document.getElementById("createModal").classList.toggle("hidden");
  document.getElementById("createForm").reset();
  document.getElementById("save").setAttribute("disabled", true);
}

function toggleImportModal() {
  document.getElementById("importModal").classList.toggle("hidden");
  document.getElementById("importForm").reset();
}

function disableSave(value) {
  if (value.trim() == "")
    document.getElementById("save").setAttribute("disabled", true);
  else document.getElementById("save").removeAttribute("disabled");
}

function createArticle(e) {
  e.preventDefault();
  let formData = new FormData(document.getElementById("createForm"));
  fetch(constructUrl("api/article"), { method: "POST", body: formData })
    .then(async (response) => {
      if (!response.ok) {
        error = await response.json();
        throw new Error(error.message);
      } else return response.json();
    })
    .then((result) => {
      window.location.href = constructUrl("article-edit/" + result.payload);
    })
    .catch((error) => alert(error));
}

function editArticle(e, id) {
  e.preventDefault();
  let formData = new FormData(document.querySelector("form"));
  fetch(constructUrl("api/article-edit/" + id), {
    method: "POST",
    body: formData,
  })
    .then(async (response) => {
      if (!response.ok) {
        error = await response.json();
        throw new Error(error.message);
      } else return response.json();
    })
    .then(() => {
      window.location.href = constructUrl("articles");
    })
    .catch((error) => console.log(error));
}

function importArticles(e) {
  e.preventDefault();
  let formData = new FormData(document.getElementById("importForm"));
  fetch(constructUrl("api/articles"), { method: "POST", body: formData })
    .then(async (response) => {
      if (!response.ok) {
        error = await response.json();
        throw new Error(error.message);
      } else return response.json();
    })
    .then(() => {
      window.location.href = constructUrl("articles");
    })
    .catch((error) => alert(error));
}
