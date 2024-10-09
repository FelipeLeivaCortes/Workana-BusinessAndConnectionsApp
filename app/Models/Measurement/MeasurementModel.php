<?php

namespace Models\Measurement;

use Models\MasterModel;

Class MeasurementModel extends MasterModel
{

    public function consultMeasurementById($id)
    {
        $result = $this->selectById('measurement_type', 'mt_id', $id);
        return $result;
    }

    public function getMeasurementByName($name)
    {
        $sql    = "SELECT * FROM measurement_type WHERE mt_name = :mt_name";
        return $this->select($sql, [':mt_name' => $name]);
    }
   
    public function consultMeasurements()
    {
        $sql = "SELECT * FROM `measurement_type`";
        $params = [];
        $measurements = $this->select($sql, $params);
        return $measurements;
    }


}

?>