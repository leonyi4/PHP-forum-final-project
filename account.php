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
                $check = mysqli_query($conn,"SELECT * FROM users WHERE username ='".$_SESSION['username']."'  ");
                $rows = mysqli_num_rows($check);

                while($row = mysqli_fetch_assoc($check)){
                    $id=$row['id'];
                    $username=$row['username'];
                    $email=$row['email'];
                    $createdDate=$row['createdDate'];
                    $comments=$row['comments'];
                    $posts=$row['posts'];
                    $profilePic=$row['profilePic'];
                }
            ?>
            <div class='profile'>
                <img class='proPic' src="<?php echo $profilePic;?>">
                <p> Username: <?php echo $username; ?><br>
                    ID: <?php echo $id; ?><br>
                    Email: <?php echo $email; ?><br>
                    Date registered: <?php echo $createdDate; ?><br>
                    Posts: <?php echo $posts; ?><br>
                    Comments: <?php echo $comments; ?></p>

                    <?php 
                        if(@$_GET['action']=="changePass"){
                    ?>
                        <div class='changePass'>
                            <form action='account.php?action=changePass' method='POST'>
                                <h2>Change Password</h2>
                                <p>Current password: <input type='text' name='currPass'></p>
                                <p>New Password:<input type='password' name='newPass'></p>
                                <p>Re-enter Password: <input type='password' name='rePass'></p>
                                <p>
                                    <input type='submit' name='changePassword' value='Change'>
                                    <a class='cancel' href='account.php'>Cancel</a>
                                </p>
                            </form>
                        </div>
                        <?php
                            $curPass = @$_POST['currPass'];
                            $newPass = @$_POST['newPass'];
                            $rePass = @$_POST['rePass'];
                            if(isset($_POST['changePassword'])){
                                    $check = mysqli_query($conn,"SELECT * FROM users WHERE username='".$_SESSION['username']."'  ");
                                    $rows = mysqli_num_rows($check);



                                    while($row = mysqli_fetch_assoc($check)){
                                        $getPass =  $row['password'];
                                    }
                                    if($curPass == $getPass){
                                        if(strlen($newPass) >5){
                                            if($newPass == $rePass){
                                                if($query = mysqli_query($conn,"UPDATE users SET password='".$newPass."' WHERE username='".$_SESSION['username']."' ")){
                                                    header("Location: account.php");

                                                }
                                            }else{
                                                echo "New password doesn't match.";
                                            }
                                        }else{
                                            echo 'new password has to be at least 6 characters';
                                        }
                                        
                                    }else{
                                        echo 'Current password is wrong!';
                                    }
                                }
                            }else{
                                ?>
                                <a href='account.php?action=changePass'><button class='btn'>Change password</button></a> 
                                <?php
                            }     
                        ?>
                    <?php
                        if(@$_GET['action']=='changeImage'){
                    ?>
                        <form action="account.php?action=changeImage" method="POST" enctype="multipart/form-data">
                            <p>Accepted file types: .PNG .JPG .JPEG .GIF</p>
                            <p><input type='file' name='image'></p>
                            <p>
                                <input type='submit' name='changePic' value="Change">
                                <a class='cancel' href='account.php'>Cancel</a>
                            </p>
                        </form>
                    <?php
                            if(isset($_POST['changePic'])){
                                $err = array();
                                $allowedExt = array('png','jpg','jpeg','gif');

                                $fileName = $_FILES['image']['name'];
                                $fileExt = strtolower((pathinfo($fileName, PATHINFO_EXTENSION)));
                                $fileSize = $_FILES['image']['size'];
                                $fileTmp = $_FILES['image']['tmp_name'];

                                if(in_array($fileExt, $allowedExt)=== false){
                                    $err[] = 'This file extension not allowed!';
                                }

                                if($fileSize > 2097152){
                                    $err[] = 'File must be under 2mb';
                                }
                                if(empty($err)){
                                    move_uploaded_file($fileTmp, 'images/'.$fileName);
                                    $imageUp = 'images/'.$fileName;   
                                    if($query = mysqli_query($conn,"UPDATE users SET profilePic='".$imageUp."' WHERE username='".$_SESSION['username']."' ")){
                                        header("Location: account.php");
                                    }

                                }else{
                                    foreach($err as $error){
                                        echo $error, '<br/>';
                                    }
                                }
                            }
                        }else{
                            ?> 
                            <a href='account.php?action=changeImage'><button class='btn'>Change Profile Image</button></a>                
                            <?php
                        }
                    ?>
            </div>     
            

            <div class='content'>
                <div class='contentHeader'>
                    <a class='cancel' href='account.php?view=Posts'>View posts</a>
                    <a class='cancel' href='account.php?view=Replies'>View replies</a>
                </div>
                <div class='contentC'>
                    <?php
                        if(@$_GET['view']==='Posts'){
                    ?>
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
                            $check = mysqli_query($conn, 'SELECT * FROM posts where posterName ="'.$_SESSION['username'].'" AND parentId IS NULL ');
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
                    <?php
                    }
                    ?>
                    <?php
                        if(@$_GET['view']==='Replies'){
                    ?>
                    <table class='tableC'>
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
                                    $check = mysqli_query($conn, 'SELECT * FROM posts where posterName ="'.$_SESSION['username'].'" AND parentId IS NOT NULL ');
                                    $rows = mysqli_num_rows($check);

                                    while($row = mysqli_fetch_assoc($check)){
                                        if($row['parentId']!= 0){
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
                    <?php
                    }
                    ?>    
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
?>


