<?php include("config.php");
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
    if ((empty($nick)) AND (empty($haslo))) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=4';
	header("Location: http://$host$uri/$extra");
}
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
    if (empty($user[id]) OR !isset($user[id])) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=4';
	header("Location: http://$host$uri/$extra");
}
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>System zarządzania planem zajęć</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <div class="container">
	<?php include("head.php");?>

	<div class="row">
		<div class="col-md-12">
			<h2>
				Wybierz czynność poniżej.
				<?php include("left_menu.php") ?>
			</h2>
		</div>
	</div>



<?php include("foot.php");?>
</div>

</body>
</html>
