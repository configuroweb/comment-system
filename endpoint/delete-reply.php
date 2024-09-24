<?php
include("../conn/conn.php");

if (isset($_GET['reply'])) {
    $replyID = $_GET['reply'];

    try {
        $stmt = $conn->prepare("DELETE FROM tbl_reply WHERE tbl_reply_id = :tbl_reply_id");
        $stmt->bindParam('tbl_reply_id', $replyID, PDO::PARAM_INT);
        $stmt->execute();

        echo "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: No reply ID provided";
}
