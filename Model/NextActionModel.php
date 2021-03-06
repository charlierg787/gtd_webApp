<?php
    require_once 'database_config.php';
    require_once '../Objects/NextAction.php';
    require_once 'StuffModel.php';

    class NextActionModel {
        
        private $dbh;
        
          private function abrirConexion(){
           
            $userNameDB = $GLOBALS['userNameDB'];
            $hostNameDB = $GLOBALS['hostNameDB'];
            $passwordDB = $GLOBALS['passwordDB'];
//            echo $userNameDB."</br>";
//            echo $hostNameDB."</br>";
//            echo $passwordDB."</br>";
           
            global $dbh;
              try {
                $dbh = new PDO("mysql:host={$hostNameDB};dbname=pfc_gtd", $userNameDB, $passwordDB);

                 // Enseñar errores DB
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch (PDOException $e) {
                 echo "ERROR: " . $e->getMessage();
            }
         }
         
         
         private function cerrarConexion(){
             global $dbh;
             $dbh = null;
         }
         
         /**
            * @param NextAction $nextA
            */
         public function insertarNextAction($nextA){
             if(!is_a($nextA, 'NextAction')){
                 die("Objeto no es de clase NextAction");
             }
             else{
                 //Cambiar fecha de Stuff de creacion NextAction
              
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO NextAction (idStuff,idProyecto,activa) 
                   value (:idStuff,:idProyecto, :activa)"); 
               
               $data = array('idStuff' => $nextA->getIdStuff(),'idProyecto' => $nextA->getIdProyecto(),'activa' => $nextA->getActiva());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
                $this->cerrarConexion();
                
                
               //Actualizamos la base de datos del Stuff y cambiamos su TypeStuff a 'N'
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($nextA->getIdStuff());
               $stuff->setTypeStuff("N");
               $stuffModel->updateStuff($stuff);
               
              
               
               return $id;
               
             }
             
         }
        
         public function selectNextActionById($id){
             if(!is_numeric($id)){
                 die("ID NextAction no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM NextAction na WHERE na.idNextAction = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'NextAction');  

                 $nextAction = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $nextAction;
             }
             
         }
         
         
         public function selectNextActionByStuffId($idStuff){
             if(!is_numeric($idStuff)){
                 die("ID Stuff no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM NextAction na WHERE na.idStuff = {$idStuff} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'NextAction');  

                 $nextAction = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $nextAction;
             }
             
         }
         public function selectAllNextAction(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM NextAction");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'NextAction');  

//                 $stuff = $sth->fetch();
                 $res = array();
                 while($obj = $sth->fetch()) { 
                     $res[] = $obj;
//                     echo $obj->addr;  
                 }
             
               $this->cerrarConexion();
               return $res;
         }
         
          /**
            * @param NextAction $newNextA
            */
         public function updateNextAction($newNextA){
             if(!is_a($newNextA, 'NextAction')){
                 die("Objeto no es de clase Next Action");
             }
             else{
                 
                  //Actualizamos la fecha de modificacion de Stuff
               $date1 = date('y/m/d H:i:s',time());
               $newNextA->setFecha($date1);
           
               
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE NextAction SET idProyecto = :idProyecto,
                   activa = :activa WHERE idNextAction = :idNextAction"); 
               
               $data = array('idProyecto' => $newNextA->getIdProyecto(), 'activa' => $newNextA->getActiva(), 'idNextAction' => $newNextA->getIdNextAction());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
                //Actualizamos fecha de modificacion de Stuff
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($newNextA->getIdStuff());
               $stuff->setFecha($date1);
               $stuffModel->updateStuff($stuff);
               
             }
             
         }
         
         public function deleteNextActionById($idNextA){
              if(!is_numeric($idNextA)){
                 die("ID NextAction no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM NextAction WHERE idNextAction =:idNextAction" );
                $sth->bindParam(":idNextAction", $idNextA);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
          public function deleteNextActionByStuffId($idStuff){
              if(!is_numeric($idStuff)){
                 die("ID Stuff no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM NextAction WHERE idStuff =:idStuff" );
                $sth->bindParam(":idStuff", $idStuff);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
    }
?>
