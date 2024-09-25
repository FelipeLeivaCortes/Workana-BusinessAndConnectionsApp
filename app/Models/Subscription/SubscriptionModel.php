<?php

namespace Models\Subscription;

use Models\MasterModel;

Class SubscriptionModel extends MasterModel
{

    public function insertSubscription($date_init, $date_end)
    {
        $sql = "INSERT INTO subscription (subs_date_init, subs_date_end) 
                VALUES (:date_init,:date_end)";
        $params = ['date_init'=>$date_init,
                  ':date_end'=> $date_end];
        $this->insert($sql, $params);
    }

    public function consultPlanSubscription(int $c_id) {
        $sql = "SELECT subscription.*, status.*
                FROM subscription
                INNER JOIN company ON subscription.id_subs = company.id_subs
                INNER JOIN status ON company.status_id = status.status_id
                WHERE company.c_id = :c_id";
        $params = ['c_id' => $c_id];
        $result = $this->select($sql, $params);
        return $result;
    }
    

    public function consultPlanSubscriptionById(int $id_subs){
        $sql = "SELECT *
                FROM subscription
                WHERE subscription.id_subs=:id_subs";
        $params = [':id_subs'=>$id_subs];
        $result=$this->select($sql, $params);
        return $result;
    }

    public function updateSubscription($subscriptionId, $date_init, $date_end)
    {
        $sql = "UPDATE subscription SET subs_date_init = :date_init, subs_date_end = :date_end WHERE id_subs = :subscriptionId";
        $params = [
            ':date_init' => $date_init,
            ':date_end' => $date_end,
            ':subscriptionId' => $subscriptionId
        ];
        $this->update($sql, $params);
    }
    

}