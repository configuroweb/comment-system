// Show all comments
function viewAllComment() {
    document.querySelector(".view-comment-button").style.display = "none";
    document.querySelector(".hide-comment-button").style.display = "";
    document.querySelectorAll(".comment").forEach(comment => comment.style.display = "");
}

// Hide all comments
function hideAllComment() {
    document.querySelector(".view-comment-button").style.display = "";
    document.querySelector(".hide-comment-button").style.display = "none";
    document.querySelectorAll(".comment").forEach(comment => comment.style.display = "none");
}

// Update comment
function updateComment(id) {
    $("#updateCommentModal").modal("show");
    
    let updateCommentID = $("#commentID-" + id).val();
    let updateCommentator = $("#commentator-" + id).text();
    let updateComment = $("#comment-" + id).text();

    $("#updateCommentID").val(updateCommentID);
    $("#updateCommentator").val(updateCommentator);
    $("#updateComment").val(updateComment);
}

// Reply to comment
function replyComment(id) {
    $("#replyCommentModal").modal("show");

    let getCommentID = $("#commentID-" + id).val();
    let getCommentator = $("#commentator-" + id).text();

    $("#replyCommentID").val(getCommentID);
    $("#replyTo").text(getCommentator);
}

// Delete comment
function deleteComment(id) {
    if (confirm('Do you want to delete this comment?')) {
        $.ajax({
            url: './endpoint/delete-comment.php',
            type: 'GET',
            data: { comment: id },
            success: function(response) {
                if(response.trim() === 'success') {
                    $("#commentID-" + id).closest('.comment').remove();
                } else {
                    alert('Failed to delete comment');
                }
            },
            error: function() {
                alert('An error occurred while trying to delete the comment');
            }
        });
    }
}

// Update reply
function updateReply(id) {
    $("#updateReplyModal").modal("show");
    
    let updateReplyID = $("#replyID-" + id).val();
    let updateReplier = $("#replier-" + id).text();
    let updateReply = $("#reply-" + id).text();

    $("#updateReplyID").val(updateReplyID);
    $("#updateReplier").val(updateReplier);
    $("#updateReply").val(updateReply);
}

// Delete reply
function deleteReply(id) {
    if (confirm('Do you want to delete this reply?')) {
        $.ajax({
            url: './endpoint/delete-reply.php',
            type: 'GET',
            data: { reply: id },
            success: function(response) {
                if(response.trim() === 'success') {
                    $("#replyID-" + id).closest('.reply').remove();
                    alert('Reply deleted successfully');
                } else {
                    alert('Failed to delete reply: ' + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred while trying to delete the reply: ' + textStatus + ', ' + errorThrown);
            }
        });
    }
}

$(document).ready(function() {
    // Handle update comment form submission
    $("#updateCommentForm").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: './endpoint/update-comment.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.trim() === 'success') {
                    let id = $("#updateCommentID").val();
                    $("#commentator-" + id).text($("#updateCommentator").val());
                    $("#comment-" + id).html($("#updateComment").val().replace(/\n/g, "<br>"));
                    $("#updateCommentModal").modal("hide");
                } else {
                    alert('Failed to update comment');
                }
            },
            error: function() {
                alert('An error occurred while trying to update the comment');
            }
        });
    });

    // Handle reply form submission
    $("#replyCommentForm").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: './endpoint/add-reply.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.trim() === 'success') {
                    location.reload(); // Reload to show new reply
                } else {
                    alert('Failed to add reply');
                }
            },
            error: function() {
                alert('An error occurred while trying to add the reply');
            }
        });
    });

    // Handle update reply form submission
    $("#updateReplyForm").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: './endpoint/update-reply.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.trim() === 'success') {
                    let id = $("#updateReplyID").val();
                    $("#replier-" + id).text($("#updateReplier").val());
                    $("#reply-" + id).html($("#updateReply").val().replace(/\n/g, "<br>"));
                    $("#updateReplyModal").modal("hide");
                } else {
                    alert('Failed to update reply');
                }
            },
            error: function() {
                alert('An error occurred while trying to update the reply');
            }
        });
    });
});