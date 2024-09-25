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


   
    public function consultMeasurements()
    {
        $sql = "SELECT * FROM `measurement_type`";
        $params = [];
        $measurements = $this->select($sql, $params);
        return $measurements;
    }


}

?>