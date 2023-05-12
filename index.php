<?php 

    session_start();
    require('config.php');

    if(@$_SESSION['username']){
?>
<html>
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="scripts.js"></script>
    </head>
    <body>
        <header><?php require('nav.php'); ?></header>
        <main>
            
            <div>
                <h1>
                    Posts
                </h1>
                <div class='homebtns'>
                    <a href="post.php">
                        <button class='btn'>Make a post</button>
                    </a>

                    <a  href='index.php?action=search'>
                        <button class='btn'>Search</button>
                    </a>
                    <?php
                        if(@$_GET['action']=='search'){
                            ?>
                            <form action='index.php?action=search' method='POST'>
                                <h2>Search by Title</h2>
                                <input type='text' name='search' placeholder="enter title">
                                <input name='searchTitle' type='submit'>
                                <a class='cancel' href='index.php'>Cancel</a>
                            </form>
                            <?php
                        }
                    ?>
                </div>
            <?php 
                $searchKey = @$_POST['search'];
                if(isset($_POST['searchTitle'])){
                    $check = mysqli_query($conn,'SELECT * from posts where parentId IS NULL AND postId != 0 AND title LIKE \'%'.$_POST['search'].'%\'');
                    $rows= mysqli_num_rows($check);


                    while($row = mysqli_fetch_assoc($check)){
                        ?>
                        <div class='posts'>
                            <h1><a href='topic.php?id=<?php echo $row['postId']; ?>'><?php echo $row['title'];  ?></a></h1>
                            <p>Posted by <a href='profile.php?id=<?php echo $userId; ?>'><?php echo $row['posterName'];  ?></a></p>
                            <p>Date: <?php echo $row['postedDate'];  ?></p>
                            <?php if($row['posterName']==@$_SESSION['username']|| @$_SESSION['username']=='admin'){ ?>
                                <div>
                                    <a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a>
                                    <a><button class='btn' onClick='ConfirmDelete(<?php echo $row['postId'] ?>)'>Delete</button></a>
                                </div>
                            <?php }?>
                        </div>
                        <?php
                    }
                }else{
                    $check = mysqli_query($conn,'select * from posts WHERE parentId IS NULL AND postId != 0');

                    if(mysqli_num_rows($check)){
                        while($row = mysqli_fetch_assoc($check)){
                            $id = $row["postId"];
                            $checkUser = mysqli_query($conn,"SELECT * FROM users WHERE username='".$row['posterName']."' ");
                            while($rowsUser = mysqli_fetch_assoc($checkUser)){
                                $userId = $rowsUser['id'];
                            }
                            ?>
                            <div class='posts'>
                                <h1><a href='topic.php?id=<?php echo $id; ?>'><?php echo $row['title'];  ?></a></h1>
                                <p>Posted by <a href='profile.php?id=<?php echo $userId; ?>'><?php echo $row['posterName'];  ?></a></p>
                                <p>Date: <?php echo $row['postedDate'];  ?></p>
                                <?php if($row['posterName']==@$_SESSION['username']|| @$_SESSION['username']=='admin'){ ?>
                                <div>
                                    <a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a>
                                    <a><button class='btn' onClick='ConfirmDelete(<?php echo $row['postId'] ?>)'>Delete</button></a>
                                </div>
                                <?php }?>
                            </div>
                            
                            <?php
                        }
                    }else{
                        echo 'error';
                    }
                }
            ?>
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
?>


