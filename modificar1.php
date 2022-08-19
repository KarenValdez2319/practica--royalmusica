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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE albumes SET NombreAlb=%s, Id_Genero=%s, Disquera=%s, Artista=%s, Formato=%s, Fecha_de_lanzamiento=%s, Precio=%s, PiezasAlb=%s WHERE ID_ALBUMN=%s",
                       GetSQLValueString($_POST['NombreAlb'], "text"),
                       GetSQLValueString($_POST['Id_Genero'], "text"),
                       GetSQLValueString($_POST['Disquera'], "text"),
                       GetSQLValueString($_POST['Artista'], "text"),
                       GetSQLValueString($_POST['Formato'], "text"),
                       GetSQLValueString($_POST['Fecha_de_lanzamiento'], "date"),
                       GetSQLValueString($_POST['Precio'], "text"),
                       GetSQLValueString($_POST['PiezasAlb'], "text"),
                       GetSQLValueString($_POST['ID_ALBUMN'], "int"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($updateSQL, $royal_music) or die(mysql_error());

  $updateGoTo = "albumes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_royal_music, $royal_music);
$query_albumes = "SELECT * FROM albumes";
$albumes = mysql_query($query_albumes, $royal_music) or die(mysql_error());
$row_albumes = mysql_fetch_assoc($albumes);
$totalRows_albumes = mysql_num_rows($albumes);

mysql_free_result($albumes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <title>ALBUMES | ROYAL MUSIC ADMINISTRADOR</title>
        <link rel="stylesheet" href="style.css">
        <meta name="description" content="Compra de Musica Online">
        <meta name="keywords" content="comprar, descargar, musica, online, MP3">
</head>
<body>
<main>
<nav>
<div id="logo">
            <div align="center"></div>
    </div>
<div id="menu">
<ul>
<li><a href="menuadm.php" title=""> INICIO</a></li>
<li><a href="artista.php" title=""> ARTISTAS</a></li>
<li><a class="current" href="albumes.php" title=""> ALBUMES</a></li>
<li><a  href="generos.php" title=""> GENEROS</a></li>
<li><a href="importados.php" title=""> IMPORTADOS</a></li>
<li><a href="administrador.php"> SALIR</a></li>

</ul>
</div>
</nav>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Codigo de album</td>
      <td><?php echo $row_albumes['ID_ALBUMN']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre Album:</td>
      <td><input type="text" name="NombreAlb" value="<?php echo htmlentities($row_albumes['NombreAlb'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Genero:</td>
      <td><input type="text" name="Id_Genero" value="<?php echo htmlentities($row_albumes['Id_Genero'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Disquera:</td>
      <td><input type="text" name="Disquera" value="<?php echo htmlentities($row_albumes['Disquera'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Artista:</td>
      <td><input type="text" name="Artista" value="<?php echo htmlentities($row_albumes['Artista'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Formato:</td>
      <td><input type="text" name="Formato" value="<?php echo htmlentities($row_albumes['Formato'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fecha Ingreso:</td>
      <td><input type="text" name="Fecha_de_lanzamiento" value="<?php echo htmlentities($row_albumes['Fecha_de_lanzamiento'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Precio:</td>
      <td><input type="text" name="Precio" value="<?php echo htmlentities($row_albumes['Precio'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Piezas por Album:</td>
      <td><input type="text" name="PiezasAlb" value="<?php echo htmlentities($row_albumes['PiezasAlb'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="ID_ALBUMN" value="<?php echo $row_albumes['ID_ALBUMN']; ?>">
</form>
<p>&nbsp;</p>
</main>
</body>
</html>