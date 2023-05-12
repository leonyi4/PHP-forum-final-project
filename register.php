<!DOCTYPE HTML>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="index.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <main>
            <form action="register.php" method="POST">
                <h2>Register</h2>
                <p>Email: <input type="email" name="email" /></p>
                <p>Username: <input type="text" name="username" /></p>
                <p>Password: <input type="password" name="password" /></p>
                <p>Confirm Password: <input type="password" name="repassword" /></p>
                <p><input type="submit" name="submit" value="Register" /> or <a href='login.php'>Login</a></p>
            </form>
        </main>
    </body>
</html>
<?php
require 'config.php';


$username = @$_POST['username'];
$email = @$_POST['email'];
$password = @$_POST['password'];
$repassword = @$_POST['repassword'];
$date = date('Y-m-d');

if(isset($_POST['submit'])){

    if($username && $email&& $password && $repassword){
        if(strlen($username) >= 3 && strlen($username) < 25 && strlen($password)>5){
            if($password == $repassword){
                if($query = mysqli_query($conn," INSERT INTO users (username,email,password,createdDate) VALUES('".$username."','".$email."','".$password."','".$date."')")){
                    echo "Register Successful. Click <a href='login.php'>here</a> to Log in ";
                }else{
                    echo "Register failed";
                }
            }else{
                echo "passwords don't match";
            }
        }else{
            if(strlen($username) < 3 || strlen($username) > 25){
                echo "Username should be between 3 and 25 characters!";
            }

            if(strlen($password )<= 5){
                echo "The password must be at least 6 characters";
            }
        }
    }
    
}

?>