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

    public static function getAllConferences() {
        $conn = connect();
        $query = "SELECT * FROM conferences";
        $result = $conn->query($query);
        $conferenceList = array();

        if ($result) {
            foreach ($result as $row) {
                $conference = [
                    'conference_id' => $row['conference_id'],
                    'name' => $row['name'],
                    'abbreviation' => $row['abbreviation'],
                    'rank' => $row['rank'],
                    'start_date' => $row['start_date'],
                    'end_date' => $row['end_date'],
                    'type' => $row['type']
                ];
                $conferenceList[] = $conference;
            }
        }

        $conn->close();
        return $conferenceList;
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
    public static function getPapersByTopic($topic_id) {
        $conn = connect();
        $topic_id = intval($topic_id); // bảo vệ an toàn dữ liệu

        $query = "
            SELECT p.*, t.topic_name, c.name AS conference_name
            FROM papers p
            LEFT JOIN topics t ON p.topic_id = t.topic_id
            LEFT JOIN conferences c ON p.conference_id = c.conference_id
            WHERE p.topic_id = $topic_id
            ORDER BY p.paper_id DESC
        ";

        $result = $conn->query($query);
        $paperList = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $paperList[] = $row;
            }
        }

        $conn->close();
        return $paperList;
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

    public static function searchPapers($keyword, $author, $topic_id, $conference_id) {
        $conn = connect();
        $sql = "SELECT p.*, t.topic_name, c.name AS conference_name 
                FROM papers p 
                LEFT JOIN topics t ON p.topic_id = t.topic_id 
                LEFT JOIN conferences c ON p.conference_id = c.conference_id 
                WHERE 1=1 ";

        if (!empty($keyword)) {
            $sql .= " AND p.title LIKE '%" . $conn->real_escape_string($keyword) . "%'";
        }
        if (!empty($author)) {
            $sql .= " AND p.author_string_list LIKE '%" . $conn->real_escape_string($author) . "%'";
        }
        if (!empty($topic_id) && $topic_id !== "Select topic") {
            $sql .= " AND p.topic_id = '" . $conn->real_escape_string($topic_id) . "'";
        }
        if (!empty($conference_id) && $conference_id !== "Select conference") {
            $sql .= " AND p.conference_id = '" . $conn->real_escape_string($conference_id) . "'";
        }

        $sql .= " ORDER BY p.paper_id DESC";

        $result = $conn->query($sql);
        $paperList = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $paperList[] = $row;
            }
        }

        $conn->close();
        return $paperList;
    }

    public static function insertPaper($title, $abstract, $topic_id, $conference_id, $user_id, $author_string_list) {
        $conn = connect();
        $stmt = $conn->prepare("INSERT INTO papers (title, abstract, topic_id, conference_id, user_id, author_string_list) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiis", $title, $abstract, $topic_id, $conference_id, $user_id, $author_string_list);
        $stmt->execute();
        $paper_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        return $paper_id;
    }


    public static function insertPaperAuthor($paper_id, $user_id, $role) {
        $conn = connect();
        $stmt = $conn->prepare("INSERT INTO participation (paper_id, author_id, role) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $paper_id, $user_id, $role);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}
?>