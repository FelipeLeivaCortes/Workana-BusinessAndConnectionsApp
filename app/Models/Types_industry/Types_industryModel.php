<?php

namespace Models\Types_industry;

use Models\MasterModel;

Class Types_industryModel extends MasterModel
{

    public function consultTypes_industry(){
        $sql = "SELECT * FROM types_industry";
            $params = [];
            $industries = $this->select($sql, $params);
        return $industries;
    }

    public function consultTypes_industryById($id){
        $result = $this->selectById('types_industry', 'tpi_id', $id);
        return $result;
    }



}