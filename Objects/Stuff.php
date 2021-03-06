<?php
    class Stuff
    {
        private $idStuff;
        private $nombre;
        private $descripcion;
        private $fecha;
        private $typeStuff;
        private $idUsuario;
        private $idHistorial;
        private $idContexto;

        function rellenaStuff($nombre, $descripcion, $fecha, $typeStuff, $idUsuario, $idHistorial,$idContexto) {
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fecha = $fecha;
            $this->typeStuff = $typeStuff;
            $this->idUsuario = $idUsuario;
            $this->idHistorial = $idHistorial;
            $this->idContexto = $idContexto;
        }

        
        function asignaStuff($stuff){
            if(is_a($stuff, 'Stuff')){
            $this->idStuff = $stuff->getIdStuff();
            $this->nombre = $stuff->getNombre();
            $this->descripcion = $stuff->getDescripcion();
            $this->fecha = $stuff->getFecha();
            $this->typeStuff = $stuff->getTypeStuff();
            $this->idUsuario = $stuff->getIdUsuario();
            $this->idHistorial = $stuff->getIdHistorial();
             $this->idContexto = $stuff->getIdContexto();
            }
            
        }
        public function getIdStuff() {
            return $this->idStuff;
        }

        public function setIdStuff($idStuff) {
            $this->idStuff = $idStuff;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }

        public function getFecha() {
            return $this->fecha;
        }

        public function setFecha($fecha) {
            $this->fecha = $fecha;
        }

        public function getTypeStuff() {
            return $this->typeStuff;
        }

        public function setTypeStuff($typeStuff) {
            $this->typeStuff = $typeStuff;
        }

        public function getIdUsuario() {
            return $this->idUsuario;
        }

        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }

        public function getIdHistorial() {
            return $this->idHistorial;
        }

        public function setIdHistorial($idHistorial) {
            $this->idHistorial = $idHistorial;
        }

        public function getIdContexto() {
            return $this->idContexto;
        }

        public function setIdContexto($idContexto) {
            $this->idContexto = $idContexto;
        }




    }