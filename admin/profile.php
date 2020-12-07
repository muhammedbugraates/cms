<?php include "includes/admin_header.php"?>
<?php 
    if(isset($_SESSION['username'])){
        $username = escape($_SESSION['username']);
        $query = "SELECT * FROM users WHERE username='{$username}'";
        $select_user_profile_query = mysqli_query($connection, $query);
        if(!$select_user_profile_query){
            die("QUERY FAILED! : " . mysqli_error($connection));
        }
        while($row = mysqli_fetch_array($select_user_profile_query)){
            $user_id = escape($row['user_id']);
            $username = escape($row['username']);
            $user_password = escape($row['user_password']);
            $user_firstname = escape($row['user_firstname']);
            $user_lastname = escape($row['user_lastname']);
            $user_email = escape($row['user_email']);
            $user_image = escape($row['user_image']);
            $user_role = escape($row['user_role']);
        }
    }
?>

<?php 

if(isset($_POST['edit_user'])){
    //    $user_id = $_POST['user_id'];
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $username = escape($_POST['username']);

    //    $post_image = $_FILES['image']['name'];
    //    $post_image_temp = $_FILES['image']['tmp_name'];

    $user_email = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);
    //    $post_date = date('d-m-y');
    //    $post_comment_count = 4;

    //    move_uploaded_file($post_image_temp, "../images/$post_image");


    if(!empty($user_password)){
        $query_password = "SELECT user_password FROM users WHERE username='{$username}'"; 
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);

        $row = mysqli_fetch_array($get_user_query);

        $db_user_password = $row['user_password'];

        if($db_user_password != $user_password){
            $hash_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        }


        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hash_password}' ";
        $query .= "WHERE username = '{$username}' ";

        $edit_user_query = mysqli_query($connection, $query);

        confirmQuery($edit_user_query);
    }
}
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome To Admin
                        <small>Author</small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title">First Name</label>
                            <input type="text" value="<?php echo $user_firstname;?>" class="form-control" name="user_firstname">
                        </div>

                        <div class="form-group">
                            <label for="title">Last Name</label>
                            <input type="text" value="<?php echo $user_lastname;?>" class="form-control" name="user_lastname">
                        </div>


                        <div class="form-group">
                            <label for="post_tags">Username</label>
                            <input type="text" value="<?php echo $username;?>" class="form-control" name="username">
                        </div>

                        <div class="form-group">
                            <label for="post_tags">Email</label>
                            <input type="email" value="<?php echo $user_email;?>" class="form-control" name="user_email">
                        </div>

                        <div class="form-group">
                            <label for="post_tags">Password</label>
                            <input autocomplete="off" type="password" class="form-control" name="user_password">
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"?>
