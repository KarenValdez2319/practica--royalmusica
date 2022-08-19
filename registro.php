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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO registro (USUARIO, EMAIL, PASSWORD) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['USUARIO'], "text"),
                       GetSQLValueString($_POST['EMAIL'], "text"),
                       GetSQLValueString($_POST['PASSWORD'], "text"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($insertSQL, $royal_music) or die(mysql_error());

  $insertGoTo = "Catalogo.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_royal_music, $royal_music);
$query_Registro = "SELECT * FROM registro";
$Registro = mysql_query($query_Registro, $royal_music) or die(mysql_error());
$row_Registro = mysql_fetch_assoc($Registro);
$totalRows_Registro = mysql_num_rows($Registro);
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
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<h2 align="center">&nbsp;</h2>
<h2 align="center">&nbsp;</h2>
<h2 align="center">&nbsp;</h2>
<h2 align="center">REGISTRATE</h2>
             
             <p>Realiza tu registro para obtener más beneficios</p>
             <p align="center">&nbsp;</p>
             
            <div class="form">
                  
<p>&nbsp;</p><form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table align="center">
    <tr valign="baseline">
      <td align="right" nowrap class="text">USUARIO:</td>
      <td><input type="text" name="USUARIO" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="text">EMAIL:</td>
      <td><input type="text" name="EMAIL" value="" size="32"></td>
      
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap class="text">PASSWORD:</td>
      <td><input type="password" name="PASSWORD" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="newsletter_submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p><a href="iniciarsesion.php">
  <input type="submit" class="newsletter_submit" value="Iniciar sesion" />
</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p></p>
<p></p>

<p><center><a href="iniciarsesion.php"></a></center></p>
              </div>
        </div>
    </div>
    </main>
</body>
</html>
<?php
mysql_free_result($Registro);
?>
