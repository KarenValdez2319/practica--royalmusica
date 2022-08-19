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
  $insertSQL = sprintf("INSERT INTO albumes (ID_ALBUMN, NombreAlb, Id_Genero, Disquera, Artista, Formato, Fecha_de_lanzamiento, Precio, PiezasAlb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID_ALBUMN'], "int"),
                       GetSQLValueString($_POST['NombreAlb'], "text"),
                       GetSQLValueString($_POST['Id_Genero'], "text"),
                       GetSQLValueString($_POST['Disquera'], "text"),
                       GetSQLValueString($_POST['Artista'], "text"),
                       GetSQLValueString($_POST['Formato'], "text"),
                       GetSQLValueString($_POST['Fecha_de_lanzamiento'], "date"),
                       GetSQLValueString($_POST['Precio'], "text"),
                       GetSQLValueString($_POST['PiezasAlb'], "text"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($insertSQL, $royal_music) or die(mysql_error());

  $insertGoTo = "albumes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['ID_ALBUMN'])) && ($_GET['ID_ALBUMN'] != "")) {
  $deleteSQL = sprintf("DELETE FROM albumes WHERE ID_ALBUMN=%s",
                       GetSQLValueString($_GET['ID_ALBUMN'], "int"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($deleteSQL, $royal_music) or die(mysql_error());

  $deleteGoTo = "albumes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_GET['ID_ALBUMN'])) && ($_GET['ID_ALBUMN'] != "")) {
  $deleteSQL = sprintf("DELETE FROM albumes WHERE ID_ALBUMN=%s",
                       GetSQLValueString($_GET['ID_ALBUMN'], "int"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($deleteSQL, $royal_music) or die(mysql_error());

  $deleteGoTo = "album.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  
header("location: artista.php");
}
mysql_select_db($database_royal_music, $royal_music);
$query_albumes = "SELECT * FROM albumes";
$albumes = mysql_query($query_albumes, $royal_music) or die(mysql_error());
$row_albumes = mysql_fetch_assoc($albumes);
$totalRows_albumes = mysql_num_rows($albumes);
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
<li><a href="iniciarsesion.php"> SALIR</a></li>

</ul>
</div>
</nav>
<div class="center_content_pages">
        
          <div class="financial-application-form">
            <h2 align="center">&nbsp;</h2>
<h2 align="center">&nbsp;</h2>
<h2 align="center">&nbsp;</h2>
<h2 align="center">ALBUMES</h2>
             <p>&nbsp;</p>
             <!-- FORMULARIO BUSQUEDA -->
<form method="post">
    <p>&nbsp;</p>
    <p>
      <input type="text" name="BUSCAR" placeholder="BUSCAR">
    <input type="submit" class="newsletter_submit" value="BUSCAR">
    </p>
      <?php 
	function conectar(){
		$link=new PDO("mysql:host=localhost;dbname=royal_music","root","");
		return $link;
	}
	if (isset($_POST['BUSCAR'])){
		$stmt = conectar()->prepare("SELECT * FROM albumes WHERE ID_ALBUMN = :id");
		$stmt->bindParam(":id", $_POST['BUSCAR']);
		$stmt->execute();
		$datos = $stmt->fetch();
		for($i=0; $i<count($datos)/2; $i++){
			echo "<br>".$datos[$i];
		}
	}
?>
</form>
<!-- FIN FORMULARIO BUSQUEDA -->

    <div align="center"></div>
</div>
</div>
<form method="post" name="form2">
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<table border="1">
  <tr>
    <td>Codigo de Album</td>
    <td>Nombre Album</td>
    <td>Genero</td>
    <td>Disquera</td>
    <td>Artista</td>
    <td>Formato</td>
    <td>Fecha de Igreso</td>
    <td>Precio</td>
    <td>PIEZ POR ALBUM</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_albumes['ID_ALBUMN']; ?></td>
      <td><?php echo $row_albumes['NombreAlb']; ?></td>
      <td><?php echo $row_albumes['Id_Genero']; ?></td>
      <td><?php echo $row_albumes['Disquera']; ?></td>
      <td><?php echo $row_albumes['Artista']; ?></td>
      <td><?php echo $row_albumes['Formato']; ?></td>
      <td><?php echo $row_albumes['Fecha_de_lanzamiento']; ?></td>
      <td><?php echo $row_albumes['Precio']; ?></td>
      <td><?php echo $row_albumes['PiezasAlb']; ?></td>
      <td><a href="modificar1.php"><input type="submit" class="newsletter_submit" value="MODIFICAR"></a></td>
      <td><a href="albumes.php?ID_ALBUMN=<?php echo $row_albumes['ID_ALBUMN']; ?>"><input type="submit" class="newsletter_submit" value="ELIMINAR"></a></td>
    </tr>
    <?php } while ($row_albumes = mysql_fetch_assoc($albumes)); ?>
</table>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<table align="center">
  <tr valign="baseline">
    <td nowrap align="right">Codigo del Album:</td>
    <td><input type="text" name="ID_ALBUMN" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Nombre Album:</td>
    <td><input type="text" name="NombreAlb" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Genero:</td>
    <td><input type="text" name="Id_Genero" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Disquera:</td>
    <td><input type="text" name="Disquera" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Artista:</td>
    <td><input type="text" name="Artista" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Formato:</td>
    <td><input type="text" name="Formato" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Fecha de ingreso:</td>
    <td><input type="text" name="Fecha_de_lanzamiento" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Precio:</td>
    <td><input type="text" name="Precio" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td nowrap align="right">Piezas por Album:</td>
    <td><input type="text" name="PiezasAlb" value="" size="32"></td>
  </tr>
  <tr valign="baseline">
    <td height="35" align="right" nowrap>&nbsp;</td>
    <td><input type="submit" class="newsletter_submit" value="Insertar registro"></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</main>
</body>
</html>
<?php
mysql_free_result($albumes);
?>
