<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment System</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="">Comment System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Edit Comment Modal -->
    <div class="modal fade" id="updateCommentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateCommentForm">
                        <input type="hidden" id="updateCommentID" name="tbl_comment_id">
                        <div class="form-group">
                            <label for="updateCommentator">Name</label>
                            <input type="text" class="form-control" id="updateCommentator" name="commentator" required>
                        </div>
                        <div class="form-group">
                            <label for="updateComment">Comment</label>
                            <textarea class="form-control" id="updateComment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Reply Modal -->
    <div class="modal fade" id="replyCommentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="replyCommentForm">
                        <input type="hidden" id="replyCommentID" name="tbl_comment_id">
                        <p>Replying to: <span id="replyTo"></span></p>
                        <div class="form-group">
                            <label for="replier">Your Name</label>
                            <input type="text" class="form-control" id="replier" name="replier" required>
                        </div>
                        <div class="form-group">
                            <label for="reply">Your Reply</label>
                            <textarea class="form-control" id="reply" name="reply" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateReplyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Reply</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateReplyForm">
                        <input type="hidden" id="updateReplyID" name="tbl_reply_id">
                        <div class="form-group">
                            <label for="updateReplier">Name</label>
                            <input type="text" class="form-control" id="updateReplier" name="replier" required>
                        </div>
                        <div class="form-group">
                            <label for="updateReply">Reply</label>
                            <textarea class="form-control" id="updateReply" name="reply" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Write a Comment</h4>
                        <form action="./endpoint/add-comment.php" method="POST">
                            <div class="form-group">
                                <label for="commentator">Name</label>
                                <input type="text" class="form-control" name="commentator" id="commentator" required>
                            </div>
                            <div class="form-group">
                                <label for="comment">Write Comment</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <button class="btn btn-outline-primary view-comment-button" onclick="viewAllComment()">View All Comments</button>
                    <button class="btn btn-outline-secondary hide-comment-button" onclick="hideAllComment()" style="display:none;">Hide All Comments</button>
                </div>

                <div id="comments-container">
                    <?php
                    include("./conn/conn.php");

                    $stmt = $conn->prepare("SELECT * FROM tbl_comment ORDER BY time_date_comment DESC");
                    $stmt->execute();

                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $commentID = $row["tbl_comment_id"];
                        $commentator = $row["commentator"];
                        $comment = $row["comment"];
                        $tdComment = $row["time_date_comment"];
                    ?>

                        <div class="card mb-3 comment" style="display:none;">
                            <div class="card-body">
                                <input type="hidden" id="commentID-<?= $commentID ?>" value="<?= $commentID ?>">
                                <h5 class="card-title" id="commentator-<?= $commentID ?>"><?= htmlspecialchars($commentator) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted" id="tdComment-<?= $commentID ?>"><?= $tdComment ?></h6>
                                <p class="card-text" id="comment-<?= $commentID ?>"><?= nl2br(htmlspecialchars($comment)) ?></p>

                                <div class="comment-option mt-3">
                                    <button class="btn btn-sm btn-outline-primary mr-2" onclick="replyComment(<?= $commentID ?>)">Reply</button>
                                    <button class="btn btn-sm btn-outline-secondary mr-2" onclick="updateComment(<?= $commentID ?>)">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger mr-2" onclick="deleteComment(<?= $commentID ?>)">Delete</button>
                                    <label class="like">
                                        <input type="checkbox">
                                        <svg id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <path d="M29.845,17.099l-2.489,8.725C26.989,27.105,25.804,28,24.473,28H11c-0.553,0-1-0.448-1-1V13  c0-0.215,0.069-0.425,0.198-0.597l5.392-7.24C16.188,4.414,17.05,4,17.974,4C19.643,4,21,5.357,21,7.026V12h5.002  c1.265,0,2.427,0.579,3.188,1.589C29.954,14.601,30.192,15.88,29.845,17.099z" id="XMLID_254_"></path>
                                            <path d="M7,12H3c-0.553,0-1,0.448-1,1v14c0,0.552,0.447,1,1,1h4c0.553,0,1-0.448,1-1V13C8,12.448,7.553,12,7,12z   M5,25.5c-0.828,0-1.5-0.672-1.5-1.5c0-0.828,0.672-1.5,1.5-1.5c0.828,0,1.5,0.672,1.5,1.5C6.5,24.828,5.828,25.5,5,25.5z" id="XMLID_256_"></path>
                                        </svg>
                                    </label>
                                </div>

                                <?php
                                $stmt = $conn->prepare("SELECT * FROM tbl_reply WHERE tbl_comment_id = ? ORDER BY time_date_reply ASC");
                                $stmt->execute([$commentID]);

                                $result = $stmt->fetchAll();

                                foreach ($result as $row) {
                                    $replyID = $row["tbl_reply_id"];
                                    $replier = $row["replier"];
                                    $reply = $row["reply"];
                                    $tdReply = $row["time_date_reply"];
                                ?>

                                    <div class="reply mt-3">
                                        <input type="hidden" id="replyID-<?= $replyID ?>" name="tbl_reply_id" value="<?= $replyID ?>">
                                        <h6 class="mb-1" id="replier-<?= $replyID ?>"><?= htmlspecialchars($replier) ?></h6>
                                        <small class="text-muted"><?= $tdReply ?></small>
                                        <p class="mt-2" id="reply-<?= $replyID ?>"><?= nl2br(htmlspecialchars($reply)) ?></p>

                                        <div class="comment-option mt-2">
                                            <button class="btn btn-sm btn-outline-secondary mr-2" onclick="updateReply(<?= $replyID ?>)">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger mr-2" onclick="deleteReply(<?= $replyID ?>)">Delete</button>
                                            <label class="like">
                                                <input type="checkbox">
                                                <svg id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path d="M29.845,17.099l-2.489,8.725C26.989,27.105,25.804,28,24.473,28H11c-0.553,0-1-0.448-1-1V13  c0-0.215,0.069-0.425,0.198-0.597l5.392-7.24C16.188,4.414,17.05,4,17.974,4C19.643,4,21,5.357,21,7.026V12h5.002  c1.265,0,2.427,0.579,3.188,1.589C29.954,14.601,30.192,15.88,29.845,17.099z" id="XMLID_254_"></path>
                                                    <path d="M7,12H3c-0.553,0-1,0.448-1,1v14c0,0.552,0.447,1,1,1h4c0.553,0,1-0.448,1-1V13C8,12.448,7.553,12,7,12z   M5,25.5c-0.828,0-1.5-0.672-1.5-1.5c0-0.828,0.672-1.5,1.5-1.5c0.828,0,1.5,0.672,1.5,1.5C6.5,24.828,5.828,25.5,5,25.5z" id="XMLID_256_"></path>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Script JS -->
    <script src="./assets/script.js"></script>
</body>

</html>