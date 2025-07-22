<?php
require_once 'models/PaperModel.php';

class SearchController {
    public function showSearchPage() {
        require 'views/papers/search.php';
    }

    public function search() {
        $keyword = $_POST['keyword'] ?? '';
        $author = $_POST['author'] ?? '';
        $conference = $_POST['conference'] ?? '';
        $topic = $_POST['topic'] ?? '';
        // $from = $_POST['fromDate'] ?? '';
        // $to = $_POST['toDate'] ?? '';

        $model = new PaperModel();
        $results = $model->searchPapers($keyword, $author, $conference, $topic);

        require 'views/papers/search-result.php';
    }
}
?>