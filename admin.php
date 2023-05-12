<?php 

    session_start();
    require('config.php');

    if(@$_SESSION['username']){
?>
<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="scripts.js"></script>
    </head>
    
    <body>
        <header>
            <?php require('nav.php'); ?>
        </header>
        <main>
            <div class='currentPosts'>
                <h2>Current Posts</h2>
                <table class='tableA'>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        $check = mysqli_query($conn, 'SELECT * FROM posts where parentId IS NULL ');
                        $rows = mysqli_num_rows($check);

                        while($row = mysqli_fetch_assoc($check)){
                            
                            if($row['parentId']!= -1){
                            ?>
                            <tr>
                                <td><a href='topic.php?id=<?php echo $row['postId']?>'><?php  echo $row['title'] ?></a></td>
                                <td><?php  echo $row['message'] ?></td>
                                <td><?php  echo $row['posterName'] ?></td>
                                <td><?php  echo $row['postedDate'] ?></td>
                                <td><a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a></td>
                                <td><a><button class='btn' onClick='ConfirmDelete(<?php echo $row['postId'] ?>)'>Delete</button></a></td>
                            </tr>
                            <?php
                            }
                        }
                ?>
                    </tbody>
                </table>
            </div>
            <div class='currentComments'>
                <h2>Current Comments</h2>
                <table class='tableA'>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        $check = mysqli_query($conn, 'SELECT * FROM posts where parentId IS NOT NULL AND parentId != 0');
                        $rows = mysqli_num_rows($check);

                        while($row = mysqli_fetch_assoc($check)){
                            
                            if($row['parentId']!= -1){
                            ?>
                            <tr>
                                <td><a href='topic.php?id=<?php echo $row['postId']?>'><?php  echo $row['title'] ?></a></td>
                                <td><?php  echo $row['message'] ?></td>
                                <td><?php  echo $row['posterName'] ?></td>
                                <td><?php  echo $row['postedDate'] ?></td>
                                <td><a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a></td>
                                <td><a><button class='btn' onClick='ConfirmDelete(<?php echo $row['postId'] ?>)'>Delete</button></a></td>
                            </tr>
                            <?php
                            }
                        }
                ?>
                    </tbody>
                </table>
            </div>
            <div class='deletedContent'>
                <h2>Deleted Content</h2>
                <table class='tableA'>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Pid</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        $check = mysqli_query($conn, 'SELECT * FROM posts where parentId = 0');
                        $rows = mysqli_num_rows($check);

                        while($row = mysqli_fetch_assoc($check)){
                            
                            if($row['parentId']!= -1){
                            ?>
                            <tr>
                                <td><a href='topic.php?id=<?php echo $row['postId']?>'><?php  echo $row['title'] ?></a></td>
                                <td><?php  echo $row['message'] ?></td>
                                <td><?php  echo $row['posterName'] ?></td>
                                <td><?php  echo $row['postedDate'] ?></td>
                                <td><a href='edit.php?pid=<?php echo $row['postId'] ?>'><button class='btn'>Edit</button></a></td>
                                <td><?php echo $row['postId'] ?></td>
                            </tr>
                            <?php
                            }
                        }
                ?>
                        </tbody>
                    </table>
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
    
<?php } ?>