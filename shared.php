<?php 
    $active3="active";
    include "head.php"; 
    include "header.php"; 
    include "aside.php"; 
?>
    
    <div class="content-wrapper"><!-- Content Wrapper. Contains page content -->
        <section class="content-header"><!-- Content Header (Page header) -->
            <h1><i class="fa fa-globe"></i> Archivos Compartidos Conmigo</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Compartidos conmigo</li>
            </ol>
        </section>
        <section class="content"><!-- Main content -->
            <div class="row"><!-- Small boxes (Stat box) -->
                <div class="col-xs-12">
                <?php
                    $user=$_SESSION["user_id"];
                    $files = mysqli_query($con,"SELECT f.id,
                                                        f.filename,
                                                        f.description,
                                                        f.is_public,
                                                        f.is_folder,
                                                        f.created_at,
                                                        f.user_id AS userfile,
                                                        f.code AS codefile,
                                                        p.user_id AS usershared,
                                                        p.code AS codepermision,
                                                        p.file_id,
                                                        p.shared
                                                        FROM FILE AS f 
                                                INNER JOIN permision AS p ON f.id=p.file_id
                                                WHERE  p.user_id=$user
                                                GROUP BY file_id
                                                ORDER BY f.id DESC");
                    $count = mysqli_num_rows($files);
                ?>
                <?php if($count>0):?>
                    <div class="box">
                        <div class="box-header"></div> <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Archivo</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
                                        </tr>
                                        <?php 
                                            foreach($files as $file):
                                                
                                                $user_id=$file['userfile'];
                                                $file_filename=$file['filename'];
                                                $file_code=$file['codefile'];
                                                $file_description=$file['description'];
                                                $file_created_at=$file['created_at'];

                                                $alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
                                                $token = "";
                                                for($i=0;$i<6;$i++){
                                                    $token .= $alphabeth[rand(0,strlen($alphabeth)-1)];
                                                }
                                                
                                                $hash=base64_encode($file['id']);
                                                $id= $hash.'&==!%'.$token.'==' ;
                                        ?>
                                        <tr><td>    
                                            <?php if($file['is_folder']==1): ?>  
                                                
                                                <a href="myfiles.php?folder=<?php echo $id;?>">
                                                <i class="fa fa-folder"></i>
                                            <?php else:
                                                $url = "storage/data/".$user_id."/".$file_filename;
                                                $ftype=explode(".", $url);    
                                            ?>
                                                <a href="file.php?code=<?php echo $file_code;?>">
                                            <?php            
                                                if($file_filename!=""){
                                        
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
                                                }      
                                            ?>
                                            <?php endif;?>
                                        <?php echo $file_filename; ?></a></td>
                                        <td style="width: 600px"><?php echo $file_description; ?></td>
                                        <td><?php echo $file_created_at; ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <?php else:?>
                    <div class="col-md-6 col-md-offset-3">
                        <br><br><br><br><br>
                        <p class="alert alert-warning"> 
                        <i class="fa fa-exclamation-triangle"></i> 
                        No se encontraron archivos en la carpeta actual</p>
                    </div>
                    <?php endif;?>
                </div>
            </div><!-- /.row -->
        </section>
    </div><!-- /.content -->
<?php include "footer.php"; ?>