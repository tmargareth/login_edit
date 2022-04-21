
<?php 
    include_once 'header.php';
    include_once './helpers/session_helper.php';
?>

<div class="section p-2">
    <h1 class="header text-center">Sisselogimine</h1>

    <?php flash('login') ?>

    <form method="post" action="./controllers/Users.php">
            <input type="hidden" name="type" value="login">
            <div class="form-group">
                <input type="text" name="name/email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Kasutajanimi/meil...">
            </div>
            <div class="form-group">
                <input type="password" name="usersPwd" class="form-control" id="exampleInputPassword1" placeholder="Parool...">
            </div>
            <button type="submit" class="btn btn-primary">Logi sisse</button>
    </form>

    <div class="form-sub-msg"><a href="./reset-password.php">Unustasid parooli?</a></div>
</div>  
<?php 
    include_once 'footer.php'
?>