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
            <script src="script.js"></script>
        </head>
        
        <body>
            <header>
                <?php require('nav.php'); ?>
            </header>
            <main>
                <?php
                if(@$_GET['id']){
                    $check = mysqli_query($conn,"SELECT * FROM users WHERE id ='".$_GET['id']."'  ");
                    $rows = mysqli_num_rows($check);


                    if($rows !=0){
                        
                        while($row = mysqli_fetch_assoc($check)){
                            $name =  $row['username'];
                            echo '<div>';
                            echo '<h1>'.$row['username'].'</h1>';
                            echo '<img src="'.$row["profilePic"].'" height="150" width="150"><br/>';
                            if($_SESSION['username']=='admin'){
                                echo 'Email: ' .$row['email'].'<br>';
                                echo 'Created date: '.$row['createdDate'].'<br>';
                            }
                            echo 'Posts: ' .$row['posts'].'<br>';
                            echo 'Comments: ' .$row['comments'].'</p>';
                            echo '</div>';
                        }

                    }else{
                        echo 'ID not found!';
                    }
                    ?>
                    <br>
                    <h2>Posts</h2>
                    <table class='tableA'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>User</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                            $check = mysqli_query($conn, 'SELECT * FROM posts where posterName ="'.$name.'" AND parentId IS NULL ');
                            $rows = mysqli_num_rows($check);

                            while($row = mysqli_fetch_assoc($check)){
                                
                                if($row['parentId']!= -1){
                                ?>
                                <tr>
                                    <td><a href='topic.php?id=<?php echo $row['postId']?>'><?php  echo $row['title'] ?></a></td>
                                    <td><?php  echo $row['message'] ?></td>
                                    <td><?php  echo $row['posterName'] ?></td>
                                    <td><?php  echo $row['postedDate'] ?></td>
                                </tr>
                                <?php
                                }
                            }
                    ?>
                        </tbody>
                    </table>
                    <?php
                }else{
                    header("Location: index.php");
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



