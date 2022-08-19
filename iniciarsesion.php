<?php require_once('Connections/royal_music.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['USUARIO'])) {
  $loginUsername=$_POST['USUARIO'];
  $password=$_POST['PASSWORD'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "Catalogo.html";
  $MM_redirectLoginFailed = "errorinise.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_royal_music, $royal_music);
  
  $LoginRS__query=sprintf("SELECT USUARIO, PASSWORD FROM registro WHERE USUARIO=%s AND PASSWORD=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $royal_music) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>ROYAL MUSIC</title>
        <link rel="stylesheet" href="style.css">
        <meta name="description" content="Compra de Musica Online">
        <meta name="keywords" content="comprar, descargar, musica, online, MP3">
    </head>
<body>
<main>
<div class="center_content_pages">
        
          <div class="financial-application-form">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
<h2 align="center">INICIAR SESION</h2>
             <p>&nbsp;</p>
             
<form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="registro">
  <table align="center">
      <tr valign="baseline">
      <td width="84" align="right" nowrap="nowrap">USUARIO:</td>
      <td width="188"><input type="text" name="USUARIO" size="32" required></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">PASSWORD:</td>
      <td><input type="password" name="PASSWORD" value="" size="32" required></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><center><input type="submit" class="newsletter_submit" value="Iniciar Sesion"></center></td>
    </tr>
  </table>
</form>

<p>&nbsp;</p>
<p>&nbsp; </p>
<p><a href="index.html">
  <input type="submit" class="newsletter_submit" value="VOLVER" />
</a></p>
<p align="right"><a href="administrador.php">
  <input type="submit" class="newsletter_submit" value="ADM" />
</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>           </div>
    </div>
</main>
</body>
</html>