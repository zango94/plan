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

$a = trim($_REQUEST['a']);
$id = trim($_GET['id']);


if($a == 'save') {

    $id = $_POST['id'];
    $nazwa = trim($_POST['nazwa']);
	$rodzaj = trim($_POST['rodzaj']);

    mysql_query("UPDATE sale SET numer='$nazwa',rodzaj='$rodzaj' WHERE id='$id'") or die('Błąd zapytania');
   // header('Location: sale.php?i=akt');
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'sale.php?i=akt';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'del') {

    $id = $_GET['id'];


    mysql_query("DELETE FROM sale WHERE id='$id'") or die('Błąd zapytania');
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'sale.php?i=us';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'add') {
    $id = $_POST['id'];
    $nazwa = trim($_POST['nazwa']);
	$rodzaj = trim($_POST['rodzaj']);

    mysql_query("INSERT INTO sale (numer,rodzaj) VALUES ('$nazwa','$rodzaj')") or die('Błąd zapytania');
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'sale.php?i=dod';
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
				Sale
			</h2>

<?php

if ($_GET['i']=="akt") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały zaktualizowane.</p>";}
if ($_GET['i']=="us") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały usunięte.</p>";}
if ($_GET['i']=="dod") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały dodane.</p>";}

 ?>

<?php

$wynik = mysql_query("SELECT * FROM sale order by numer") or die('Błąd');
$i=1;
if(mysql_num_rows($wynik) > 0) {
    echo "<table class=\"table table-striped table-responsive\" ";
    echo "<tr><th>Lp.</th><th>Nazwa</th><th>Rodzaj sali</th><th></th></tr>";
    while($r = mysql_fetch_assoc($wynik)) {
        echo "<tr>";
        echo "<td style=\"vertical-align: middle;\">".$i;
        $i=$i+1;
        echo "<td style=\"vertical-align: middle;\"><form action=\"sale.php\" method=\"post\"><input type=\"hidden\" name=\"a\" value=\"save\" />
        <input type=\"hidden\" name=\"id\" value=\"".$r['id']."\" />
        <input class=\"tabela\" type=\"text\" name=\"nazwa\" value=\"".$r['numer']."\" /></td>";
              
			  echo "<td style=\"vertical-align: middle;\">
        <input  class=\"tabela\" type=\"text\" name=\"rodzaj\" value=\"".$r['rodzaj']."\" /></td>";
			  
			  echo "<td style=\"vertical-align: middle;\" class=\"text-right\">
	<input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zmień\" /> </form>
        <a class=\"btn btn-danger btn-sm\" href=\"sale.php?a=del&amp;id={$r['id']}\">Usuń</a></td>";
        echo "</tr>";
    }
echo "
<tr>
<td style=\"vertical-align: middle;\">".$i."</td>
<td style=\"vertical-align: middle;\">
<form action=\"sale.php\" method=\"post\">
<input type=\"hidden\" name=\"a\" value=\"add\" />
<input placeholder=\"Nowy sala\" class=\"tabela\" type=\"text\" name=\"nazwa\" value=\"\" />
<td style=\"vertical-align: middle;\"><input placeholder=\"Rodzaj sali\" class=\"tabela\"  type=\"text\" name=\"rodzaj\" value=\"\" /></td>
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
