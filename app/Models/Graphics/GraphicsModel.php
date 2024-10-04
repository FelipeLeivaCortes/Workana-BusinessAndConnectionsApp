<?php

namespace Models\Graphics;

use Models\MasterModel;

Class GraphicsModel extends MasterModel
{

//    ROL 3 CLIENTE
    public function ConsultLimitCredit(int $c_id){
        $sql    = "SELECT * FROM creditlimits WHERE c_id=:c_id";
        $params = [':c_id' => $c_id];
        $result = $this->select($sql, $params);

        return sizeof($result) > 0 ? $result[0] : 0;
    }
    
    public function ConsultQuotes(int $c_id){
        $sql="SELECT quotes.*
              FROM quotes
              INNER JOIN users
              ON users.u_id=quotes.u_id
              INNER JOIN company
              ON company.c_id=users.c_id
         WHERE company.c_id=:c_id";

        $params = [':c_id' => $c_id];
        $result = $this->select($sql, $params);
        return $result;
    }

    public function ConsultOrders(int $c_id){
        $sql="SELECT `orders`.*
              FROM `orders`
              INNER JOIN users
              ON users.u_id=`orders`.u_id
              INNER JOIN company
              ON company.c_id=users.c_id
         WHERE company.c_id=:c_id";

        $params = [':c_id' => $c_id];
        $result = $this->select($sql, $params);
        return $result;
    }


    //ROL 2 COMPANY
    public function ConsultQuotesClients(){
        $sql="SELECT quotes.*
            FROM quotes
            INNER JOIN users
            ON users.u_id=quotes.u_id
            INNER JOIN company
            ON company.c_id=users.c_id";
        $params = [];
        $result = $this->select($sql, $params);
        return $result;
    }

    public function ConsultOrdersClients(){
        $sql="SELECT `orders`.*
        FROM `orders`
        INNER JOIN users
        ON users.u_id = `orders`.u_id
        INNER JOIN company
        ON company.c_id = users.c_id";
        $params = [];
        $result = $this->select($sql, $params);
        return $result;
    }
}

