<?php
// include_once(__DIR__ . "/../core/functions.php");

class AuthorModel
{
    public $user_id;
    public $full_name;
    public $website;
    public $profile_json_text;
    public $image_path;

    function __construct()
    {
        $this->user_id = "";
        $this->full_name = "";
        $this->website = "";
        $this->profile_json_text = "";
        $this->image_path = "";
    }

    // Find user by username
    public static function find($user_id)
    {
        $mysqli = connect();
        $query = "SELECT * FROM authors WHERE user_id = '$user_id' LIMIT 1";

        $result = $mysqli->query($query);

        $author = null;

        if ($row = $result->fetch_assoc()) {
            $author = new AuthorModel();
            $author->user_id = $row['user_id'];
            $author->full_name = $row['full_name'];
            $author->website = $row['website'];
            $author->profile_json_text = $row['profile_json_text'];
            $author->image_path = $row['image_path'];
        }

        $mysqli->close();
        return $author;
    }

    public static function getAll()
    {
        $conn = connect();
        $query = "SELECT * FROM authors";
        $result = $conn->query($query);
        $authorList = array();

        if ($result) {
            foreach ($result as $row) {
                $author = [
                    'user_id' => $row['user_id'],
                    'full_name' => $row['full_name'],
                    'website' => $row['website'],
                    'profile_json_text' => $row['profile_json_text'],
                    'image_path' => $row['image_path']
                ];
                $authorList[] = $author;
            }
        }

        $conn->close();
        return $authorList; 
    }
    public static function updateAuthor($user_id, $full_name, $website, $profile_json_text, $image_path = null) {
        $conn = connect();

        if ($image_path) {
            $stmt = $conn->prepare("UPDATE authors SET full_name = ?, website = ?, profile_json_text = ?, image_path = ? WHERE user_id = ?");
            $stmt->bind_param("ssssi", $full_name, $website, $profile_json_text, $image_path, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE authors SET full_name = ?, website = ?, profile_json_text = ? WHERE user_id = ?");
            $stmt->bind_param("sssi", $full_name, $website, $profile_json_text, $user_id);
        }

        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}
?>
