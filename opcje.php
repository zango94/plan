<?php include("config.php");
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
    if ((empty($nick)) AND (empty($haslo))) {
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'logowanie.php?error=4';
			header("Location: http://$host$uri/$extra");
}// sprawdzanie login i hasła
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
    if (empty($user[id]) OR !isset($user[id])) {
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'logowanie.php?error=4';
			header("Location: http://$host$uri/$extra");
}// sprawdzanie czy użytkownik istnieje

$a = trim($_REQUEST['a']);
$id = trim($_GET['id']);


if($a == 'save') {

    $id = $_POST['id'];
    $dl_godz = trim($_POST['dl_godz']);
    $dl_prz = trim($_POST['dl_prz']);
    $startg = trim($_POST['startg']);
    $startm = trim($_POST['startm']);

    mysql_query("UPDATE opcje SET dl_godz='$dl_godz',dl_prz='$dl_prz',startg='$startg',startm=$startm WHERE id=1") or die('Błąd zapytania'); //aktualizacja tabeli opcje
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'opcje.php?i=akt';
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
	<link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <div class="container">
	<?php include("head.php");?>

	<div class="row">
		<div class="col-md-4">
			<?php include("left_menu.php") ?>
		</div>
		<div class="col-md-8">
			<h2>
				Opcje
			</h2>

<?php

if ($_GET['i']=="akt") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały zaktualizowane.</p>";}
if ($_GET['i']=="us") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały usunięte.</p>";}
if ($_GET['i']=="dod") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały dodane.</p>";}

 ?>

<?php


$wynik = mysql_query("SELECT * FROM opcje where id=1") or die('Błąd');// zapytanie do tabeli opcje
if(mysql_num_rows($wynik) > 0) {// jezeli wynik zapytania > 0 to tworzymy tabel do danych
    echo "<table class=\"table table-striped table-responsive\" ";
    echo "<tr><th>Długość godziny (min)</th><th>Długość przerwy (min)</th><th>Początek zajęć (godz)</th><th>Początek zajęć (min)</th><th></th></tr>";
    while($r = mysql_fetch_assoc($wynik)) {
        echo "<tr>";
        echo "<td style=\"vertical-align: middle;\"><form action=\"opcje.php\" method=\"post\">
        <input type=\"hidden\" name=\"a\" value=\"save\" />
        <input  class=\"tabela\"  type=\"text\" name=\"dl_godz\" value=\"".$r['dl_godz']."\" />
        </td>
        <td>
          <input  class=\"tabela\"  type=\"text\" name=\"dl_prz\" value=\"".$r['dl_prz']."\" />
        </td>
        <td>
          <input  class=\"tabela\"  type=\"text\" name=\"startg\" value=\"".$r['startg']."\" />
        </td>
        <td>
          <input  class=\"tabela\"  type=\"text\" name=\"startm\" value=\"".$r['startm']."\" />
        </td>
        <td style=\"vertical-align: middle;\" class=\"text-right\">
	<input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zmień\" /> </form>
        </td>";
        echo "</tr>";
    }
echo "</table>";

}

 ?>
		</div>
	</div>


<?php include("foot.php");?>
</div>

</body>
</html>
