<?php 
    include_once 'header.php'
?>

<div class="container text-body text-center">
    <h1 id="index-text" class="font-weight-bold" style="margin-top: 60px">Tere tulemast, <?php if(isset($_SESSION['usersId'])){
        echo explode(" ", $_SESSION['usersName'])[0];
    }else{
        echo 'külaline';
    } 
    ?> 
    </h1>
</div>   

<?php 
    include_once 'footer.php'
?>