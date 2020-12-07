<?php include "includes/db.php"?>
<?php include "includes/header.php"?>
<?php include "admin/functions.php";?>

<!-- Navigation -->
<?php include "includes/navigation.php"?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
    $per_page = 5;
if(isset($_GET['page'])){
    $page = escape($_GET['page']);
}else{
    $page = "";
}
if($page == "" || $page == 1){
    $page_1 = 0;
}else{
    $page_1 = ($page * $per_page) - $per_page;
}


if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
    $post_query_count = "SELECT * FROM posts";
}else{
    $post_query_count = "SELECT * FROM posts WHERE post_status='published'";
}




$find_count = mysqli_query($connection, $post_query_count);
$count = mysqli_num_rows($find_count);
if($count < 1){
    echo "<h1 class='text-center'>No posts available</h1>";
}else{


    $count = ceil($count / $per_page);


    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
        $query = "SELECT * FROM posts LIMIT $page_1,$per_page";
    }else{
        $query = "SELECT * FROM posts WHERE post_status='published' LIMIT $page_1,$per_page";
    }



    $select_all_posts_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_all_posts_query)){
        $post_id = escape($row['post_id']);
        $post_title = escape($row['post_title']);


        //not to get error
        $thereIsNoPostUser = false;
        $post_user = escape($row['post_user']);
        //MY CODES
        if(empty($post_user) && !empty(escape($row['post_author']))){
            $post_user = "Unknown Username (Author: " . escape($row['post_author']) . ")";
            $thereIsNoPostUser = true;
        }else if(empty($post_user) && empty(escape($row['post_author']))){
            $post_user = "Unknown Username and Author";
            $thereIsNoPostUser = true;
        }

        $post_date = escape($row['post_date']);
        $post_image = escape($row['post_image']);
        //        $post_content = substr(escape($row['post_content']), 0,100);
        $post_content = strip_tags(substr(escape($row['post_content']), 0,100));
        $post_status = escape($row['post_status']);


            ?>

            <!-- First Blog Post -->
            <!--            <h1><?php //echo $count;?></h1>-->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title?></a>
            </h2>
            <p class="lead">
                <?php 
                if(!$thereIsNoPostUser){
                ?>
                by <a href="author_posts.php?author=<?php echo $post_user?>&p_id=<?php echo $post_id;?>"><?php echo $post_user?></a>
                <?php }else{
                    echo $post_user;
                }?>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
            <hr>
            <a href="post.php?p_id=<?php echo $post_id;?>">
                <img class="img-responsive" src='<?php echo imageController($post_image)?>' alt="">
            </a>
            <hr>
            <p><?php echo $post_content?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
            <?php 
    } 
}
            ?>



        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <ul class="pager">
        <?php
    for($i = 1; $i <= $count; $i++){
        //css settings will be active beacuse of class
        if($i == $page){
            echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
        }else{
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
        }
    }
        ?>
    </ul>

    <?php include "includes/footer.php"?>
