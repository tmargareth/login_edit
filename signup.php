<?php 
    include_once 'header.php';
    include_once './helpers/session_helper.php';
?>

<div class="section">
    <h1 class="header text-center">Registreerumine</h1>

    <?php flash('register') ?>

    <form method="post" action="./controllers/Users.php">
    <input type="hidden" name="type" value="register">
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputUser4" name="usersName" placeholder="Täisnimi...">
                        </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="usersEmail" id="inputEmail4" placeholder="Meil...">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="usersUid" placeholder="Kasutajanimi...">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="usersPwd" placeholder="Parool...">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="inputPassword4" name="pwdRepeat" placeholder="Parool uuesti...">
                    </div>

                    <button type="submit" class="btn btn-primary">Registreeru</button>
        </form>
</div>
<?php 
    include_once 'footer.php'
?>