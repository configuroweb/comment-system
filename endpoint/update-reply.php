<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['replier'], $_POST['reply'])) {
        $replyID = $_POST['tbl_reply_id'];
        $replier = $_POST['replier'];
        $reply = $_POST['reply'];
        $tdreply = date("Y-m-d H:i:s");

        try {
            $stmt = $conn->prepare("UPDATE tbl_reply SET replier = :replier, reply = :reply, time_date_reply = :time_date_reply WHERE tbl_reply_id = :tbl_reply_id");
            
            $stmt->bindParam("tbl_reply_id", $replyID, PDO::PARAM_STR);
            $stmt->bindParam("replier", $replier, PDO::PARAM_STR);
            $stmt->bindParam("reply", $reply, PDO::PARAM_STR);
            $stmt->bindParam("time_date_reply", $tdreply, PDO::PARAM_STR);

            $stmt->execute();

            echo "
                <script>
                    alert('Reply Updated Successfully!');
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

