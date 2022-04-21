<?php 
    session_start();
?>
<?php    
require_once "models/Settings.php";
$settings = new Settings(); // objekt failis olevate asjade kasutamiseks
$enabled = $settings->getAllowChangeRating();
//print_r($enabled); // test 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="./jquery.star-rating-svg.js"></script>
        <link rel="stylesheet" type="text/css" href="./star-rating-svg.css">
        <link rel="stylesheet" href="./style.css" type="text/css">
        <title>PHP Login System</title>
    </head>
<body class="d-flex flex-column min-vh-100" style="display: flex; flex-direction: column; min-height: 100vh;">
<header>
<nav class="navbar navbar-expand-lg navbar-light mb-4" style="background-color: rgba(0, 0, 0, 0.05);">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Avaleht <span class="sr-only">(current)</span></a>
        <li class="nav-item">
                    <a class="nav-link" href="books.php">Raamatud</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="childmouth.php">Lapsesuu</a>
                </li>
      </li>
       
    </ul>

    <ul class="navbar-nav">
     
          <?php if(!isset($_SESSION['usersId'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Registreeru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Logi sisse</a>
                </li>
          <?php else: ?>
                <li class="nav-item mt-2">
                      <input type="checkbox" name="allow" id="ip_settings" value="<?php echo $enabled->allow; ?>" <?php if($enabled->allow) {echo "checked"; } ?>>
                      Luba muuta hinnangut
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./controllers/Users.php?q=logout">Logi välja</a>
                </li>
          <?php endif; ?>
    </ul>

  </div>
</nav>
</header>
<script>
    $(document).ready(function() {
        $("#ip_settings").change(function() {
            let allow = "<?php echo $enabled->allow; ?>"; // Tekstina
            //console.log(allow); // Kontrolliks konsooli
            if(allow == 1) {                
                allow = 0; // Numbrina
            } else {
                allow = 1; // Numbrina
            }
            $.ajax({
                type: 'POST',
                url: 'setAllowValue.php',
                data: {
                    allow: allow,
                    id: 1
                },
                success: function(data) {
                    //console.log(data); // echo $result
                    console.log('Settings updated');
                    location.reload(true);
                },
                error: function(data) {
                    //console.log(data); // echo $result
                    console.log('Settings error');
                }
            });
        });

    });
</script>