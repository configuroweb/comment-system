<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['commentator'], $_POST['comment'])) {
        $commentID = $_POST['tbl_comment_id'];
        $commentator = $_POST['commentator'];
        $comment = $_POST['comment'];
        $tdComment = date("Y-m-d H:i:s");

        try {
            $stmt = $conn->prepare("UPDATE tbl_comment SET commentator = :commentator, comment = :comment, time_date_comment = :time_date_comment WHERE tbl_comment_id = :tbl_comment_id");
            
            $stmt->bindParam("tbl_comment_id", $commentID, PDO::PARAM_STR);
            $stmt->bindParam("commentator", $commentator, PDO::PARAM_STR);
            $stmt->bindParam("comment", $comment, PDO::PARAM_STR);
            $stmt->bindParam("time_date_comment", $tdComment, PDO::PARAM_STR);

            $stmt->execute();

            echo "
                <script>
                    alert('Comment Added Successfully!');
                    window.location.href = 'http://localhost/comment-system/';
                </script>
            ";
        } catch (PDOException $e) {
            echo "Error:". $e->getMessage();
         }

    } else {
        echo "
            <script>
                alert('Please fill in all fields!');
                window.location.href = 'http://localhost/comment-system/';
            </script>
        ";
    }
}

?>

