<?php include("config.php");
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
    if ((empty($nick)) AND (empty($haslo))) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=4';
	header("Location: http://$host$uri/$extra");
//sprawdzenie loginu i hasła
}
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
    if (empty($user[id]) OR !isset($user[id])) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=4';
	header("Location: http://$host$uri/$extra");
//sprawdzenie czy istnieje użytkownik
}

$a = trim($_REQUEST['a']);
$id = trim($_GET['id']);


if($a == 'save') {

   
    $id = $_POST['id'];
    $nazwa = trim($_POST['nazwa']);
    $id_rocznika=$_POST['id_rocznika'];

    /* aktualizacja tabeli grupy */
    mysql_query("UPDATE grupy SET nazwa='$nazwa',id_rocznika='$id_rocznika' WHERE id='$id'") or die('Błąd zapytania');
    //echo 'Dane zostały zaktualizowane';
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'grupy.php?i=akt';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'del') {
    $id = $_GET['id'];


    /* usuwanie danych z tabeli grupy */
    mysql_query("DELETE FROM grupy WHERE id='$id'") or die('Błąd zapytania');
    //echo 'Dane zostały usunięte';
    $host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'grupy.php?i=us';
	header("Location: http://$host$uri/$extra");
}
elseif($a == 'add') {
    $id = $_POST['id'];
    $nazwa = trim($_POST['nazwa']);
    $id_rocznika=$_POST['id_rocznika'];

    /* dodawanie danych do tabeli grupy */
    mysql_query("INSERT INTO grupy (nazwa,id_rocznika) VALUES ('$nazwa','$id_rocznika')") or die('Błąd zapytania');
    	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'grupy.php?i=dod';
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
				Podział na grupy
			</h2>

<?php

if ($_GET['i']=="akt") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały zaktualizowane.</p>";}
if ($_GET['i']=="us") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały usunięte.</p>";}
if ($_GET['i']=="dod") {echo "<p class=\"alert alert-success\" role=\"alert\">Dane zostały dodane.</p>";}

 ?>

<?php



$wynik = mysql_query("SELECT * FROM grupy order by nazwa") or die('Błąd'); // zapytanie do tabeli grupy
$i=1;
if(mysql_num_rows($wynik) > 0) { // jeżeli wynik < 0 tworzymy tabele z polami do wypełnienia
    echo "<table class=\"table table-striped table-responsive\" ";
    echo "<tr><th>Lp.</th><th>Nazwa</th><th>Rocznik</th><th></th></tr>";
    while($r = mysql_fetch_assoc($wynik)) {
        echo "<tr>";
        echo "<td style=\"vertical-align: middle;\">".$i;
        $i=$i+1;
        echo "<td style=\"vertical-align: middle;\">
        <form action=\"grupy.php\" method=\"post\"><input type=\"hidden\" name=\"a\" value=\"save\" />
        <input type=\"hidden\" name=\"id\" value=\"".$r['id']."\" />
        <input  class=\"tabela\" type=\"text\" name=\"nazwa\" value=\"".$r['nazwa']."\" /></td>";

       echo "<td><select class=\"form-control\" name=\"id_rocznika\">";
        $w = mysql_query("SELECT * FROM rocznik order by nazwa") or die('Błąd');
        while($ro = mysql_fetch_assoc($w)) {

            echo "<option ";
            if ($ro['id']==$r['id_rocznika']) {
              echo "selected=\"selected\"";
            }
            echo " value=\"".$ro['id']."\">".$ro['nazwa']."</option>";
        }
        echo "</select></td>";


        echo "<td style=\"vertical-align: middle;\" class=\"text-right\">
	<input class=\"btn btn-success btn-sm\" type=\"submit\" value=\"Zmień\" /> </form>
        <a class=\"btn btn-danger btn-sm\" href=\"grupy.php?a=del&amp;id={$r['id']}\">Usuń</a></td>";
        echo "</tr>";
    }



/* wyświetlamy pole do dodania nowej grupy */
echo "
<tr>
<td style=\"vertical-align: middle;\">".$i."</td>
<td style=\"vertical-align: middle;\">
<form action=\"grupy.php\" method=\"post\">
<input type=\"hidden\" name=\"a\" value=\"add\" />
<input placeholder=\"Nowa grupa\" class=\"tabela\" type=\"text\" name=\"nazwa\" value=\"\" />
</td>";

echo "<td><select class=\"form-control\" name=\"id_rocznika\">";
 $w = mysql_query("SELECT * FROM rocznik order by nazwa") or die('Błąd');
 while($ro = mysql_fetch_assoc($w)) {

     echo "<option ";
     if ($ro['id']==$r['id_rocznika']) {
       echo "selected=\"selected\"";
     }
     echo " value=\"".$ro['id']."\">".$ro['nazwa']."</option>";
 }
 echo "</select></td>";


echo "<td class=\"text-right\">
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
