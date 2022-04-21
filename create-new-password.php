<?php 
    if(empty($_GET['selector']) || empty($_GET['validator'])){
        echo 'Taotlust ei rahuldatud!';
    }else{
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];
        
        if(ctype_xdigit($selector) && ctype_xdigit($validator)) { ?>
<?php 
    include_once 'header.php';
    include_once './helpers/session_helper.php';
?>
<div class="section">
    <h1 class="header text-center">Parooli muutmine</h1>

    <?php flash('newReset') ?>

    <form method="post" action="./controllers/ResetPasswords.php">
        <input type="hidden" name="type" value="reset" />
        <input type="hidden" name="selector" value="<?php echo $selector ?>" />
        <input type="hidden" name="validator" value="<?php echo $validator ?>" />
        <input type="password" name="pwd" 
        placeholder="Uus parool...">
        <input type="password" name="pwd-repeat" 
        placeholder="Uus parool uuesti...">
        <button type="submit" class="btn btn-primary">Muuda parooli</button>
    </form>
</div>
    <?php 
    include_once 'footer.php'
    ?>
            
<?php 
    }else{
        echo 'Taotlust ei rahuldatud!';
    }
}
?>
    