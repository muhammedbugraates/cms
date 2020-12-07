<?php include "includes/db.php";?>
<?php include "admin/functions.php";?>

<?php

if(isset($_POST['params'])){
    echo "Success";
    exit();
}


if(isset($_POST['liked'])){

    echo "Processing.. ";

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $postAndUserExist = postAndUserExist($post_id, $user_id);

    if($postAndUserExist){

        //select the post
        $query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id=$post_id";
        $result = mysqli_query($connection, $query);

        if($result){
            $post_already_liked = mysqli_num_rows($result) > 0;

            if(!$post_already_liked){

                //select the post
                $query = "SELECT * FROM posts WHERE post_id=$post_id";
                $postResult = mysqli_query($connection, $query);

                if($postResult){
                    $post = mysqli_fetch_array($postResult);

                    $likes = $post['likes'];

                    //update incrementing with likes
                    mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id = $post_id");

                    //create likes for post
                    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");

                    echo "Like was completed for post id: " . $post_id;

                }else{
                    echo mysqli_error($connection);
                }
            }else{
                echo "Post already liked for post_id: " . $post_id . " and user_id: " . $user_id;
            }
        }else{
            echo mysqli_error($connection);
        }
    }else{
        //Error messages are already in the postAndUserExist() function
    }

    exit();
}
if(isset($_POST['unliked'])){

    echo "Processing.. ";

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $postAndUserExist = postAndUserExist($post_id, $user_id);

    if($postAndUserExist){
        //select the post
        $query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id=$post_id";
        $result = mysqli_query($connection, $query);

        if($result){
            $post_already_unliked = mysqli_num_rows($result) == 0;

            if(!$post_already_unliked){

                //select the post
                $query = "SELECT * FROM posts WHERE post_id=$post_id";
                $postResult = mysqli_query($connection, $query);

                if($postResult){

                    $post = mysqli_fetch_array($postResult);

                    $likes = $post['likes'];

                    //update decrementing with likes
                    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id = $post_id");

                    //delete from likes table
                    mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");

                    echo "Unlike was completed for post id: " . $post_id;

                }else{
                    echo mysqli_error($connection);
                }
            }else{
                echo "Post already unliked for post_id: " . $post_id . " and user_id: " . $user_id;
            }
        }else{
            echo mysqli_error($connection);
        }
    }else{
        //Method inclues error messages.
    }

    exit();
}
?>

<?php include "includes/header.php";?>

<!-- Navigation -->
<?php include "includes/navigation.php";?>



