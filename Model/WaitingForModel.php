<?php
    require_once 'database_config.php';
    require_once '../Objects/WaitingFor.php';
    require_once 'StuffModel.php';

    class WaitingForModel {
        
        private $dbh;
        
        private function abrirConexion(){
           
            $userName = $GLOBALS['userName'];
            $hostName = $GLOBALS['hostName'];
            $password = $GLOBALS['password'];
//            echo $userName."</br>";
//            echo $hostName."</br>";
//            echo $password."</br>";
           
            global $dbh;
              try {
                $dbh = new PDO("mysql:host={$hostName};dbname=pfc_gtd", $userName, $password);

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
            * @param WaitingFor $nextWF
          * 
          * @return Devueluve ID de objeto insertado
            */
         public function insertarWaitingFor($nextWF){
             if(!is_a($nextWF, 'WaitingFor')){
                 die("Objeto no es de clase WaitingFor");
             }
             else{
               
              
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO WaitingFor (contexto,tags,contactoPersona,idStuff) 
                   value (:contexto, :tags,:contactoPersona, :idStuff)"); 
               
               $data = array('contexto' => $nextWF->getContexto(), 'tags' => $nextWF->getTags()
                       ,'contactoPersona' => $nextWF->getContactoPersona(),'idStuff' => $nextWF->getIdStuff());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
                $this->cerrarConexion();
                
                
               //Actualizamos la base de datos del Stuff y cambiamos su TypeStuff a 'W'
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($nextWF->getIdStuff());
               $stuff->setTypeStuff("W");
               $stuffModel->updateStuff($stuff);
               
              
               
               return $id;
               
             }
             
         }
        
         public function selectWaitingForById($id){
             if(!is_numeric($id)){
                 die("ID WaitingFor no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM WaitingFor wf WHERE wf.idWaitingFor = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'WaitingFor');  

                 $waitingF = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $waitingF;
             }
             
         }
         
         public function selectAllWaitingFor(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM WaitingFor");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'WaitingFor');  

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
            * @param WaitingFor $newWF
            */
         public function updateWaitingFor($newWF){
             if(!is_a($newWF, 'WaitingFor')){
                 die("Objeto no es de clase Waiting For");
             }
             else{
                 
                  //Actualizamos la fecha de modificacion de Stuff
               $date1 = date('y/m/d H:i:s',time());
               $newWF->setFecha($date1);
           
               
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE WaitingFor SET contexto = :contexto,
                   tags = :tags, contactoPersona = :contactoPersona WHERE idWaitingFor = :idWaitingFor"); 
               
               $data = array('contexto' => $newWF->getContexto(), 'tags' => $newWF->getTags(),'contactoPersona' => $newWF->getContactoPersona() ,'idWaitingFor' => $newWF->getIdWaitingFor());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
                //Actualizamos fecha de modificacion de Stuff
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($newWF->getIdStuff());
               $stuff->setFecha($date1);
               $stuffModel->updateStuff($stuff);
               
             }
             
         }
         
         public function deleteWaitingForById($idWF){
              if(!is_numeric($idWF)){
                 die("ID WaitingFor no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM WaitingFor WHERE idWaitingFor =:idWaitingFor" );
                $sth->bindParam(":idWaitingFor", $idWF);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
    }
?>
