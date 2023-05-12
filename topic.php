<?php 

    session_start();
    require('config.php');

    if(@$_SESSION['username']){
?>
<html>
    <head>
        <title>Topic</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="script.js"></script>
    </head>
    
    <body>
        <header><?php require('nav.php'); ?></header>
        <main>
            <div class='postStyle'>
                <?php
                    $id = $_GET['id'];
                    if($_GET['id']){
                        $check = mysqli_query($conn,"SELECT * FROM posts WHERE postId = '".$id."' ");
                        
                        if(mysqli_num_rows($check)){
                            while($row = mysqli_fetch_assoc($check)){
                                $checkUser = mysqli_query($conn,"SELECT * FROM users WHERE username='".$row['posterName']."' ");
                                while($rowsUser = mysqli_fetch_assoc($checkUser)){
                                    $userId = $rowsUser['id'];
                                }
        
                                echo '<h1 class="postTitle">'.$row['title'] . '</h1><hr class="dash"/>';
                                echo '<div class="postContent">'.$row['message'] . '</div>';
                                echo "<div class='postFooter'>Posted by <a href='profile.php?id=$userId'>".$row['posterName'] . '</a><br/>';
                                echo $row['postedDate'] . '</div>';
                                if($row['posterName']==@$_SESSION['username']||@$_SESSION['username']=='admin'){?>
                                <div style='margin:5px'>
                                    <a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a>
                                    <a href='delete.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Delete</button></a>
                                </div>
                                <?php
                                }
                            }
                        }else{
                            echo 'post not found!';
                        }
                    }else{
                        header('Location: index.php');
                    }

                ?>
            </div>
            
            <div class='addComment'>
                <?php 
                if(@$_GET['action']=='addComment'){
                    ?>
                        <div class='commentForum'>
                            <form action='topic.php?id=<?php echo $id."&action=addComment"; ?>' method='POST'>
                            <h2>Add Comment</h2> 
                                <p>Title: <br/><input type="text"  name="cTitle" size=40 /></p>
                                <p>Message: <br/><textarea name="cMessage" rows=10 cols=100 ></textarea></p>
                                <p><input type="submit" name='addC' value="Post" >
                                <a class='cancel' href='topic.php?id=<?php echo $id; ?>'>Cancel</a>
                                </p> 
                            </form>
                        </div>
                    <?php
                    $title = @$_POST['cTitle'];
                    $message = @$_POST['cMessage'];
                    $date = date('y-m-d');

                    if(isset($_POST['addC'])){

                        $check = mysqli_query($conn,"SELECT * FROM users WHERE username='".$_SESSION['username']."'  ");
                        $rows = mysqli_num_rows($check);

                        if($rows){
                            if($title && $message){
                                if(strlen($title)>=7 && strlen($title)<=70){
                                    if($query = mysqli_query($conn,'INSERT INTO posts(title,message,postedDate,posterName,parentId) VALUES ("'.$title.'","'.$message.'","'.$date.'","'.$_SESSION['username'].'", '.$id.' ) ')){
                                        $q = mysqli_query($conn, "SELECT * from users where username = '".$_SESSION['username']." ' ");
                                        $c = mysqli_fetch_assoc($q);
                                        // echo 'userId:'.$c['id'].' username:'.$c['username'].' posts: '.$c['posts'] . ' comments: '. $c['comments']; 
                                        $newComments = $c['comments']+1;
                                        $uId = $c['id'];
                                        
                                        // echo 'New comments: '.$newComments.' id' . $id;

                                        $updateQuery = mysqli_query($conn,"UPDATE users SET comments =".$newComments." WHERE users.id =".$uId);
                                        
                                        header('Location: topic.php?id='.$id);
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
                    }
                    
                }else{
                    ?>
                    <a href='topic.php?id=<?php echo $id."&action=addComment"; ?> '><button class='btn'>add a comment</button></a>
                    <?php
                }
                
                ?>
            </div>
            <div class='back'>
                <a href='
                    <?php 
                        $check = mysqli_query($conn, 'SELECT * FROM posts where postId ='.$id);
                        $rows = mysqli_num_rows($check);
                        $checkNull = false;
                        while($row = mysqli_fetch_assoc($check)){
                            if(is_null($row['parentId'])){
                                $checkNull = true;
                                echo 'index.php';
                            }else{
                                echo 'topic.php?id='.$row['parentId'];
                            }
                            
                        }


                    ?>'>
                <botton class='btn'>Back
                    <?php 
                        if($checkNull){
                            echo ' Home';
                        }else{
                            echo 'to parent post';
                        }
                    ?>
                </botton></a>
            </div>
            <div >
                <h2>Comments</h2>
                <div class='commentStyle'>
                    <?php 
                    
                    $check = mysqli_query($conn,'SELECT * FROM posts WHERE parentId = '.$id);
                    if(mysqli_num_rows($check)){
                        while($row = mysqli_fetch_assoc($check)){
                    
                            echo '<div class="comment">';
                            echo '<h2 class="commentTitle"> <a href="topic.php?id='.$row['postId'].'">'.$row['title'] . '</a></h2><hr/>';
                            echo '<div class="commentMessage">'.$row['message'] . '</div><br/>';
                            echo "<div class='commentFooter'>Posted by <a href='profile.php?id=$userId'>".$row['posterName'] . '</a><br/>';
                            echo $row['postedDate'] . '</div>';
                            if($row['posterName']==@$_SESSION['username']||@$_SESSION['username']=='admin'){?>
                            <div style='margin-bottom:5px;'>
                                    <a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a>
                                    <a href='delete.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Delete</button></a>
                            </div>
                            <?php
                            }
                            echo '</div>';
                        }

                    }
                    ?>
                </div>
            </div>
        </div>
            
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

