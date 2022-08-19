<?php function conectar(){
		$link=new PDO("mysql:host=localhost;dbname=royal_music","root","");
		return $link;
	}
$Id_Genero = $POST['Id_Genero'];
$DESCRIPCION = $POST['DESCRIPCION'];

mysql_select_db($database_royalmusic, $royalmusic) or die ("Error al conectar");
mysql_query("UPDATE generos SET Id_Genero = '$Id_Genero', DESCRIPCION= $DESCRIPCION WHERE  Id_Genero ='$Id_Genero'");
echo "Modificado Correctamente";

?>
