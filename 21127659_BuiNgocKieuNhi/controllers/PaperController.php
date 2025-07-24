<?php
require_once 'models/PaperModel.php';
require_once 'models/AuthorModel.php';


class PaperController {

    // Hiển thị danh sách bài báo trên trang chủ (chưa login)
    public function home() {
        $latestPapersByTopic = PaperModel::getLatestPapersByTopic();
        include './views/user/home.php';
    }

    public function listAll() {
        $papers = PaperModel::getAllPapers();
        $topics = PaperModel::getAllTopics(); 
        include './views/papers/list.php';
    }

    public function filter($topic_id) {
        $papers = PaperModel::getPapersByTopic($topic_id);
        include './views/papers/list-ajax.php';
    }

    public function showSearchForm() {
        $topics = PaperModel::getAllTopics(); 
        $conferences = PaperModel::getAllConferences();
        $authors = AuthorModel::getAll();
        include './views/papers/search.php';
    }

    public function search() {
        $keyword = $_GET['keyword'] ?? '';
        $author = $_GET['author'] ?? '';
        $conference = $_GET['conference'] ?? '';
        $topic = $_GET['topic'] ?? '';

        $papers = PaperModel::searchPapers($keyword, $author, $conference, $topic);
        
        // Đây là AJAX, chỉ render phần kết quả
        include(__DIR__ . '/../views/papers/search-result.php');
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
    public function addNewPaper() {
        $user_id = $_SESSION['user_id'] ?? null; // đảm bảo người dùng đã đăng nhập

        if (!$user_id) {
            echo "You must be logged in to add a paper.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $abstract = $_POST['summary'] ?? '';
            $topic_id = $_POST['topic_id'] ?? null;
            $conference_id = $_POST['conference_id'] ?? null;
            $author_ids = $_POST['authors'] ?? [];
            $roles = $_POST['roles'] ?? [];

            // Validate required fields
            if (empty($title) || empty($abstract) || !$topic_id || !$conference_id || empty($author_ids)) {
                echo "Please fill in all required fields.";
                return;
            }

            $author_names = [];
            foreach ($author_ids as $id) {
                $author = AuthorModel::find($id);
                if ($author) {
                    $author_names[] = $author->full_name;
                }
            }

            $author_string_list = implode(", ", $author_names);

            // Thêm vào bảng papers
            $paper_id = PaperModel::insertPaper($title, $abstract, $topic_id, $conference_id, $user_id, $author_string_list);

            // Insert authors
            foreach ($authors as $index => $user_id) {
                $role = $roles[$index] ?? 'Author';
                PaperModel::insertPaperAuthor($paper_id, $user_id, $role);
            }

            header("Location: index.php?action=list-papers");
        } else {
            // Hiển thị lại form nếu là GET
            $topics = PaperModel::getAllTopics();
            $conferences = PaperModel::getAllConferences();
            $authors = AuthorModel::getAll();
            require 'views/papers/add-paper.php';
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