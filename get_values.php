<?php

//////  Get sensor values from a basic webpage on the ESP8266
//////  This script gets 3 temperature values from 2 diffent ESP's 


$adrian_afara  = @file("http://192.168.1.136/");
$i=1;
foreach($adrian_afara  as $adrian ){
$var["adrian" . $i] = $adrian;
$i++;
}
extract($var);
$adrian1; //// LINIA 1
$adrian2; //// LINIA 2

if (empty($adrian_afara)) {
    echo "<font color=\"red\"> Erroare Senzori Afara - Calculator</font><br />"; 
	  /// IF ERROR or OFFLINE
    $adrian2 = "20";
    $adrian1 = "20";
	//shell_exec("notification_email.php");
}


$dormitor_data  = @file("http://192.168.1.158/");
$i=1;
foreach($dormitor_data  as $date_dormitor ){
$var["date_dormitor" . $i] = $date_dormitor;
$i++;
}
extract($var);
$date_dormitor1; //// LINIA 1

if (empty($dormitor_data)) {
    echo "<font color=\"red\">Erroare Senzori DORMITOR </font><br />"; 
	//// IF ERROR or Offline
  $Dormitor = "25";
	shell_exec("notification_email.php");
}

$Afara = $adrian2;
$Calculator= $adrian1;
$Dormitor = $date_dormitor1;
$Sufragerie = "25";

//echo "Afara: $Afara *C<br />";
//echo "Calculator: $Calculator *C<br />";
//echo "Dormitor: $Dormitor *C";
//echo "Sufragerie: $Sufragerie *C";

/// post this for a Python program.

$dormitortxt = fopen("dormitor.txt", "w") or die("Erroare Dormitor2.txt");
$txt = "$Dormitor";
fwrite($dormitortxt, $txt);
fclose($dormitortxt);


$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname); 
 if ($conn->connect_error) {
    die("Conectiunea la baza de date a esuat: " . $conn->connect_error) or die("Erroare baza de date");
 } 
$sql = "INSERT INTO temperaturi (afara, calculator, dormitor, sufragerie) VALUES ($Afara, $Calculator, $Dormitor, $Sufragerie );";
if ($conn->query($sql) === TRUE) {
	
	echo "Calculator: $Calculator *C <br/> Dormitor: $Dormitor*C <br/> Afara: $Afara*C <br/> Sufragerie: $Sufragerie*C <br /><font color=\"green\">Ok...</font>";
 } else {
    echo "<font color=\"red\"><br />A aparut o eroare MySql</font><br />";
	shell_exec("notification_email.php");
 }
 $conn->close();



//////SOURCE CODE 

//$lines  = @file("http://192.168.1.136/");
//$i=1;
//foreach($lines  as $line ){
//$var["line" . $i] = $line;
//$i++;
//}
//extract($var);

//echo $line1;
//echo $line2;
//echo $line3;


?>
