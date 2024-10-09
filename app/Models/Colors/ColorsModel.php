<?php

namespace Models\Colors;

use Models\MasterModel;


Class ColorsModel extends MasterModel
{
   public function consultColorById($id){
      $result = $this->selectById('colors', 'color_id', $id);
      return $result;
   }
   public function consultColors(){
         $sql = "SELECT * FROM colors";
      $params = [];
      $colors = $this->select($sql, $params);
      return $colors;
   }

   public function getColorByName($name) {
      $sql    = "SELECT * FROM colors WHERE color_name = :color_name";
      return $this->select($sql, [':color_name' => $name]);
   }
}

