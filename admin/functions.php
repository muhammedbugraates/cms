<?php 

//========= DATABASE HELPER FUNCTIONS ======//
function redirect($location){
    return header("Location: " . $location);
    exit;
}

function query($query_param){
    global $connection;
    //because of some problems abour ob_Start etc.
    if(!$connection){
        include "../includes/db.php";
    }

    $result = mysqli_query($connection, $query_param);

    confirmQuery($result);
    return $result;
}

function confirmQuery($result){
    global $connection;

    if(!$result){

        die("Query failed : " . mysqli_error($connection));
                        echo "SAY HELLO";

    }
    
}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}

function count_records($result){
    return mysqli_num_rows($result);
}

//==========END DATABASE HELPERS========//
//==========GENERAL HELPERS=======//

function get_user_name(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

//==========END GENERAL HELPERS=======//

//==========USER SPECIFIC HELPERS=======//

function get_all_user_posts(){
    return query("SELECT * FROM posts WHERE user_id = '" . loggedInUserId() ."'");
}

function get_all_posts_user_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id = " . loggedInUserId());
}


function get_all_user_categories(){
    return query("SELECT * FROM categories WHERE user_id = " . loggedInUserId());

}

function get_all_user_published_posts(){
    return query("SELECT * FROM posts WHERE user_id = '" . loggedInUserId() ."' AND post_status = 'published'");
}

function get_all_user_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id = '" . loggedInUserId() ."' AND post_status = 'draft'");
}

function get_all_user_approved_posts_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id = " . loggedInUserId() . " AND comments.comment_status='approved'");
}

function get_all_user_unapproved_posts_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id = " . loggedInUserId() . " AND comments.comment_status='unapproved'");
}
//==========END USER SPECIFIC HELPERS=======//

//==========AUTHENTICATION HELPER=======//

function is_admin(){
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id=" . $_SESSION['user_id'] );

        $row = fetchRecords($result);
        if($row['user_role'] == 'admin'){
            return true;
        }else{
            return false;
        }
    }

    return false;
}





function imagePlaceholder($image=''){
    if(!$image || empty($image)){
        //cms project image
        return 'image_1.jpg';
    }else{
        return $image;
    }
}



function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}



function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    echo mysqli_num_rows($result);
}







function loggedInUserId(){
    
    if(isLoggedIn()){

        $username = $_SESSION['username'];
        $my_query = "SELECT * FROM users WHERE username='$username'";
        $result = query($my_query);
        $user = mysqli_fetch_array($result);
        if(mysqli_num_rows($result) >= 1){
            return $user['user_id'];

        }else{
            return false;
        }
    }
    return false;
}




function userLikedThisPost($post_id = ''){
    $result = query("SELECT * FROM likes WHERE user_id=" . loggedInUserId() . " AND post_id=" . $post_id);
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}










function userLikedWithGet(){
    
    
    if(isset($_GET['userliked'])){

        //IT IS VERY IMPORTANT
        global $connection;
        if(!$connection){
            if(session_status() != PHP_SESSION_ACTIVE){
                session_start();
            }
        }
        $my_user_id = loggedInUserId();


        $post_id = $_GET['post_id'];
        $my_query = "SELECT * FROM likes WHERE user_id=" . $my_user_id . " AND post_id=" . $post_id;


        $result = query($my_query);
        echo $status = mysqli_num_rows($result) >= 1 ? 'liked' : 'unliked';
    } 
}
userLikedWithGet();











function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function currentUser(){
    if(isset($_SESSION['username'])){
        return $_SESSION['username'];
    }else{
        return false;
    }
}





function liveLikes(){
    if(isset($_GET['livelikes'])){

        //IT IS VERY IMPORTANT
        global $connection;
        if(!$connection){
            if(session_status() != PHP_SESSION_ACTIVE){
                session_start();
            }
        }

        $post_id = $_GET['post_id'];
        $my_query = "SELECT * FROM likes WHERE post_id=" . $post_id;


        $result = query($my_query);
        echo $numberOfLikes = mysqli_num_rows($result);
    } //get request isset
}

liveLikes();





function users_online(){
    if(isset($_GET['onlineusers'])){
        global $connection;
        if(!$connection){
            session_start();

            include("../includes/db.php");
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 5;
            $time_out = $time - $time_out_in_seconds;
            $query = "SELECT * FROM users_online WHERE session='$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if($count == NULL){
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            }else{
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }

    } //get request isset
}

