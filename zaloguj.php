<?php include("config.php"); ?>
<?php
$login = $_POST['login'];
$haslo = $_POST['haslo'];
$haslo = addslashes($haslo);
$login = addslashes($login);
$login = htmlspecialchars($login);

if ($_GET['login'] != '') { //jezeli ktos przez adres probuje kombinowac
exit;
}
if ($_GET['haslo'] != '') { //jezeli ktos przez adres probuje kombinowac
exit;
}

//$haslo = md5($haslo); //szyfrowanie hasla
    if (!$login OR empty($login)) {
//include("head2.php");
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=1';
	header("Location: http://$host$uri/$extra");
//echo '<p class="alert">Wypełnij pole z loginem!</p>';
//include("foot.php");
exit;
}
    if (!$haslo OR empty($haslo)) {
//include("head2.php");
$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=2';
	header("Location: http://$host$uri/$extra");
//echo '<p class="alert">Wypełnij pole z hasłem!</p>';
//include("foot.php");
exit;
}


$istnick = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM `uzytkownicy` WHERE `nick` = '$login' AND `haslo` = '$haslo'")); // sprawdzenie czy istnieje uzytkownik o takim nicku i hasle
    if ($istnick[0] == 0) {
//echo 'Logowanie nieudane. Sprawdź pisownię nicku oraz hasła.';
$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'logowanie.php?error=3';
	header("Location: http://$host$uri/$extra");
    } else {

$_SESSION['nick'] = $login;
$_SESSION['haslo'] = $haslo;

header("Location: admin.php");
}
?>
