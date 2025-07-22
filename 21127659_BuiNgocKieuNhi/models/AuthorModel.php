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
        $mysqli = connect();
        $query = "SELECT * FROM authors";
        $result = $mysqli->query($query);
        $authorList = array();

        if ($result) {
            foreach ($result as $row) {
                $author = new AuthorModel();
                $author->user_id = $row["user_id"];
                $author->full_name = $row["full_name"];
                $author->website = $row["website"];
                $author->profile_json_text = $row["profile_json_text"];
                $author->image_path = $row["image_path"];
                $authorList[] = $author; //add an item into array
            }
        }
        $mysqli->close();
        return $authorList;
    }

}
?>
