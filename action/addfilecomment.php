<?php
	session_start();
	include "../config/config.php";

if(!empty($_POST)){

	$code=$_POST["code"];
	
	$file=mysqli_query($con, "select * from file where code='$code'");
	if(mysqli_num_rows($file)===0){

		$file=mysqli_query($con,"SELECT f.id,
										f.user_id,
										df.code
								FROM datafiles AS df 
								INNER JOIN FILE AS f ON df.file_id=f.id where df.code=\"$code\"");
	}
	while ($rowc=mysqli_fetch_array($file)) {
		$id=$rowc['id'];
		$code=$rowc['code'];
		
	}


	$user_id= $_SESSION["user_id"];
	$file_id = $id;
	$comment= $_POST["comment"];
	$created_at = "NOW()";
	$sql = "insert into comment (comment,file_id,user_id,code,created_at) ";
	$sql .= "value (\"$comment\",\"$file_id\",$user_id,'$code',$created_at)";

	$query=mysqli_query($con, $sql);
	if ($query) {
		// echo "tu comentario fue con exito";
		header("location: ../file.php?code=$code&success");
	} else {
		// echo "hubo in error al agregar tu comentario";
		header("location: ../file.php?code=$code&error");
	}



}

?>