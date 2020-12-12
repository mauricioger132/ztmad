<?php
	session_start();
	include "../config/config.php";
	//hacer una consulta para que el usuario no pueda darle dos o mas veces permisos por un archivo

	if(!empty($_POST)){ 
	
		$nick=$_POST["email"];
		$user = mysqli_query($con, "select * from user where email=\"$nick\"");//Primero se verifica el usuario
		while ($rowu=mysqli_fetch_array($user)) {
			$user_id=$rowu['id'];
		}
		$file_code=$_POST["file_code"];
		// Si se va a compartir toda la carpeta viene y se busca el código dentro de file
		$file = mysqli_query($con, "select * from file where code='$file_code'");
		$count=mysqli_num_rows($file); //si existe el codigo en file
		$status="";
		if($count===0){
			//Si se va a compartir un archivo dentro de una carpeta viene a datafiles
			$file = mysqli_query($con,"select * from datafiles where code=\"$file_code\"");
			$status=1;
		}
		if($user_id!=null){ // si el usuario es null no existe
			if($user_id!=$_SESSION["user_id"]){ // Si el usuario es igual entonces no se puede compartir el mismo
				while ($rowf=mysqli_fetch_array($file)) {
			
					$file_code=$rowf['code'];
					$p_id= $_POST["p_id"];
					$created_at = "NOW()";
					$query=mysqli_query($con, "SELECT * FROM permision WHERE CODE='$file_code' AND user_id=$user_id");
					
					if(mysqli_num_rows($query)>0){// Si el codigo y el usuario se quiere volver a insertar esta duplicado
						header("location: ../filepermision.php?id=".$file_code."&duplicado");
					}else{// Si el usuario no esta duplicado se inserta
						
						if(isset($rowf["file_id"])){ // Si el permiso viene de datafiles entonces entra a esta condicion
								
							$id_file=$rowf["file_id"];
							$file_id=$rowf['file_id'];
							$query = mysqli_query($con, "SELECT shared from permision WHERE user_id=$user_id AND file_id=$file_id AND shared=2");
							
							if(mysqli_num_rows($query)>0){
								$resp=mysqli_fetch_array($query);
								$shared=$resp['shared'];
							}else{	
								$shared=0;
							}
						
							if($shared==1){
								header("location: ../filepermision.php?id=".$file_code."&permision");
							}else{
						
								$sql = "insert into permision (p_id,file_id,user_id,code,shared,created_at)";
								$sql .= "value ($p_id,\"$file_id\",$user_id,'$file_code',2,$created_at)";
								$query=mysqli_query($con, $sql);
								if ($query) {
									// echo "Agregado exitosamente!";
									header("location: ../filepermision.php?id=".$file_code."&success");
								} else {
									// echo "Hubo un error al dar los permisos!";
									header("location: ../filepermision.php?id=".$file_code."&error");
								}
							}

						}else{ // Si es desde carpeta y tiene que compartirse todos los archivos
								
							$file_id=$rowf['id']; // se obitine el id de file 
							$shared=$rowf['shared_file'];
						
							$resp = mysqli_query($con,"SELECT * FROM permision WHERE user_id=$user_id AND file_id=$file_id AND shared=2");
							if(mysqli_num_rows($resp)>0){
							
								$del=mysqli_query($con, "DELETE FROM  permision where user_id=$user_id AND file_id=$file_id AND shared=2");
								if ($del) {
									// echo "El usuario se inserto correctamente y comparte toda la carpeta";
									$sql = "insert into permision (p_id,file_id,user_id,code,shared,created_at)";
									$sql .= "value ($p_id,\"$file_id\",$user_id,'$file_code',1,$created_at)";
									$query=mysqli_query($con, $sql);
									header("location: ../filepermision.php?id=".$file_code."&success");
						
								} else {
									// echo "hubo un error al eliminar al usuario";
									header("location: ../filepermision.php?id=".$file_code."&delerror");
								}

							}else{
								$sql = "insert into permision (p_id,file_id,user_id,code,shared,created_at)";
								$sql .= "value ($p_id,\"$file_id\",$user_id,'$file_code',1,$created_at)";
								$query=mysqli_query($con, $sql);
								if ($query) {
									// echo "Agregado exitosamente!";
									header("location: ../filepermision.php?id=".$file_code."&success");
								} else {
									// echo "Hubo un error al dar los permisos!";
									header("location: ../filepermision.php?id=".$file_code."&error");
								}
							}					
						}	
					
					}
				}
				
			}else{
				// echo "No puedes agregarte ati mismo!";
				header("location: ../filepermision.php?id=".$file_code."&error2");
			}
		}else{
			// echo "El usuario no existe!";
			header("location: ../filepermision.php?id=".$file_code."&error3&not_found");
		}	
	}
?>