<?php session_start();
mysql_connect("localhost","root","") or die(mysql_error()."Nie mozna polaczyc sie z baza danych. Prosze chwile odczekac i sprobowac ponownie.");
mysql_select_db("plan") or die(mysql_error()."Nie mozna wybrac bazy danych.");
?>
