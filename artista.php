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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO artistas (Id_Artista, NombreArt, Id_Genero, Id_Album) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id_Artista'], "text"),
                       GetSQLValueString($_POST['NombreArt'], "text"),
                       GetSQLValueString($_POST['Id_Genero'], "int"),
                       GetSQLValueString($_POST['Id_Album'], "int"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($insertSQL, $royal_music) or die(mysql_error());

  $insertGoTo = "artista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['Id_Artista'])) && ($_GET['Id_Artista'] != "")) {
  $deleteSQL = sprintf("DELETE FROM artistas WHERE Id_Artista=%s",
                       GetSQLValueString($_GET['Id_Artista'], "text"));

  mysql_select_db($database_royal_music, $royal_music);
  $Result1 = mysql_query($deleteSQL, $royal_music) or die(mysql_error());

  $deleteGoTo = "artista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_GET['Id_Artista'])) && ($_GET['Id_Artista'] != "")) {
  $deleteSQL = sprintf("DELETE FROM artistas WHERE Id_Artista=%s",
                       GetSQLValueString($_GET['Id_Artista'], "int"));

  mysql_select_db($database_royalmusic, $royalmusic);
  $Result1 = mysql_query($deleteSQL, $royalmusic) or die(mysql_error());

  $deleteGoTo = "artista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $deleteGoTo));
//KAREN SI ALGO FALLA ESTA LINEA LA DESCOMANTAS Y BORRAS LA DE ABAJO

header("location: artista.php");
}


mysql_select_db($database_royal_music, $royal_music);
$query_artista = "SELECT * FROM artistas";
$artista = mysql_query($query_artista, $royal_music) or die(mysql_error());
$row_artista = mysql_fetch_assoc($artista);
$totalRows_artista = mysql_num_rows($artista);
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <title>ARTISTAS | ROYAL MUSIC ADMINISTRADOR</title>
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
<li><a class="current" href="artista.php" title=""> ARTISTAS</a></li>
<li><a href="albumes.php" title=""> ALBUMES</a></li>
<li><a  href="generos.php" title=""> GENEROS</a></li>
<li><a href="importados.php" title=""> IMPORTADOS</a></li>
<li><a href="administrador.php" title=""> SALIR</a></li>

</ul>
</div>
</nav>
<div class="center_content_pages">
        
          <div class="financial-application-form">
<h2 align="center">&nbsp;</h2>
<h2 align="center">&nbsp;</h2>
              
<h2 align="center">ARTISTAS</h2>

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
		$stmt = conectar()->prepare("SELECT * FROM artistas WHERE Id_Artista = :id");
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
<p>&nbsp;</p>
<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Artista:</td>
      <td><input type="text" name="Id_Artista" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre Artista:</td>
      <td><input type="text" name="NombreArt" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Genero:</td>
      <td><input type="text" name="Id_Genero" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Album:</td>
      <td><input type="text" name="Id_Album" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="newsletter_submit" value="Insertar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
<div align="center">
  <table border="1">
    <tr>
      <td>No.Artista</td>
      <td>Nombre Artista</td>
      <td>Genero</td>
      <td>Album</td>
      <td>&nbsp;</td>
      </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_artista['Id_Artista']; ?></td>
        <td><?php echo $row_artista['NombreArt']; ?></td>
        <td><?php echo $row_artista['Id_Genero']; ?></td>
        <td><?php echo $row_artista['Id_Album']; ?></td>
        <td><a href="artista.php?Id_Artista=<?php echo $row_artista['Id_Artista']; ?>">
                      <input type="submit" class="newsletter_submit" value="ELIMINAR">
                    </a></td>
        </tr>
      <?php } while ($row_artista = mysql_fetch_assoc($artista)); ?>
  </table>
</div>
<div align="center"></div>
          </div>
</div>
</main>
</body>
</html>
<?php
mysql_free_result($artista);
?>
