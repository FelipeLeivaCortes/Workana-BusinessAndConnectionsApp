<?php

namespace Models\CreditLimit;

use Models\MasterModel;

Class CreditLimitModel extends MasterModel
{

   
    public function ConsultCreditLimitByIdCompany(int $c_id){
        $sql="SELECT creditlimits.*,company.*,users.*
              FROM creditlimits 
              INNER JOIN company
              ON creditlimits.c_id=company.c_id
              INNER JOIN users
              ON users.c_id=company.c_id
              WHERE company.c_id=:c_id
              AND users.rol_id='3'";
        $params=[':c_id'=>$c_id];
        $result=$this->select($sql,$params);
        return $result;
    }

    public function ConsultCreditLimitByIdCompanyNew(int $c_id){
        $sql    = "SELECT
                        A.*
                    FROM
                        creditlimits AS A
                        INNER JOIN company AS B ON A.c_id = B.c_id
                    WHERE
                        B.c_id = :c_id";

        return $this->select($sql, [':c_id' => $c_id]);
    }
    
   
    public function InsertCreditLimitByIdCompany(int $c_id,$credit_limit){
        $sql="INSERT INTO creditlimits (c_id,credit_limit)
        VALUES(:c_id,:credit_limit)";
        $params=[':c_id'=>$c_id,'credit_limit'=>$credit_limit];
        $this->insert($sql,$params);
    }
    
    public function updateCreditLimitByIdCompany(int $c_id, $credit_limit) {
        $sql = "UPDATE creditlimits SET credit_limit = :credit_limit WHERE c_id = :c_id";
        $params = [
            ':credit_limit' => $credit_limit,
            ':c_id' => $c_id
        ];
        $this->update($sql, $params);
    }
    

}

?>