<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        global $connection;
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_users)){
            $user_id = escape($row['user_id']);
            $username = escape($row['username']);
            $user_password = escape($row['user_password']);
            $user_firstname = escape($row['user_firstname']);
            $user_lastname = escape($row['user_lastname']);
            $user_email = escape($row['user_email']);
            $user_image = escape($row['user_image']);
            $user_role = escape($row['user_role']);

            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";
            echo "<td>$user_image</td>";
            echo "<td>$user_role</td>";

            //            $query = "SELECT * FROM comments";
            //            $select_comments = mysqli_query($connection, $query);
            //
            //            //            while($row = mysqli_fetch_assoc($select_comments)){
            //            //                $cat_id = $row['cat_id'];
            //            //                $cat_title = $row['cat_title'];
            //            //                echo "<td>{$cat_title}</td>";
            //            //            }
            //
            //
            //            echo "<td>$comment_email</td>";
            //            echo "<td>$comment_status</td>";
            //
            //            $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
            //            $select_post_id_query = mysqli_query($connection, $query);
            //
            //            while($row = mysqli_fetch_assoc($select_post_id_query)){
            //                $post_id = $row['post_id'];
            //                $post_title = $row['post_title'];
            //                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            //            }
            //
            //            echo "<td>$comment_date</td>";
            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
            echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";

        }
        ?>
    </tbody>
</table>


<?php

if(isset($_GET['change_to_admin'])){
    $the_user_id = escape($_GET['change_to_admin']);
    $query = "UPDATE users SET user_role='admin' WHERE user_id=$the_user_id";
    $change_to_admin_query = mysqli_query($connection, $query);
    header("Location: users.php");
}

if(isset($_GET['change_to_sub'])){
    $the_user_id = escape($_GET['change_to_sub']);
    $query = "UPDATE users SET user_role='subscriber' WHERE user_id=$the_user_id";
    $change_to_sub_query = mysqli_query($connection, $query);
    header("Location: users.php");
}

if(isset($_GET['delete'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] == 'admin'){
            $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "DELETE FROM users WHERE user_id={$the_user_id}";
            $delete_user_query = mysqli_query($connection, $query);
            header("Location: users.php");
        }
    }
}
?>