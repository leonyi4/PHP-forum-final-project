<?php 

    session_start();
    require('config.php');

    if(@$_SESSION['username']){
?>
<html>
    <head>
        <title>Post</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    
    <body>
        <header><?php require('nav.php'); ?></header>
        <main>
            <form action="post.php" method="POST">
                <h1>Create A Post </h1>
                <p>Title: <br/><input type="text"  name="title" size=40 /></p>
                <p>Message: <br/><textarea name="message" ></textarea></p>
                <p><input type="submit" name='submit' value="Post" >
                <a class='cancel' href='index.php'>Cancel</a></p> </p>
            </form>
            <?php
                $title = @$_POST['title'];
                $message = @$_POST['message'];
                $date = date('y-m-d');
                if(isset($_POST['submit'])){
                    if($title && $message){
                        if(strlen($title)>=7 && strlen($title)<=70){
                            if($query = mysqli_query($conn,'INSERT INTO posts(title,message,postedDate,posterName) VALUES ("'.$title.'","'.$message.'","'.$date.'","'.$_SESSION['username'].'") ')){
                                
                                $q = mysqli_query($conn, "SELECT * from users where username = '".$_SESSION['username']." ' ");
                                $c = mysqli_fetch_assoc($q);
                                //echo 'userId:'.$c['id'].' username:'.$c['username'].' posts: '.$c['posts'] . ' replies: '. $c['replies']; 
                                $newPost = $c['posts']+1;
                                $id = $c['id'];

                                $updateQuery = mysqli_query($conn,"UPDATE users SET posts =".$newPost." WHERE users.id =".$id);
                                
                                header('Location: index.php');
                            }else{
                                echo 'fail';
                            }
                        }else{
                            echo 'title must be between 7 and 70 characters long';
                        }
                    }else{
                        echo 'Enter everything!';
                    }
                }

            ?>
        </main>
        <?php require('footer.php'); ?>
    </body>
</html>
<?php
    require('logout.php');


    }else{
        ?>
        <head>
        <title>Home Page</title>
            <link rel="stylesheet" href="index.css">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <main>
            <h1>Must be logged in</h1>
            <a  href="login.php"><button class='btn'>Login</button></a>
        </main>
    
    <?php
}   
?>




