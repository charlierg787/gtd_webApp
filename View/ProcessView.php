<?php 
    require_once '../Control/StuffControl.php';
    require_once '../Control/UsuarioControl.php';
    require_once '../Control/ContextoControl.php';
    require_once '../Control/TagControl.php';
    
    session_start();
    $idUsuario = $_SESSION['idUsuario'];
    $usuarioControl = new UsuarioControl();
    $user = $usuarioControl->getUsuarioById($idUsuario);
    $stuffName = "Selecciona Stuff";
    $stuffDescription = "";
    
    $stuffControl = new StuffControl();
    $listStuff = $stuffControl->getAllStuffByUsuarioId($idUsuario);
    
    $contextControl = new ContextoControl();
    $contextList = $contextControl->getAllContexto();
    
    $tagControl = new TagControl();
    $tagList = NULL;
    
    $stuffAssoc = NULL;
    
    //Si hay algun stuff seleccionado
       if(isset($_GET['idSt'])){
           //Stuff asociada a Usuario
           $stuffAssoc = $stuffControl->getStuffById($_GET['idSt']);
           
           //Seleccionamos el nombre del Stuff
           $stuffName=$stuffAssoc->getNombre();
           $stuffDescription = $stuffAssoc->getDescripcion();
           $tagList = $tagControl->getTagByStuffId($_GET['idSt']);
       }
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link rel="stylesheet" href="./Style/generalStyle.css">
        <title>Process</title>
    </head>
    <body>
     
        <div id="content">
            
            <header >
                 Header
            </header>
            <h1>Process</h1>
            <div id="stuffBox">
                <div id="listaStuff">
                    <div id="listaTitulo">
                     
                    </div>
                       <ul>
                            <?php 
                            
                                    foreach ($listStuff as $st){
                                        echo '<a href="ProcessView.php?idSt='.$st->getIdStuff().'">';
                                        echo '<li id="itemStuff">'.$st->getNombre()."</li>";
                                        echo '</a>';
                                    }
                            ?>
                        </ul>
                </div>
                
                <div id="detalleStuff">
                    <div id="detalleTitulo">
                        <h3><?php echo $stuffName?></h3>
                        
                    </div>
                    <form>
                        
                        <p><?php echo $stuffAssoc==NULL? "" : $stuffAssoc->getFecha();?></p>
                        <p>Nombre: <input type="text" name="stuffName" required="required" maxlength="255" value="<?php echo $stuffName=="Selecciona Stuff"? "": $stuffName?>"></p>
                        <p>Descripcion: 
                            <textarea name="stuffDescription" rows="3" cols="25" maxlength="255" ><?php 
                                        echo $stuffDescription;
                                      ?></textarea>
                        </p>
                        <p>Contexto:
                            <select type="select" name="stuffContext">
                                <?php
                                          echo '<option value = "" ></option>';
                                          foreach ($contextList as $auxCont){

                                              echo '<option value="'.$auxCont->getIdContexto().'">';
                                              echo $auxCont->getNombreContexto().'</option>';
                                          }
                                ?>
                            </select>
                        </p>
                        <p>Tags:
                            <?php
                                echo '<input type="text" name="stuffTag" value="';
                                if($tagList){
                                    foreach($tagList as $singleTag){
                                        echo $singleTag->getNombreTag().'; ';
                                    }
                                }
                                echo '">';
                            ?>
                        </p>
                        
                        
                        
                    </form>
                </div>
            </div>
              <footer>
                Footer
             </footer>
        </div>
      
    </body>
</html>
