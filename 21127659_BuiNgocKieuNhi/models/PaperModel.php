<?php
require_once(__DIR__ . "/../config/config.php");

class PaperModel {
    public $paper_id;
    public $topic_id;
    public $user_id;
    public $conference_id;
    public $author_string_list;
    public $abstract;
    public $title;
    public $conference_name;
    public $conference_abbreviation;
    public $topic_name;
    public $authors = [];

    function __construct()
    {
        $this->paper_id = "";
        $this->topic_id = "";
        $this->user_id = "";
        $this->conference_id = "";
        $this->author_string_list = "";
        $this->abstract = "";
        $this->title = "";
    }

    public static function getAllPapers() {
        $conn = connect();
        $query = "
            SELECT 
                p.*, 
                t.topic_name, 
                c.name AS conference_name
            FROM papers p
            LEFT JOIN topics t ON p.topic_id = t.topic_id
            LEFT JOIN conferences c ON p.conference_id = c.conference_id
            ORDER BY p.paper_id DESC
        ";

        $result = $conn->query($query);
        $paperList = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $paperList[] = $row; // dữ liệu trả về là array dạng assoc
            }
        }

        $conn->close();
        return $paperList;
    }

    public static function getAllTopics() {
        $conn = connect();
        $query = "SELECT * FROM topics";
        $result = $conn->query($query);
        $topicList = array();

        if ($result) {
            foreach ($result as $row) {
                $topic = [
                    'topic_id' => $row['topic_id'],
                    'topic_name' => $row['topic_name']
                ];
                $topicList[] = $topic;
            }
        }

        $conn->close();
        return $topicList;
    }

    public static function getLatestPapersByTopic($limit = 5) {
        $conn = connect();

        // Lấy tất cả các topic
        $topicsQuery = "SELECT * FROM topics";
        $topicsResult = $conn->query($topicsQuery);

        $data = [];

        while ($topic = $topicsResult->fetch_assoc()) {
            $topic_id = $topic['topic_id'];
            $topic_name = $topic['topic_name'];

            // Lấy 5 bài báo mới nhất của mỗi topic
            $papersQuery = "
                SELECT p.*, c.name AS conference_name
                FROM Papers p
                LEFT JOIN Conferences c ON p.conference_id = c.conference_id
                WHERE p.topic_id = $topic_id
                ORDER BY p.paper_id DESC
                LIMIT $limit
            ";

            $papersResult = $conn->query($papersQuery);
            $paperList = [];

            while ($row = $papersResult->fetch_assoc()) {
                $paper = new PaperModel();
                $paper->paper_id = $row["paper_id"];
                $paper->title = $row["title"];
                $paper->author_string_list = $row["author_string_list"];
                $paper->conference_name = $row["conference_name"];
                $paperList[] = $paper;
            }

            $data[] = [
                'topic_name' => $topic_name,
                'papers' => $paperList
            ];
        }

        $conn->close();
        return $data; // Mảng 2 chiều: [ ['topic_name'=>..., 'papers'=>[...] ], ... ]
    }

    // Lấy bài báo theo topic_id
    public function getPapersByTopic($topic_id) {
        global $conn;
        $sql = "SELECT * FROM papers WHERE topic_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $topic_id);
        $stmt->execute();
        return $stmt->get_result();
    }


    // Lấy tất cả hội nghị
    public function getAllConferences() {
        global $conn;
        $sql = "SELECT * FROM conferences";
        return $conn->query($sql);
    }

    // Lấy tất cả tác giả từ bảng AUTHORS (user_id, full_name)
    public function getAllAuthors() {
        global $conn;
        $sql = "SELECT A.user_id, A.full_name, U.username FROM AUTHORS A 
                JOIN USERS U ON A.user_id = U.user_id WHERE U.status = 'active'";
        return $conn->query($sql);
    }

    // Thêm bài báo mới và trả về ID
    public function insertPaper($title, $summary, $conference_id, $topic_id) {
        global $conn;
        $user_id = $_SESSION['user_id']; // Lấy user đang đăng nhập

        // Ghép tên tác giả thành chuỗi, ban đầu tạm thời là username của uploader
        $author_string_list = $this->getUsernameById($user_id);

        $sql = "INSERT INTO PAPERS (title, author_string_list, abstract, conference_id, topic_id, user_id)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $title, $author_string_list, $summary, $conference_id, $topic_id, $user_id);
        $stmt->execute();
        return $conn->insert_id;
    }

    // Lấy thông tin paper theo ID
    public function getPaperById($id) {
        global $conn;
        $sql = "SELECT P.*, C.name AS conference_name, T.topic_name, U.username
                FROM PAPERS P
                JOIN CONFERENCES C ON P.conference_id = C.conference_id
                JOIN TOPICS T ON P.topic_id = T.topic_id
                JOIN USERS U ON P.user_id = U.user_id
                WHERE P.paper_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Lấy danh sách tác giả của bài báo
    public function getAuthorsByPaper($paper_id) {
        global $conn;
        $sql = "SELECT A.full_name, P.role, P.date_added, A.user_id
                FROM PARTICIPATION P
                JOIN AUTHORS A ON P.author_id = A.user_id
                WHERE P.paper_id = ? AND P.status = 'show'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $paper_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Thêm 1 tác giả vào bài báo
    public function addAuthorToPaper($paper_id, $author_id, $role) {
        global $conn;
        $date_added = date('Y-m-d');
        $status = 'show';

        $sql = "INSERT INTO PARTICIPATION (author_id, paper_id, role, date_added, status)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $author_id, $paper_id, $role, $date_added, $status);
        $stmt->execute();
    }

    // Xoá (ẩn) 1 tác giả khỏi bài báo
    public function removeAuthorFromPaper($paper_id, $author_id) {
        global $conn;
        $sql = "UPDATE PARTICIPATION SET status = 'hide'
                WHERE paper_id = ? AND author_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $paper_id, $author_id);
        $stmt->execute();
    }

    // Lấy username từ user_id (dùng khi insert bài báo)
    private function getUsernameById($user_id) {
        global $conn;
        $sql = "SELECT username FROM USERS WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['username'] ?? 'unknown';
    }
    public function searchPapers($keyword = '', $author = '', $conference = '', $topic = '') {
        global $conn;

        $sql = "SELECT P.*, C.name AS conference_name, T.topic_name
                FROM PAPERS P
                JOIN CONFERENCES C ON P.conference_id = C.conference_id
                JOIN TOPICS T ON P.topic_id = T.topic_id
                WHERE 1=1";

        $params = [];
        $types = '';

        // Tiêu chí: từ khóa tiêu đề
        if (!empty($keyword)) {
            $sql .= " AND P.title LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        }

        // Tiêu chí: tên tác giả (dạng chuỗi trong author_string_list)
        if (!empty($author)) {
            $sql .= " AND P.author_string_list LIKE ?";
            $params[] = "%$author%";
            $types .= 's';
        }

        // Tiêu chí: hội nghị
        if (!empty($conference)) {
            $sql .= " AND P.conference_id = ?";
            $params[] = $conference;
            $types .= 'i';
        }

        // Tiêu chí: chủ đề
        if (!empty($topic)) {
            $sql .= " AND P.topic_id = ?";
            $params[] = $topic;
            $types .= 'i';
        }

        // Tiêu chí: khoảng thời gian đăng tải (giả sử có trường `created_at`)
        // if (!empty($fromDate)) {
        //     $sql .= " AND P.created_at >= ?";
        //     $params[] = $fromDate;
        //     $types .= 's';
        // }

        // if (!empty($toDate)) {
        //     $sql .= " AND P.created_at <= ?";
        //     $params[] = $toDate;
        //     $types .= 's';
        // }

        $sql .= " ORDER BY P.paper_id DESC";

        $stmt = $conn->prepare($sql);

        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

}
?>