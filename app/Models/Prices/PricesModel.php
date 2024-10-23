<?php

namespace Models\Prices;

use Models\MasterModel;

class PricesModel extends MasterModel
{

    public function consultPriceById($id) {
        return $this->selectById('prices', 'ar_id', $id);
    }

    public function insertPrice($ar_id, $wh_id, $p_value){
        $sql    = "INSERT INTO
                        prices (ar_id, wh_id, p_value, id_sap)
                    VALUES
                        (:ar_id, :wh_id, :p_value, :id_sap)";
        $params = [
            ':ar_id'    => $ar_id,
            ':wh_id'    => $wh_id,
            ':p_value'  => $p_value,
            ':id_sap'   => null
        ];

        $this->insert($sql, $params);
    }

    public function updatePrice($ar_id, $wh_id, $p_value,$p_id) {
        $sql    = "UPDATE
                        prices
                    SET
                        p_value = :p_value,
                        wh_id   = :wh_id
                    WHERE
                        ar_id       = :ar_id
                        AND p_id    = :p_id";

        $params = [
            ':ar_id'    => $ar_id,
            ':wh_id'    => $wh_id,
            ':p_value'  => $p_value,
            ':p_id'     => $p_id
        ];

        $this->update($sql, $params);
    }
}
