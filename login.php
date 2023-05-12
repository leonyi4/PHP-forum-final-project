<!DOCTYPE HTML>
<html>
    <head>
        <title>Log in</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <main>
            <form action="login.php" method="POST">
                <h2>Sign In</h2>
                <p>Username: <input type="text" name="username" /></p>
                <p>Password: <input type="password" name="password" /></p>
                <p><input type="submit" name="submit" value="Login" /> or <a href='register.php'>Register</a></p>
            </form>
        </main>
    </body>
    
</html>

<?php
session_start();
require('config.php');

$username = @$_POST['username'];
$password = @$_POST['password'];

if(isset($_POST['submit'])){
    if($username && $password){
        $checkuser = mysqli_query($conn,"SELECT * FROM users WHERE username='".$username."'");
        if(mysqli_num_rows($checkuser) !=0){
            
            while($row = mysqli_fetch_assoc($checkuser)){
                $dbUsername = $row['username'];
                $dbPassword = $row['password'];
            }
            if($username == $dbUsername && $password == $dbPassword){
                @$_SESSION['username'] = $username;
                header("location: index.php");
            }else{
                echo 'Wrong password';
            }

        }else{
            echo 'username not found';
        }
    }else{
        echo 'Please fill in all the form';
    }
}

?>