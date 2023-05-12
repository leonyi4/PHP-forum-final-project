<?php 

    session_start();
    require('config.php');

    if(@$_SESSION['username']){
?>
<html>
    <head>
        <title>account</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="scripts.js"></script>
    </head>
    <body>
        <header><?php require('nav.php'); ?></header>
        
        <main>
                <?php 
                    $id = $_GET['pid'];
                    $check = mysqli_query($conn,"SELECT * FROM posts WHERE postId = '".$id."' ");
                    if(mysqli_num_rows($check)){
                        $row = mysqli_fetch_assoc($check);
                        $oldTitle = $row['title'];
                        $oldMessage = $row['message']; 
                        $parentId = $row['parentId']; 
                        $postId = $row['postId']; 
                    }
                    echo $oldTitle;
                ?>
                <form action='edit.php' method='POST'>
                    <h1>Edit</h1>
                    <p>Title <br/><input type="text"  name="title" value="<?php echo $oldTitle; ?>" size=40 /></p>
                    <p>Message <br/><textarea name="message"><?php echo $oldMessage; ?></textarea></p>
                    <p><input type="submit" name='submit' value="Confirm" >
                    <input type='hidden' name='postId' value=<?php echo $id ?> />
                    <a class='cancel' href="<?php
                        if($_SESSION['username']=='admin'){
                            echo 'index.php';
                        }else if($parentId){ 
                            echo 'Replies';
                        }else {
                            echo 'Posts';
                        } ?>
                    ">Cancel
                    </a></form>
                <?php
                $title = @$_POST['title'];
                $message = @$_POST['message'];
                $postId = @$_POST['postId'];
                $date = date('y-m-d');
                if(isset($_POST['submit'])){
                    if($title && $message){
                        if(strlen($title)>=7 && strlen($title)<=70){
                            echo $title . '<br>';
                            echo $message. '<br>';
                            echo $postId. '<br>';
                            if($query = mysqli_query($conn,'UPDATE posts SET message ="'.$message.'", title="'.$title.'"  WHERE posts.postId ='.$postId)){
                                echo '<script>editSuccess()</script>';
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
