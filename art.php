<?php 
	function conectar(){
		$link=new PDO("mysql:host=localhost;dbname=royal_music","root","");
		return $link;
	}
	if (isset($_POST['BUSCAR ARTS'])){
		$stmt = conectar()->prepare("SELECT * FROM artistas WHERE Id_Artista = :id");
		$stmt->bindParam(":id", $_POST['BUSCAR ARTS']);
		$stmt->execute();
		$datos = $stmt->fetch();
		for($i=0; $i<count($datos)/2; $i++){
			echo "<br>".$datos[$i];
		}
	}
?>