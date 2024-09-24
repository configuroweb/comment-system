<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['replier'], $_POST['reply'], $_POST['tbl_comment_id'])) {
        $commentID = $_POST['tbl_comment_id'];
        $replier = $_POST['replier'];
        $reply = $_POST['reply'];
        $tdReply = date("Y-m-d H:i:s");

        try {
            $stmt = $conn->prepare("INSERT INTO tbl_reply (tbl_comment_id, replier, reply, time_date_reply) VALUES (:tbl_comment_id, :replier, :reply, :time_date_reply)");

            $stmt->bindParam("tbl_comment_id", $commentID, PDO::PARAM_STR);
            $stmt->bindParam("replier", $replier, PDO::PARAM_STR);
            $stmt->bindParam("reply", $reply, PDO::PARAM_STR);
            $stmt->bindParam("time_date_reply", $tdReply, PDO::PARAM_STR);

            $stmt->execute();

            echo "success";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Missing required fields";
    }
}
