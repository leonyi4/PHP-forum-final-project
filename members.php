<?php 

    session_start();
    require('config.php');

    if(@$_SESSION['username']){
?>
<html>
        <head>
            <title>Members</title>
            <link rel="stylesheet" href="index.css">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        
        <body>
        <header><?php require('nav.php'); ?></header>
        <main>
            <h1>Members</h1>
            <div>
                <h3>
                    <?php

                    $check = mysqli_query($conn,"SELECT * FROM users");
                    $rows = mysqli_num_rows($check);
                    $a = 1;
                    while($row = mysqli_fetch_assoc($check)){
                        $id = $row['id'];
                        
                        if($row['username']!= 'admin'){
                            echo '<div>'.$a++.'. ';
                            echo "<a href='profile.php?id=$id'>" . $row['username'] ."</a>";
                            echo " | Posts: ".$row['posts'];
                            echo " | Comments: ".$row['comments'];
                            echo '</div>';
                        }
                        
                        
                    }
                    ?>
                </h3>
            </div>
            </main>
            
        </body>
        <?php require('footer.php'); ?>
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