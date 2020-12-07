<?php include "includes/db.php"?>
<?php include "admin/functions.php";?>
<?php include "includes/header.php"?>

<!-- Navigation -->
<?php include "includes/navigation.php"?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php


    if(isset($_POST['submit'])){
        $search = escape($_POST['search']);
        
        
        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
        }else{
            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status='published'";
        }
        
        
        
        $search_query = mysqli_query($connection, $query);
        if(!$search_query){
            die("QUERY FAILED" . mysqli_error($connection));
        }
        $count = mysqli_num_rows($search_query);
        if($count == 0){
            echo "<h1 class='text-center'>No result</h1>";
        }else{
            while($row = mysqli_fetch_assoc($search_query)){
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
                $post_content = escape($row['post_content']);
            ?>

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="#"><?php echo $post_title?></a>
            </h2>
            <p class="lead">
                <?php 
                if(!$thereIsNoPostUser){
                ?>
                    by <a href="author_posts.php?author=<?php echo $post_user;?>&p_id=<?php echo $post_id;?>"><?php echo $post_user;?></a>
                <?php
                }else{
                    echo $post_user;
                }
                ?>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date?></p>
            <hr>
            <img class="img-responsive" src='<?php echo imageController($post_image)?>' alt="">
            <hr>
            <p><?php echo $post_content?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <?php }
        }
    }
            ?>






        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"?>    