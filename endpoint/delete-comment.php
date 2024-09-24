<?php
include("../conn/conn.php");

if (isset($_GET['comment'])) {
    $commentID = $_GET['comment'];

    try {
        $stmt = $conn->prepare("DELETE FROM tbl_comment WHERE tbl_comment_id = :tbl_comment_id");
        $stmt->bindParam('tbl_comment_id', $commentID, PDO::PARAM_INT);
        $stmt->execute();

        $stmtReply = $conn->prepare("DELETE FROM tbl_reply WHERE tbl_comment_id = :tbl_comment_id");
        $stmtReply->bindParam('tbl_comment_id', $commentID, PDO::PARAM_INT);
        $stmtReply->execute();

        echo "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
