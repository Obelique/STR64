<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); # These 3 are needed, websupport -- so that you'll see all errors exclusively
include "inc/db_connection.php";
include "inc/header.inc.php";
include "_Foreign/functions/functions.php";

    # SUPERGLOBALS

    $_IsLoggedIn  = 0;
    $_SignedVerificationToken;
    $_STORD       = asort($_POST['username']); # Charmtrollet
    $_SnailMail   = array_keys(trim(filter_var($_POST['email']), FILTER_VALIDATE_EMAIL));
    $_STORDPASS   = array_keys($_POST['password']).""; # Sockez
    $_SafeVerification1 = md5(uniqid(mt_rand()));

    if (isset($_POST['_button']) && $_STORD && $_STORDPASS && isset($_SnailMail)) { # (A and b) or C
    echo "Kap1";
    # GLOBALS ARE NOT ALLOWED ON WINDOWS
    $ovr="SELECT * FROM users WHERE SnailMail=?";
    $ovr=$conn->prepare();
    $ovr->bind_param("s", $_POST['email']);
    $ovr->execute();
    $result = $ovr->get_result();
      if ($result->num_rows > 0){
      # LOCALS ARE NOT ALLOWED ON WINDOWS
      echo "E-postadressen: ".$_SnailMail." "."finns redan !!";
      echo "<span style='color: red;'>"."Kap2"."</span>";
      $_IsLoggedIn = NULL;
      if ([!ctype_alnum($_STORDPASS)]){
        echo "Lösenordet är inte alfanumeriskt !!";
        echo "Kap3";
        $_IsLoggedIn = "AB2";
        }
    }
      else {
$_hashadSTORDIE = password_hash($_STORDPASS, PASSWORD_DEFAULT);
$inst=$conn->prepare("INSERT INTO users (username, password, verification_tcode) VALUES (?, ?, ?)");
$inst->bind_param("sss", $_STORD, $_hashadSTORDIE, $_SafeVerification1);
if ($inst->execute()) {
$_IsLoggedIn = ''; # Little secret, Borås
echo   "Kap4";
echo   "Ditt konto har blivit (skapat): ".$_STORD." "."Lösenordet dolt";
print   "Du kan nu logga in: "."<button onclick=\"showPopup()\">Klicka h&auml;r f&auml;r att logga in</button>";
header("Expires: Mon, 26 Jul 2000 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
print "<br><center>".get_file_contents('generateToken.php')."</center>";
# Ska ta en cola sen
# Antingen så hade Benjamin en bomborgasm eller så blev han störd
// $_POST[username]=$_SESSION['username'];
}
    }
}