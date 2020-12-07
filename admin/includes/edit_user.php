<?php

if(isset($_GET['edit_user'])){
    $the_user_id = escape($_GET['edit_user']);

    global $connection;
    $query = "SELECT * FROM users WHERE user_id=$the_user_id";
    $select_users_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_users_query)){
        $user_id = escape($row['user_id']);
        $username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_image = escape($row['user_image']);
        $user_role = escape($row['user_role']);
    }




    if(isset($_POST['edit_user'])){
        //    $user_id = $_POST['user_id'];
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
        $username = escape($_POST['username']);

        //    $post_image = $_FILES['image']['name'];
        //    $post_image_temp = $_FILES['image']['tmp_name'];

        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);
        //    $post_date = date('d-m-y');
        //    $post_comment_count = 4;

        if(!empty($user_password)){
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id"; 
            $get_user_query = mysqli_query($connection, $query_password);
            confirmQuery($get_user_query);

            $row = mysqli_fetch_array($get_user_query);

            $db_user_password = escape($row['user_password']);

            if($db_user_password != $user_password){
                $hash_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }

            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_password = '{$hash_password}' ";
            $query .= "WHERE user_id = {$the_user_id} ";

            $edit_user_query = mysqli_query($connection, $query);

            confirmQuery($edit_user_query);

            echo "User updated" . " <a href='users.php'>View Users</a>";
        }
    }
}else{
    header("Location: index.php");
}
?>


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
        <select name="user_role" id="">
            <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
            <?php 
            if($user_role == 'admin'){
                echo "<option value='subscriber'>subscriber</option>";
            }else{
                echo "<option value='admin''>admin</option>";
            }
            ?>
        </select>
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
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>