users_online();





function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
        $cat_title = escape($_POST['cat_title']);
        if($cat_title == "" || empty($cat_title)){
            echo "This field should not be empty";
        }else{
            $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title, user_id) VALUES(?, ?) ");
            $user_id = loggedInUserId();
            mysqli_stmt_bind_param($stmt, 'si', $cat_title, $user_id);
            mysqli_stmt_execute($stmt);
            

            if(!$stmt){
                die("QUERY FAILED : " . mysqli_error($connection));
            }

            //close statement
            mysqli_stmt_close($stmt);
        }
    }
}

function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
    if(!$select_categories){
        die("Query failed : " . mysqli_error($connection));
    }
    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = escape($row['cat_id']);
        $cat_title = escape($row['cat_title']);
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id = escape($_GET['delete']);
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    } 
}

function recordCount($table){
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_all_post = mysqli_query($connection, $query);
    if(!$select_all_post){
        die("Query failed : " . mysqli_error($connection));
    }
    return mysqli_num_rows($select_all_post);
}

function checkStatus($table, $column, $status){
    global $connection;
    $query = "SELECT * FROM $table WHERE $column='$status'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Query failed : " . mysqli_error($connection));
    }
    return mysqli_num_rows($result);
}





function username_exists($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username='$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function email_exists($email){
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email='$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function register_user($username, $email, $password){
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= " VALUES('{$username}','{$email}','{$password}','subscriber')";

    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);

}

function login_user($username, $password){

    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = escape($username);
    $password = escape($password);

    $query = "SELECT * FROM users WHERE username='{$username}'";
    $select_user_query = mysqli_query($connection, $query);
    confirmQuery($select_user_query);

    while($row = mysqli_fetch_array($select_user_query)){
        $db_user_id = escape($row['user_id']);
        $db_username = escape($row['username']);
        $db_user_password = escape($row['user_password']);
        $db_user_firstname = escape($row['user_firstname']);
        $db_user_lastname = escape($row['user_lastname']);
        $db_user_role = escape($row['user_role']);

        if(password_verify($password, $db_user_password)){
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;

            //admin has second redirect if user is not admin
            redirect("./admin");
        }else{
            return false;
        }
    }
    return true;
}

function imageController($post_image){
    if($post_image && !empty($post_image)){
        if(file_exists(rootFolderDirectory() . "images/" . $post_image)){
            return imageRoot() . "images/" . $post_image;
        }else {
            return imageRoot() . "images/placeholder.jpg";
        }
    }else{
        return imageRoot() . "images/placeholder.jpg";
    }
}

function rootFolderDirectory(){
    $serverName = $_SERVER['SERVER_NAME'];

    if($serverName == 'localhost'){
        $host = "C:/xampp/htdocs/cms/";
    }else{
        $host = myDirectory();
    }
    return $host;
}

function imageRoot(){
    $serverName = $_SERVER['SERVER_NAME'];

    if($serverName == 'localhost'){
        $host = "/cms/";
    }else{
        $host = "/";
    }
    return $host;
}

function myDirectory(){
    $serverName = $_SERVER['SERVER_NAME'];
    if($serverName == 'localhost'){
        $host = 'http://localhost/cms/';
    }else{
        $host = 'http://' . $serverName . '/';
    }
    return $host;
}

function postAndUserExist($post_id, $user_id){

    global $connection;

    //select the post
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);

    //VALID select post query
    if($postResult){
        $post_not_found = mysqli_num_rows($postResult) == 0;

        //post FOUND
        if(!$post_not_found){

            //select the user
            $query = "SELECT * FROM users WHERE user_id=$user_id";
            $userResult = mysqli_query($connection, $query);

            //VALID select user query
            if($userResult){
                $user_not_found = mysqli_num_rows($userResult) == 0;

                //user FOUND
                if(!$user_not_found){
                    echo "User and post found for user_id: " . $user_id . " and post_id: " . $post_id;
                    return true;
                    //user NOT FOUND
                }else{
                    echo "User was not found for user_id: " . $user_id;
                    return false;
                }
                //INVALID select user query
            }else{
                echo mysqli_error($connection);
                return false;
            }
            //post NOT FOUND
        }else{
            echo "Post was not found for post_id: " . $post_id;
            return false;
        }
        //INVALID select post query
    }else{ 
        echo mysqli_error($connection);
        return false;
    }
}



?>