<?php 
	function conectar(){
		$link=new PDO("mysql:host=localhost;dbname=royal_music","root","");
		return $link;
	}
	if (isset($_POST['BUSCAR ALB'])){
		$stmt = conectar()->prepare("SELECT * FROM albumes WHERE ID_ALBUMN = :id");
		$stmt->bindParam(":id", $_POST['BUSCAR ALB']);
		$stmt->execute();
		$datos = $stmt->fetch();
		for($i=0; $i<count($datos)/2; $i++){
			echo "<br>".$datos[$i];
		}
	}
?>