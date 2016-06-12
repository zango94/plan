<?php include("config.php");
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
    if ((empty($nick)) AND (empty($haslo))) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=4';
	header("Location: http://$host$uri/$extra");
}// sprawdzanie loginu i hasła
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
    if (empty($user[id]) OR !isset($user[id])) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=4';
	header("Location: http://$host$uri/$extra");
}// spradzanie czy użytkownik istnieje

$a = trim($_REQUEST['a']);
$id = trim($_GET['id']);


if($a == 'save') {

    $id = $_POST['id'];
    $nazwa = trim($_POST['nazwa']);
	$komentarz = trim($_POST['komentarz']);
	/* aktualizacja tabeli przedmioty */
    mysql_query("UPDATE przedmioty SET nazwa='$nazwa', komentarz='$komentarz' WHERE id='$id'") or die('Błąd zapytania');
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'przedmioty.php?i=akt';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'del') {
    $id = $_GET['id'];
    $nazwa = trim($_POST['nazwa']);
	$komentarz = trim($_POST['komentarz']);
	/* usuwanie danych z tabeli przedmioty */
    mysql_query("DELETE FROM przedmioty WHERE id='$id'") or die('Błąd zapytania');
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'przedmioty.php?i=us';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'add') {
    $id = $_POST['id'];
    $nazwa = trim($_POST['nazwa']);
	$komentarz = trim($_POST['komentarz']);
	/* dodawanie danych do tabeli przedmioty */
    mysql_query("INSERT INTO przedmioty (nazwa,komentarz) VALUES ('$nazwa','$komentarz')") or die('Błąd zapytania');
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'przedmioty.php?i=dod';
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
	<link href="css/style.css" rel="stylesheet">
	<link href="css/style2.css" rel="stylesheet">
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
				Przedmioty
			</h2>

<?php

if ($_GET['i']=="akt") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały zaktualizowane.</p>";}
if ($_GET['i']=="us") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały usunięte.</p>";}
if ($_GET['i']=="dod") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały dodane.</p>";}

 ?>

<?php



$wynik = mysql_query("SELECT * FROM przedmioty order by nazwa") or die('Błąd');// zapytanie do tabeli przedmioty
$i=1;
if(mysql_num_rows($wynik) > 0) {// jezeli wynik zapytania > 0 tworzymy tabele z polami do wpisania danych
    echo "<table class=\"table table-striped table-responsive\" ";
    echo "<tr><th>Lp.</th><th>Nazwa</th><th>Komentarz</th><th></th></tr>";
    while($r = mysql_fetch_assoc($wynik)) {
        echo "<tr>";
        echo "<td style=\"vertical-align: middle;\">".$i;
        $i=$i+1;
        echo "<td style=\"vertical-align: middle;\"><form action=\"przedmioty.php\" method=\"post\"><input type=\"hidden\" name=\"a\" value=\"save\" />
        <input type=\"hidden\" name=\"id\" value=\"".$r['id']."\" />
		<input  class=\"tabela2\" type=\"text\" name=\"nazwa\" value=\"".$r['nazwa']."\" /></td>";
        
		echo "<td style=\"vertical-align: middle;\">
        <input  class=\"tabela\" type=\"text\" name=\"komentarz\" value=\"".$r['komentarz']."\" /></td>";
		
		echo "<td style=\"vertical-align: middle;\" class=\"text-right\">
		<input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zmień\" /> </form>
        <a class=\"btn btn-danger btn-sm\" href=\"przedmioty.php?a=del&amp;id={$r['id']}\">Usuń</a></td>";
        echo "</tr>";
    }
/* wyświetlenie pól do wpisania nowego przemiotu */
echo "
<tr>
<td style=\"vertical-align: middle;\">".$i."</td>
<td style=\"vertical-align: middle;\">
<form action=\"przedmioty.php\" method=\"post\">
<input type=\"hidden\" name=\"a\" value=\"add\" />
<input placeholder=\"Nowy przedmiot\" class=\"tabela\" type=\"text\" name=\"nazwa\" value=\"\" />
<td style=\"vertical-align: middle;\"><input placeholder=\"Komentarz\" class=\"tabela\" type=\"text\" name=\"komentarz\" value=\"\" /></td>
</td>
<td class=\"text-right\">
<input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Dodaj\" />
</td>
</form>
</tr>
";

    echo "</table>";
}

 ?>
		</div>
	</div>

<?php include("foot.php");?>
</div>

</body>
</html>
