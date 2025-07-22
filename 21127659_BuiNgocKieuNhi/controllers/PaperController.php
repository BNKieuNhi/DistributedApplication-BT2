<?php
require_once 'models/PaperModel.php';

class PaperController {

    // Hiển thị danh sách bài báo trên trang chủ (chưa login)
    public function home() {
        $latestPapersByTopic = PaperModel::getLatestPapersByTopic();
        include './views/user/home.php';
    }
    public function listAll() {
        $papers = PaperModel::getAllPapers();
        $topics = PaperModel::getAllTopics(); // dùng để lọc
        include (__DIR__ . "/../views/papers/list.php");
    }
    // Hiển thị danh sách theo topic
    public function listByTopic() {
        $topic_id = $_GET['topic_id'] ?? null;

        $model = new PaperModel();
        $papers = $model->getPapersByTopic($topic_id);
        require 'views/papers/list.php';
    }

    // Trang hiển thị form thêm paper
    public function showAddForm() {
        $model = new PaperModel();
        $topics = $model->getAllTopics();
        $conferences = $model->getAllConferences();
        $authors = $model->getAllAuthors();

        require 'views/papers/add-paper.php';
    }

    // Xử lý thêm paper mới (POST)
    public function addPaper() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $summary = $_POST['summary'] ?? '';
            $topic_id = $_POST['topic_id'] ?? '';
            $conference_id = $_POST['conference_id'] ?? '';
            $author_ids = $_POST['author_ids'] ?? [];
            $author_roles = $_POST['author_roles'] ?? [];

            $model = new PaperModel();
            $paper_id = $model->insertPaper($title, $summary, $conference_id, $topic_id);

            // Thêm các tác giả
            for ($i = 0; $i < count($author_ids); $i++) {
                $model->addAuthorToPaper($paper_id, $author_ids[$i], $author_roles[$i]);
            }

            header("Location: index.php?action=paper-detail&id=$paper_id");
        }
    }

    // Hiển thị chi tiết paper
    public function showDetail() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Paper not found";
            return;
        }

        $model = new PaperModel();
        $paper = $model->getPaperById($id);
        $authors = $model->getAuthorsByPaper($id);

        require 'views/papers/detail-paper.php';
    }

    // Xử lý thêm author vào bài báo (AJAX hoặc POST)
    public function addAuthorToPaper() {
        $paper_id = $_POST['paper_id'] ?? null;
        $author_id = $_POST['author_id'] ?? null;
        $role = $_POST['role'] ?? '';

        $model = new PaperModel();
        $model->addAuthorToPaper($paper_id, $author_id, $role);
        header("Location: index.php?action=paper-detail&id=$paper_id");
    }

    // Xử lý xóa author khỏi bài báo
    public function removeAuthorFromPaper() {
        $paper_id = $_GET['paper_id'] ?? null;
        $author_id = $_GET['author_id'] ?? null;

        $model = new PaperModel();
        $model->removeAuthorFromPaper($paper_id, $author_id);
        header("Location: index.php?action=paper-detail&id=$paper_id");
    }
}
?>