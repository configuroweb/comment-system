<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['commentator'], $_POST['comment'])) {
        $commentator = $_POST['commentator'];
        $comment = $_POST['comment'];
        $tdComment = date("Y-m-d H:i:s");

        try {
            $stmt = $conn->prepare("INSERT INTO tbl_comment (commentator, comment, time_date_comment) VALUES (:commentator, :comment, :time_date_comment)");
            
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

