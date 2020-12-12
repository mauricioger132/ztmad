<?php 
    $active2="active"; 
    include "head.php"; 
    include "header.php"; 
    include "aside.php"; 
?>
<?php 
    $alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
    $token = "";
    for($i=0;$i<6;$i++){
        $token .= $alphabeth[rand(0,strlen($alphabeth)-1)];
    }
    $_SESSION["tkn"]=$token;
    $folder=null;

    if(isset($_GET["folder"]) && $_GET["folder"]!=""){
     
        $getid=explode('&==!%',$_GET["folder"]);
        $folder=base64_decode($getid[0]);
    }

?>

    <div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
        <section class="content-header"><!-- Content Header (Page header) -->
            <h1>Mis Archivos </h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="myfiles.php"><i class="fa fa-archive"></i> Mis Archivos</a></li>
                <?php
                    if(@mysqli_num_rows($folder)!=0){
                        echo '<li class="active"><a href="myfiles.php?folder='.$file_folder_code.'"><i class="fa fa-folder-open"></i> '.$file_folder_filename.'</a></li>';
                    }
                ?>
            </ol>
        </section>

        <section class="content"><!-- Main content -->
            <div class="row"><!-- Small boxes (Stat box) -->
                <div class="col-md-12">
                <?php
                    $files = null;
                    if($folder==0){
                        if(isset($_GET["q"]) && $_GET["q"]!=""){
                            $q=$_GET["q"];
                            $files = mysqli_query($con,"SELECT * FROM FILE WHERE user_id=$my_user_id  AND (filename LIKE '%$q%' OR description LIKE '%$q%')  ORDER BY is_folder DESC, filename ASC");
                    }else{
                        $files = mysqli_query($con,"SELECT * FROM FILE WHERE user_id=$my_user_id  ORDER BY is_folder=0 DESC");
                    }

                    }else{
                        // search
                        if(isset($_GET["q"]) && $_GET["q"]!=""){
                            $q=$_GET["q"];
                           
                            $files=mysqli_query($con,"select * from files where folder_id=$file_id_folder and  (filename like '%$q%' or description like '%$q%') order by created_at desc");
                        }else{
                         
                            $user=$_SESSION["user_id"];
                            $file_id_folder=$folder;

                            $files=mysqli_query($con,"SELECT d.id,d.code,d.dataname,d.description,d.created_at,f.user_id FROM FILE AS f  INNER JOIN datafiles AS d ON  f.id=d.file_id WHERE f.user_id=$user AND d.file_id=$file_id_folder ORDER BY d.created_at DESC");
                            if(@mysqli_num_rows($files)===0){
                                $rows=mysqli_query($con,"SELECT *FROM permision WHERE user_id=$user AND file_id=$file_id_folder AND shared=1");
                                if(@mysqli_num_rows($rows)===0){
                                   $files=mysqli_query($con,"SELECT df.id,df.code,df.dataname,df.description,df.created_at FROM permision AS p 
                                                                INNER JOIN datafiles AS df ON p.code=df.code
                                                                WHERE p.user_id=$user AND p.file_id=$file_id_folder AND p.shared=2");
                                    
                                }else{
                                    $files=mysqli_query($con,"SELECT *FROM datafiles WHERE file_id=$file_id_folder");
        
                                }
                                $us=mysqli_query($con,"SELECT user_id FROM FILE WHERE id=$file_id_folder");
                                $us=mysqli_fetch_array($us);
                                $us=$us['user_id'];
                                //$files=mysqli_query($con,"SELECT d.id,d.code,d.dataname,d.description,d.created_at,f.user_id FROM FILE AS f  INNER JOIN datafiles AS d ON  f.id=d.file_id WHERE  d.file_id=$file_id_folder ORDER BY d.created_at DESC");
                            }
                        }
                    }
                ?>


               <?php if(isset($_GET["folder"]) && $_GET["folder"]!="" && $folder==0):?>
                    <p class="alert alert-danger">Estas intentando acceder a una carpeta que no existe!</p>
                <?php endif; ?>

               

                    <?php if(isset($_GET["q"]) && $_GET["q"]!=""):?>
                        <p class="alert alert-info">Resultado de la busqueda: <?php echo $_GET["q"];?></p>
                    <?php endif; ?>

                    <?php if(@mysqli_num_rows($files)>0):?>

                    <?php
                         // get messages
                        if (isset($_GET['delsuccess'])) {
                            echo "<p class='alert alert-success'> <i class=' fa fa-exclamation-circle'></i> <strong>¡Bien hecho! </strong>Eliminado exitosamente!</p>";
                        }elseif(isset($_GET['delerror'])) {
                             echo "<p class='alert alert-danger'> <i class=' fa fa-exclamation-circle'></i> Hubo un error al eliminar el archivo, puede que contenga archivos dentro.</p>";
                        }elseif (isset($_GET['delinvalid'])) {
                            echo "<p class='alert alert-warning'> <i class=' fa fa-exclamation-circle'></i> Permiso Denegado!.</p>";
                        }elseif(isset($_GET['delpermision'])){
                            echo "<p class='alert alert-warning'> <i class=' fa fa-exclamation-circle'></i> Hubo un error al eliminar el archivo,debes de quitar los permisos.</p>";
                        }
                    ?>

                    <div class="box">
                        <div class="box-header">
                            <?php if(@mysqli_num_rows($folder)==0):?>
                            <h3 class="box-title">Mis Archivos <i class="fa fa-file"></i></h3>
                            <?php else:?>
                            <h3 class="box-title"><?php echo $file_folder_filename;?> <i class="fa fa-folder"></i></h3>
                            <?php endif;?>
                            <div class="box-tools">
                            </div>
                        </div><!-- /.box-header -->

                        <div class="box-body no-padding">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Descripción</th>
                                        <th>Tamaño</th>
                                        <th>Subidol el:</th>
                                        <th></th>
                                    </tr>
                                </thead>    
                                <tbody>    
                                    <?php foreach($files as $file):
                                            $alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
                                            $token = "";
                                            for($i=0;$i<6;$i++){
                                                $token .= $alphabeth[rand(0,strlen($alphabeth)-1)];
                                            }
                                            $file['id'];
                                            $hash=base64_encode($file['id']);
                                            $id= $hash.'&==!%'.$token.'==' ;
                                            $code=$file['code'];
                                     ?>
                                    <tr>
                                        <td style="width: 250px">
                                        <?php $folder=isset($file['is_folder'])?$folder=$file['is_folder'] :""; ?>
                                        <?php if($folder):?>
                                            <a href="myfiles.php?folder=<?php echo $id?>">
                                            <i class="fa fa-folder"></i>
                                        <?php else:?>

                                        <a href="file.php?code=<?php echo $code?>">
                                        <?php
                                                //compruebbo que tipo de archivo tengo en el servidor 
                                                //by abisoft
                                                $name=isset($file['filename'])? $file['filename'] :$file['dataname'];
                                                //if(isset($file['user_id'])){
                                                    $user_id=isset($file['user_id'])?$file['user_id']:$us;
                                                    $url = "storage/data/".$user_id."/".$name;
                                                    
                                                //}
                                            
                                                $ftype=explode(".", $url);
                                                
                                            // if(file_exists($url)){
                                                if($name!=""){
                                                        //if(!$file['is_folder']){
                                                            //comprobar si es imagen
                                                            if($ftype[1]=="png" || $ftype[1]=="jpeg" || $ftype[1]=="gif" || $ftype[1]=="jpg" || $ftype[1]=="bmp"){
                                                                echo "<i class='fa fa-file-image-o'></i>";
                                                            }
                                                            //compruebo si es audio
                                                            elseif($ftype[1]=="mp3" || $ftype[1]=="wav" || $ftype[1]=="wma" || $ftype[1]=="ogg" || $ftype[1]=="mp4"){
                                                                echo "<i class='fa fa-file-audio-o'></i>";
                                                            }
                                                            //comrpuebo si son zip, rar u otros
                                                            elseif ($ftype[1]=="zip" || $ftype[1]=="rar" || $ftype[1]=="tgz" || $ftype[1]=="tar") {
                                                                echo "<i class='fa fa-file-archive-o'></i>";
                                                            }
                                                            //compruebo si es un archivo de codigo
                                                            elseif ($ftype[1]=="php" || $ftype[1]=="php3" || $ftype[1]=="html" || $ftype[1]=="css" || $ftype[1]=="py" || $ftype[1]=="java" || $ftype[1]=="js" || $ftype[1]=="sql") {
                                                                echo "<i class='fa fa-file-code-o'></i>";
                                                            }
                                                            //compruebo si es el archivo es de tipo pdf
                                                            elseif ($ftype[1]=="pdf") {
                                                                echo "<i class='fa fa-file-pdf-o'></i>";
                                                            }
                                                            //compruebo si es el archivo es excel
                                                            elseif ($ftype[1]=="xlsx") {
                                                                echo "<i class='fa fa-file-excel-o'></i>";
                                                            }
                                                            //compruebo si es el archivo es de powerpoint
                                                            elseif ($ftype[1]=="pptx") {
                                                                echo "<i class='fa fa-file-powerpoint-o'></i>";
                                                            }
                                                            //compruebo si es el archivo es de word
                                                            elseif ($ftype[1]=="docx") {
                                                                echo "<i class='fa fa-file-word-o'></i>";
                                                            }
                                                            //compruebo si es el archivo es de texto
                                                            elseif ($ftype[1]=="txt") {
                                                                echo "<i class='fa fa-file-text-o'></i>";
                                                            }
                                                            //compruebo si es el archivo es de video
                                                            elseif ($ftype[1]=="avi" || $ftype[1]=="avi" || $ftype[1]=="asf" || $ftype[1]=="dvd" || $ftype[1]=="m1v" || $ftype[1]=="movie" || $ftype[1]=="mpeg" || $ftype[1]=="wn" || $ftype[1]=="wmv") {
                                                                echo "<i class='fa fa-file-video-o'></i>";
                                                            }else{
                                                            echo "<i class='fa fa-file-o'></i>";
                                                        }
                                                    //}
                                                }
                                            //  }
                                        ?>            
                                        <?php endif; ?>
                                        <?php echo $name=isset($file['filename'])?$file['filename']:$file['dataname']; ?></a>
                                        </td>
                                        <td style="width: 350px"><?php echo $file['description']; ?></td>
                                        <td>
                                        <?php 
                                            $user_id=isset($file['user_id'])?$file['user_id']:$us;
                                            $url = "storage/data/".$user_id."/".$name;
                                            if(file_exists($url)){
                                                $fsize = filesize($url);
                                                if($name!=""){
                                                    //if(!$file['is_folder']){
                                                        if($fsize>1000*1000*1000){
                                                            echo ($fsize/1000*1000*1000)."Gb";
                                                        }
                                                        else if($fsize>1000*1000){
                                                            echo ($fsize/1000*1000)."Mb";
                                                        }
                                                        else if($fsize>1000){
                                                            echo ($fsize/1000)."Kb";
                                                        }
                                                        else if($fsize>0){
                                                            echo $fsize."B";
                                                        }
                                                    //}
                                                }
                                            }
                                        ?>
                                        </td>
                                        <td><?php echo $file['created_at']; ?></td>
                                        <td style="width:223px;">
                                            <a href="filepermision.php?id=<?php echo $file['code']; ?>" class="btn btn-xs btn-default"><i class="fa fa-globe"></i> Compartir</a>
                                            <a href="editfile.php?id=<?php echo $file['code'];?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Editar</a>
                                            <a href="action/delfile.php?id=<?php echo $file['code']; ?>&tkn=<?php echo $_SESSION["tkn"]?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                        </div><!-- /.box-body --><br>
                    </div><!-- /.box -->
                    <?php else:?>
                       <div class="col-md-6 col-md-offset-3">
                        <p class="alert alert-warning"> <i class="
                        fa fa-exclamation-triangle"></i> No se encontraron archivos en la carpeta actual</p>
                       </div>
                    <?php endif;?>
                </div>
            </div><!-- /.row -->
        </section>
    </div><!-- /.content -->

<?php include "footer.php"; ?>