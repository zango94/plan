<?php include("config.php");
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
    if ((empty($nick)) AND (empty($haslo))) {
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'Location: logowanie.php?error=4';
			header("Location: http://$host$uri/$extra");
}
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
    if (empty($user[id]) OR !isset($user[id])) {
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'Location: logowanie.php?error=4';
			header("Location: http://$host$uri/$extra");
}

$a = trim($_REQUEST['a']);
$id = trim($_GET['id']);


if($a == 'save') {



    $wykl = (isset($_POST['wykladowca'])) ? 1 : 0;
    $adm = (isset($_POST['administrator'])) ? 1 : 0;

    /* odbieramy zmienne z formularza */
    $id = $_POST['id'];
    $st = trim($_POST['stopien']);
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $login = trim($_POST['login']);
    $haslo = trim($_POST['haslo']);

    if ($adm==0) {
      mysql_query("delete from uzytkownicy where id_pracownika='$id'") or die('Błąd zapytania1');
    }
    else {

      if (!empty($login) && !empty($haslo)){
        mysql_query("delete from uzytkownicy where id_pracownika='$id'") or die('Błąd zapytania2');
        mysql_query("INSERT INTO uzytkownicy (nick,haslo,id_pracownika) VALUES ('$login','$haslo','$id')") or die('Błąd zapytania3');
      }
      else {
        $host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'pracownicy.php?error=1';
		header("Location: http://$host$uri/$extra");break;
      }
    }


    /* uaktualniamy tabelÃª test */
    mysql_query("UPDATE pracownicy SET stopien='$st', imie='$imie', nazwisko='$nazwisko', wykladowca='$wykl', admin='$adm'  WHERE id='$id'") or die('Błąd zapytania');
    //echo 'Dane zostały zaktualizowane';
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'pracownicy.php?i=akt';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'del') {
    /* odbieramy zmienne z formularza */
    $id = $_GET['id'];

    /* uaktualniamy tabelÃª test */

    mysql_query("DELETE FROM pracownicy WHERE id='$id'") or die('Błąd zapytania');
    //echo 'Dane zostały usunięte';
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'pracownicy.php?i=us';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'add') {
    /* odbieramy zmienne z formularza */
    $st = trim($_POST['stopien']);
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $login = trim($_POST['login']);
    $haslo = trim($_POST['haslo']);


    /* uaktualniamy tabelÃª test */
    mysql_query("INSERT INTO pracownicy (stopien,imie,nazwisko) VALUES ('$st','$imie','$nazwisko')") or die('Błąd zapytania');
    //echo 'Dane zostały dodane';
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'pracownicy.php?i=dod';
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
	<link href="css/style3.css" rel="stylesheet">
  </head>
  <body>

  <div class="container">
	<?php include("head.php");?>

	<div class="row">
	<!--	<div class="col-md-4">
			<?php include("left_menu.php") ?>
		</div> -->
		<div class="col-md-12">
      <a class="btn btn-primary btn-large" href="admin.php">Powrót</a>
			<h2>
				Pracownicy
			</h2>

<?php

if ($_GET['i']=="akt") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały zaktualizowane.</p>";}
if ($_GET['i']=="us") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały usunięte.</p>";}
if ($_GET['i']=="dod") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały dodane.</p>";}
if ($_GET['error']==1) {echo "<p class=\"alert alert-danger\" role=\"alert\">Brak loginu lub hasła.</p>";} ?>



<?php



$wynik = mysql_query("SELECT pr.id,pr.stopien,pr.imie,pr.nazwisko,pr.wykladowca,pr.admin,uz.nick FROM pracownicy pr left join uzytkownicy uz on uz.id_pracownika=pr.id order by nazwisko") or die('Błąd');
$i=1;
if(mysql_num_rows($wynik) > 0) {
    echo "<table class=\"table table-striped table-responsive\" ";
    echo "<tr><th>Lp.</th><th>Stopień</th><th>Imię</th><th>Nazwisko</th><th>Wykładowca</th><th>Administrator</th><th>Login</th><th>Hasło</th><th></th></tr>";
    while($r = mysql_fetch_assoc($wynik)) {
        echo "<tr>";
        echo "<td style=\"vertical-align: middle;\">".$i;
        $i=$i+1;
        echo "<td style=\"vertical-align: middle;\"><form action=\"pracownicy.php\" method=\"post\"><input type=\"hidden\" name=\"a\" value=\"save\" />
        <input type=\"hidden\" name=\"id\" value=\"".$r['id']."\" />
        <input  class=\"tabela\" type=\"text\" name=\"stopien\" value=\"".$r['stopien']."\" /></td>";

        echo "<td style=\"vertical-align: middle;\">
        <input  class=\"tabela\" type=\"text\" name=\"imie\" value=\"".$r['imie']."\" /></td>";

        echo "<td style=\"vertical-align: middle;\">
        <input  class=\"tabela\" type=\"text\" name=\"nazwisko\" value=\"".$r['nazwisko']."\" /></td>";

        echo "<td style=\"vertical-align: middle;text-align: center;\">
              <input type=\"checkbox\" value=\"1\" id=\"wykladowca\" name=\"wykladowca\" ";

      	if ($r['wykladowca']==1) {
               echo "checked";
             }
        echo "></td>";

        echo "<td style=\"vertical-align: middle;text-align: center;\">
              <input type=\"checkbox\" value=\"1\" id=\"administrator\" name=\"administrator\" ";

      	if ($r['admin']==1) {
               echo "checked";
             }
        echo "></td>";

        echo "<td style=\"vertical-align: middle;width:100px;\">
        <input  class=\"log\" type=\"text\" name=\"login\" /></td>";

        echo "<td style=\"vertical-align: middle;width:100px;\">
        <input  class=\"log\" type=\"text\" name=\"haslo\" /></td>";



        echo "<td style=\"vertical-align: middle;\" class=\"text-right\">
        <input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zmień\" /> </form>
        <a class=\"btn btn-danger btn-sm\" href=\"pracownicy.php?a=del&amp;id={$r['id']}\">Usuń</a></td>";

        echo "</tr>";
    }




echo "
<tr>
<td style=\"vertical-align: middle;\">".$i."</td>
<td style=\"vertical-align: middle;\">
<form action=\"pracownicy.php\" method=\"post\">
<input type=\"hidden\" name=\"a\" value=\"add\" />
<input placeholder=\"Stopień\" class=\"tabela\" type=\"text\" name=\"stopien\" value=\"\" /></td>
<td style=\"vertical-align: middle;\"><input placeholder=\"Imię\" class=\"tabela\" type=\"text\" name=\"imie\" value=\"\" /></td>
<td style=\"vertical-align: middle;\"><input placeholder=\"Nazwisko\" class=\"tabela\" type=\"text\" name=\"nazwisko\" value=\"\" /></td>

<td></td>
<td></td>
<td></td>
<td></td>
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
