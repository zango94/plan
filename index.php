
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
		<div class="col-md-4">
			<h2>
				Logowanie
			</h2>
			<p>
				Zaloguj się do panelu Admina, aby stworzyć plan zajęć.
			</p>
			<p>
				<a class="btn btn-primary btn-large" href="logowanie.php">Logowanie</a>
			</p>
		</div>
		<div class="col-md-4">
			<h2>
				Plan zajęć.
			</h2>
			<p>
				Przejdz, aby zobaczyć plan zajęć.
			</p>
			<p>
				<a class="btn btn-primary btn-large" href="zobacz_plan.php">Dalej</a>
			</p>
		</div>
	</div>
	<br><br/>
	<?php include("foot.php");?>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
