<?php

namespace Models\Town;

use Models\MasterModel;

Class TownModel extends MasterModel
{

    public function consultDeptos(){
        $sql = "SELECT DISTINCT NOMBRE_DEPTO 
                FROM tabla_municipios";
            $params = [];
            $deptos = $this->select($sql, $params);
        return $deptos;
    }

    public function consultTowns($DEPTO){
        $sql="SELECT DISTINCT NOMBRE_MPIO 
        FROM tabla_municipios
        WHERE NOMBRE_DEPTO=:depto";
        $params = [':depto'=>$DEPTO];
        $towns=$this->select($sql,$params);
        return $towns;
    }


    public function consultCodeTown($town){

        $sql="SELECT DISTINCT CODIGO_MUNICIPIO 
        FROM tabla_municipios
        WHERE NOMBRE_MPIO=:town";
        $params = [':town'=>$town];
        $code=$this->select($sql,$params);
        return $code;
    }


}