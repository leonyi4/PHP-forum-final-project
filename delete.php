<?php 
    require('config.php');
    $id = $_GET['pid'];

    echo $id;

    $query = mysqli_query($conn,'SELECT * FROM posts WHERE postId='.$id);
    $row = mysqli_fetch_assoc($query);

    
    if($c = mysqli_query($conn,'UPDATE posts SET parentId = -1 WHERE postId='.$id)){
        
        echo "<script>
        alert('Delete Successful!');
        window.location.href='index.php';
        </script>";
    }

    



?>