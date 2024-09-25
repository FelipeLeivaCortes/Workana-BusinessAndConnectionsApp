<?php

namespace Models\Sellers;

require '../vendor/autoload.php';

use Models\MasterModel;


class SellersModel extends MasterModel
{

    public function ConsultSellerById(int $s_id){
        $sql="SELECT * FROM sellers WHERE s_id=:s_id";
        $params=[':s_id'=>$s_id];
        $seller=$this->select($sql,$params);
        return $seller;
    }
    public function ConsultSalesBudgerSeller(int $seller_id, $date_start, $date_end) {
        $sql="SELECT sb.b_id, sb.s_id, sb.b_budget, s.s_id, s.s_name, dso.state_order_id, dso.total_order, dso.date_order
              FROM sales_budget sb
              INNER JOIN sellers s ON sb.s_id = s.s_id
              INNER JOIN detail_seller_order dso ON sb.s_id = dso.id_seller
              WHERE sb.s_id=:s_id AND dso.date_order BETWEEN :date_start AND :date_end AND dso.state_order_id = 3";
        $params= array (
            ':s_id'=>$seller_id,
            ':date_start'=>$date_start,
            ':date_end'=>$date_end

        );
        $seller=$this->select($sql,$params);
        return $seller;
    }
    public function updateStateButdgetSeller($b_id, $cumplioMeta) {
        $sql = "UPDATE sales_budget SET
                b_state = :b_state
                WHERE b_id = :b_id";
        $params =[
            ':b_id' => $b_id,
            ':b_state' => $cumplioMeta
        ];
        $this->update($sql, $params);
    }
    public function ConsultSellerByIdOfCompany(int $company_id){
        $sql="SELECT sellers.*,company.* 
        FROM sellers
        INNER JOIN company
        ON sellers.s_id=company.s_id
        WHERE company.c_id=:c_id";
        $params=[':c_id'=>$company_id];
        $seller=$this->select($sql,$params);
        return $seller;
    }
    public function ConsultSellers(){
        $sql="SELECT * FROM sellers";
        $params=[];
        $sellers=$this->select($sql,$params);
        return $sellers;
    }
    public function consultSeller(int $seller_id, $startDate,  $endDate){
        $sql="SELECT * FROM sales_budget WHERE s_id = :s_id AND b_date_start <= :endDate AND b_date_end >= :startDate";
        $params = array(
            ':s_id'=> $seller_id,
            ':startDate'=> $startDate,
            ':endDate'=> $endDate
        );
        $sellers=$this->select($sql,$params);
        return $sellers;
    }

    public function insertSeller($s_name, $s_email, $s_phone, $s_code) {
        $sql = "INSERT INTO sellers (s_name, s_email, s_phone, s_code)
                VALUES (:s_name, :s_email, :s_phone, :s_code)";
        $params = array(
            ':s_name' => $s_name,
            ':s_email' => $s_email,
            ':s_phone' => $s_phone,
            ':s_code' => $s_code
        );
        $this->insert($sql, $params);
    }
    public function insertBudgetSeller($id_seller, $budgetGoal, $startDate, $endDate) {
        $sql = "INSERT INTO sales_budget (s_id, b_budget, b_date_start, b_date_end, b_state)
                VALUES (:s_id, :b_budget, :b_date_start, :b_date_end, :b_state)";
        $params = array(
            ':s_id' => $id_seller,
            ':b_budget' => $budgetGoal,
            ':b_date_start' => $startDate,
            ':b_date_end' => $endDate,
            ':b_state' => 'no cumplio'
        );
        $this->insert($sql, $params);
    }
    public function updateSeller($s_id, $s_name, $s_email, $s_phone, $s_code) {
        $sql = "UPDATE sellers SET
                s_name = :s_name,
                s_email = :s_email,
                s_phone = :s_phone,
                s_code = :s_code
                WHERE s_id = :s_id";
        $params =[
            ':s_id' => $s_id,
            ':s_name' => $s_name,
            ':s_email' => $s_email,
            ':s_phone' => $s_phone,
            ':s_code' => $s_code
        ];
        $this->update($sql, $params);
    }
    
    public function consultCompaniesOfSellerById(int $s_id){
        $sql="SELECT company.*,sellers.*,users.*
              FROM sellers
              INNER JOIN company
              ON company.s_id=sellers.s_id
              INNER JOIN users
              ON company.c_id=users.c_id
              WHERE company.s_id=:s_id
              AND users.rol_id='3'";
        $params=[':s_id'=>$s_id];
        $companies=$this->select($sql,$params);
        return $companies;
    }

    public function DeleteSellerOfCompany($s_id,$c_id){
        $sql = "UPDATE company SET s_id = NULL WHERE c_id = :c_id";
        $params = [
            ':c_id' => $c_id
        ];
        $this->update($sql, $params);
    }

}

?>