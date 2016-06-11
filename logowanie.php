<?php include("config.php");
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
    if ((empty($nick)) AND (empty($haslo))) {
}
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
    if (empty($user[id]) OR !isset($user[id])) {
}
else {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'admin.php';
	header("Location: http://$host$uri/$extra");
}

$error=$_GET["error"];
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>System planu zajęć</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<style>


.wrapper {
	margin-top: 40px;
  margin-bottom: 80px;
}

.form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,0.1);

  .form-signin-heading,
	.checkbox {
	  margin-bottom: 30px;
	}

	.checkbox {
	  font-weight: normal;
	}

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
		@include box-sizing(border-box);

		&:focus {
		  z-index: 2;
		}
	}

	input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	input[type="password"] {
	  margin-bottom: 20px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
}
</style>
</head>

  <body>

<div class="container">
		<?php include("head.php");?>

			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-primary btn-large" href="index.php">Powrót</a>

    	<center><div class="mmmodal-dialog">
				<div class="llloginmodal-container">

					<h1>Logowanie do panelu administratora</h1><br>
					<?php if ($error==1) {echo "<p class=\"alert alert-danger\" role=\"alert\">Wpisz prawidłowe dane do logowania.</p>";} ?>
					<?php if ($error==2) {echo "<p class=\"alert alert-danger\" role=\"alert\">Wpisz prawidłowe dane do logowania.</p>";} ?>
					<?php if ($error==3) {echo "<p class=\"alert alert-danger\" role=\"alert\">Podaj prawidłowe dane do logowania.</p>";} ?>
					<?php if ($error==4) {echo "<p class=\"alert alert-danger\" role=\"alert\">Zaloguj się ponownie.</p>";} ?>
		
                <div class="wrapper">
    <form class="form-signin" action="zaloguj.php" method="post">
      <h2 class="form-signin-heading">Zaloguj się</h2>
      <input type="text" class="form-control" name="login" placeholder="Login" required="" autofocus="" />
      <input type="password" class="form-control" name="haslo" placeholder="Hasło" required=""/>
      <br/><button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj</button>
    </form>
  </div>

				</div>
			</div></center>
		</div>
	</div>

<?php include("foot.php");?>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  <?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>
  </body>
</html>
