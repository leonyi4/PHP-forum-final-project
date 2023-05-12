<?php

    if(@$_SESSION['username']){

?>
<nav>
    <a href='index.php'>Home |</a> 
    <a href='account.php'>Profile |</a> 
    <?php if(@$_SESSION['username'] == 'admin'){?>
        <a href='members.php'>Members |</a> 
        <a href='admin.php'>Posts |</a> 
    <?php } ?>
    <a href='index.php?action=logout'>Log out</a> 
</nav>  

<?php
        
    }else{
        header("Location: login.php");
    }
?>

