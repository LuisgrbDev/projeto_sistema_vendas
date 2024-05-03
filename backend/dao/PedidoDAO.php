<?php
require_once '../config/database.php';
require_once '../entity/Pedido.php';

class PedidoDAO implements BaseDAO{
    private $db;
    
    public function __construct()
    {
        $this->Database::getInstance();
    }

    public function getById($id){

    }
    public function getAll(){

    }
    public function create($entity){

    }
    public function update($entity){

    }
    public function delete($id){

    }
    public function getBydate($startDate,$endDate){

    }
}
?>