<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php
            if(isset($_GET['p_id'])){
                $the_post_id = escape($_GET['p_id']);

                $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id={$the_post_id}";
                $send_query = mysqli_query($connection, $query);

                if(!$send_query){
                    die("Query failed : " . mysqli_error($connection));
                }

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    $query = "SELECT * FROM posts WHERE post_id=$the_post_id";
                }else{
                    $query = "SELECT * FROM posts WHERE post_id=$the_post_id AND post_status='published'";
                }


                $select_all_posts_query = mysqli_query($connection, $query);


                if(mysqli_num_rows($select_all_posts_query) < 1){
                    echo "<h1 class='text-center'>No posts available</h1>";
                }else{


                    while($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $post_title = escape($row['post_title']);
                        $post_author = escape($row['post_user']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = escape($row['post_content']);
            ?>


            <h1 class="page-header">
                Posts
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="#"><?php echo $post_title?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
            <hr>
            <img class="img-responsive" src='<?php echo imageController($post_image)?>' alt="">
            <hr>
            <p><?php echo $post_content?></p>

            <?php
                //freeing result
            ?>

            <hr>
            <?php if(isLoggedIn()){ ?>

            <!--            LIKE BUTTON-->


            <div class="row testSize" id="">
                <div class="pull-right" id="like_button_div">
                    <div class='loader pull-right'></div>
                </div>
            </div>


            <?php }else{?>

            <div class="row">
                <p class="pull-right likes">You need to <a href="login.php">login</a> to like</p>
            </div>

            <?php }?>


            <div class="row">
                <p class="pull-right like_number">Likes: <?php getPostLikes($the_post_id);?></p>
            </div>

            <div class="clearfix"></div>

            <?php }?>

            <!-- Blog Comments -->
            <?php
                    if(isset($_POST['create_comment'])){

                        $the_post_id = escape($_GET['p_id']);

                        $comment_author = escape($_POST['comment_author']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";

                            $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                            $create_comment_query = mysqli_query($connection, $query);
                            if(!$create_comment_query){
                                die('QUERY FAILED : ' . mysqli_error($connection));
                            }

                            //                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                            //                    $query .= "WHERE post_id=$the_post_id ";
                            //                    $update_comment_count = mysqli_query($connection, $query);

                        }else{
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }
                    }
            ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="Author">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->


            <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                    $query .= "AND comment_status='approved' ";
                    $query .= "ORDER BY comment_id DESC";
                    $select_comment_query = mysqli_query($connection, $query);
                    if(!$select_comment_query){
                        die('QUERY FAILED : ' . mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_assoc($select_comment_query)){
                        $comment_date = escape($row['comment_date']);
                        $comment_content = escape($row['comment_content']);
                        $comment_author = escape($row['comment_author']);
            ?>

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author;?>
                        <small><?php echo $comment_date;?></small>
                    </h4>
                    <?php echo $comment_content;?>
                </div>
            </div>

            <?php }} }else{
                header("Location: index.php");
            }?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"?>

    <script src="js/jquery2.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script>

    </script>

    <script> 
        $(document).ready(function(){

            //buttons and loading for like system
            var like_button1 = "<button type='button' class='like_button1 pull-right  btn btn-primary' data-toggle='tooltip' data-placement='top' title='Do you want to like it?'><span class='glyphicon glyphicon-thumbs-up' ></span> Like </button>";

            var like_button2 = "<button type='button' class='like_button2 pull-right  btn btn-danger' data-toggle='tooltip' data-placement='top' title='Do you want to unlike it?'><span class='glyphicon glyphicon-thumbs-down' ></span> Unlike </button>";

            //            var loading = "<p class='loading pull-right'>Loading...</p>";
            var loading = "<div class='loader pull-right'></div>";


            //hold previous data values to compare new one if there is a change.
            var like_status_temp;
            var like_number_temp;

            //this function is called every half second
            function updateLikeButton(){
                $.get("admin/functions.php?livelikes=result&post_id=<?php echo $the_post_id;?>", function(data){
                    if(like_number_temp != data){
                        like_number_temp = data;
                        $(".like_number").empty();
                        $(".like_number").append("Likes: " + data);
                    }
                });
                $.get("admin/functions.php?userliked=result&post_id=<?php echo $the_post_id;?>", function(data){
                    if(like_status_temp != data){
                        like_status_temp = data;
                        $("#like_button_div").empty();

                        if(data == "liked"){
                            $("#like_button_div").append(like_button2);
                        }else if(data == "unliked"){
                            $("#like_button_div").append(like_button1);
                        }else{
                            $("#like_button_div").append(loading);
                        }
                    }
                });
            }
            setInterval(function(){
                updateLikeButton();
            },500);






            $("[data-toggle='tooltip']").tooltip();
            var post_id = <?php echo $the_post_id;?>;
            var user_id = <?php echo loggedInUserId()?>;


            $("#like_button_div").click(function(e){
                var _loading = $("#like_button_div > .loading").length == 1;
                var _likeRequest = $("#like_button_div > .like_button1").length == 1;
                var _unlikeRequest = $("#like_button_div > .like_button2").length == 1;

                //Show loading..
                $("#like_button_div").empty().append(loading);

                if(_likeRequest){
                    console.log("Like request is sending..");
                    //create params object
                    var params = "liked=1&post_id=" + post_id + "&user_id=" + user_id;

                    sendRequest(params);

                }else if(_unlikeRequest){
                    console.log("Unlike request is sending..");

                    //create params object
                    var params = "unliked=1&post_id=" + post_id + "&user_id=" + user_id;

                    sendRequest(params);
                }


                function sendRequest(params){
                    $.ajax({
                        type: "POST",
                        url: "post.php",
                        data: params
                    }).done(function(data){
                        console.log(data);
                    })
                }
            });
        });
    </script>



