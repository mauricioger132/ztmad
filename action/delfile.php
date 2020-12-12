<?php
session_start();
include "../config/config.php";

if(isset($_GET["tkn"]) && $_GET["tkn"]==$_SESSION["tkn"]){
	$id_code=$_GET["id"];
	
	$file = mysqli_query($con, "select * from file where code=\"$id_code\"");

	if(mysqli_num_rows($file)>0){
	
		while ($rows=mysqli_fetch_array($file)) {
			$id=$rows['id'];
			$filename=$rows['filename'];
		}
		$query=mysqli_query($con, "SELECT COUNT(*) AS num FROM datafiles WHERE file_id=".$id);
		$row=mysqli_fetch_array($query);
		$num=$row['num'];
		if($num>0){
			echo "Hubo un error al eliminar ";
			header("location: ../myfiles.php?delerror");
		}else{

			$query=mysqli_query($con, "SELECT * FROM permision WHERE file_id=$id");
			if($count=mysqli_num_rows($query)>0){
				echo "Hubo un error al eliminar ";
				header("location: ../myfiles.php?delpermision");
			}else{

				$url = "../storage/data/".$_SESSION["user_id"]."/";
				@unlink($url.$filename);
				$del_permision=mysqli_query($con, "DELETE FROM permision WHERE file_id=$id");
				$del_comment=mysqli_query($con, "DELETE  FROM COMMENT WHERE file_id=$id");
				$del=mysqli_query($con, "delete  from file where id='$id'");
				echo "Eliminado exitosamente!";
				header("location: ../myfiles.php?delsuccess");	
			}
		}
	}else{

		$query=mysqli_query($con, "SELECT * FROM permision WHERE CODE='$id_code'");
		if($count=mysqli_num_rows($query)>0){
			echo "Hubo un error al eliminar ";
			header("location: ../myfiles.php?delpermision");
		}else{
			$del=mysqli_query($con, "DELETE  FROM COMMENT WHERE code=$id_code");
			$del=mysqli_query($con, "delete  from datafiles where code='$id_code'");	
			if($del){
				echo "Eliminado exitosamente!";
				header("location: ../myfiles.php?delsuccess");	
			}else{
				echo "Hubo un error al eliminar ";
				header("location: ../myfiles.php?delerror");
			}
		}
	}
}else{

	// echo "Permiso Denegado!";
	header("location: ../myfiles.php?delinvalid");
}

// header("location: ../myfiles.php");

?>