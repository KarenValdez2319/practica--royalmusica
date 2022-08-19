
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
  $insertSQL = sprintf("INSERT INTO administrador (Usuario, contrasena) VALUES (%s, %s)",
                       GetSQLValueString($_POST['Id_Genero'], "text"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($insertSQL, $royal_music) or die(mysql_error());
}

if ((isset($_GET['Id_Genero'])) && ($_GET['Id_Genero'] != "")) {
  $deleteSQL = sprintf("DELETE FROM generos WHERE Id_Genero=%s",
                       GetSQLValueString($_GET['Id_Genero'], "text"));

  mysql_select_db($database_royalmusic, $royalmusic);
  $Result1 = mysql_query($deleteSQL, $royalmusic) or die(mysql_error());

  $deleteGoTo = "generos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
   //header(sprintf("Location: %s", $deleteGoTo));
//KAREN SI ALGO FALLA ESTA LINEA LA DESCOMANTAS Y BORRAS LA DE ABAJO
header("location: generos.php");
}

mysql_select_db($database_royal_music, $royal_music);
$query_Generos = "SELECT * FROM generos";
$Generos = mysql_query($query_Generos, $royal_music) or die(mysql_error());
$row_Generos = mysql_fetch_assoc($Generos);
$totalRows_Generos = mysql_num_rows($Generos);
$query_Generos = "SELECT * FROM generos";
$Generos = mysql_query($query_Generos, $royal_music) or die(mysql_error());
$row_Generos = mysql_fetch_assoc($Generos);
$totalRows_Generos = mysql_num_rows($Generos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <title>GENEROS | ROYAL MUSIC ADMINISTRADOR</title>
        <link rel="stylesheet" href="style.css">
        <meta name="description" content="Compra de Musica Online">
        <meta name="keywords" content="comprar, descargar, musica, online, MP3">
</head>
<body>
<main>
<nav>
<div id="menu">
<ul>
<li><a href="menuadm.php" title=""> INICIO</a></li>
<li><a href="artista.php" title=""> ARTISTAS</a></li>
<li><a href="albumes.php" title=""> ALBUMES</a></li>
<li><a class="current" href="generos.php" title=""> GENEROS</a></li>
<li><a href="importados.php" title=""> IMPORTADOS</a></li>
<li><a href="administrador.php"> SALIR</a></li>


</ul>
</div>
</nav>
<div class="center_content_pages">
        
          <div class="financial-application-form">
<h2 align="center">&nbsp;</h2>
<h2 align="center">&nbsp;</h2>

<h2 align="center">GENEROS</h2>

  </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</form>
             <p>&nbsp;</p>
             <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
               <table align="center">
                 <tr valign="baseline">
                   <td nowrap align="right">Género:</td>
                   <td><input type="text" name="Id_Genero" value="" size="32"></td>
                 </tr>
                 <tr valign="baseline">
                   <td nowrap align="right">Descripción:</td>
                   <td><input type="text" name="DESCRIPCION" value="" size="32"></td>
                 </tr>
                 <tr valign="baseline">
                   <td nowrap align="right">&nbsp;</td>
                   <td><input type="submit" class="newsletter_submit" value="Insertar Genero"></td>
                 </tr>
               </table>
               <input type="hidden" name="MM_insert" value="form1">
             </form>
            <p>&nbsp;</p>
            <div align="center">
              <table border="0">
                <tr>
                  <td>Genero</td>
                  <td><p>Nombre del Genero</p></td>
                  <td>&nbsp;</td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td><?php echo $row_Generos['Id_Genero']; ?></td>
                    <td><?php echo $row_Generos['DESCRIPCION']; ?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php } while ($row_Generos = mysql_fetch_assoc($Generos)); ?>
              </table>
            </div>
          </div>
</div>
</main>
</body>
</html>
<?php
mysql_free_result($Generos);
?>