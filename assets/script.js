function viewAllComment() {
    document.querySelector(".view-comment-button").style.display = "none";
    document.querySelector(".hide-comment-button").style.display = "";
    document.querySelector(".comment").style.display = "";
}

function hideAllComment() {
    document.querySelector(".view-comment-button").style.display = "";
    document.querySelector(".hide-comment-button").style.display = "none";
    document.querySelector(".comment").style.display = "none";
}

function updateComment(id) {
    $("#updateCommentModal").modal("show");
    
    let updateCommentID = $("#commentID-" + id).val();
    let updateCommentator = $("#commentator-" + id).text();
    let updateComment = $("#comment-" + id).text();

    $("#updateCommentID").val(updateCommentID);
    $("#updateCommentator").val(updateCommentator);
    $("#updateComment").val(updateComment);
}

function replyComment(id) {
    $("#replyCommentModal").modal("show");

    let getCommentID = $("#commentID-" + id).val();
    let getCommentator = $("#commentator-" + id).text();

    $("#replyCommentID").val(getCommentID);
    $("#replyTo").text(getCommentator);
}

function deleteComment(id) {
    if (confirm('Do you want to delete this comment?')) {
        window.location = "./endpoint/delete-comment.php?comment=" + id;
    }
}

function updateReply(id) {
    $("#updateReplyModal").modal("show");
    
    let updateReplyID = $("#replyID-" + id).val();
    console.log(updateReplyID);
    let updateReplier = $("#replier-" + id).text();
    let updateReply = $("#reply-" + id).text();

    $("#updateReplyID").val(updateReplyID);
    $("#updateReplier").val(updateReplier);
    $("#updateReply").val(updateReply);
}

function deleteReply(id) {
    if (confirm('Do you want to delete this reply?')) {
        window.location = "./endpoint/delete-reply.php?reply=" + id;
    }
}