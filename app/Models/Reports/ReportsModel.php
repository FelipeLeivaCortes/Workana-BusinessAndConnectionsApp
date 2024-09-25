<?php

namespace Models\Reports;

use Models\MasterModel;


Class ReportsModel extends MasterModel
{
    public function generateReportQuotesWithCompanyAndRol(int $IdCompany = null, int $rol_id = null, $date_init , $date_end)
    {
        $sql = "SELECT DISTINCT quotes.quo_id, quotes.quo_date, quotes.quo_name,quotes.quo_subtotal,quotes.quo_total,quotes.quo_iva, extra_attributes_quotes.quote_attrs_name, extra_attributes_quotes.quote_attrs_desc, company.*, users.*,    
        (SELECT SUM(quo_subtotal) FROM quotes) AS total_subtotal,
        (SELECT SUM(quo_total) FROM quotes) AS total_total,
        (SELECT SUM(quo_iva) FROM quotes) AS total_iva
        FROM quotes 
        INNER JOIN users
            ON users.u_id = quotes.u_id
        INNER JOIN company
            ON company.c_id = users.c_id
        INNER JOIN quote_articles
            ON quote_articles.quo_id = quotes.quo_id 
        LEFT JOIN extra_attributes_quotes 
            ON extra_attributes_quotes.quo_id = quotes.quo_id
            WHERE quotes.quo_date BETWEEN :date_init AND :date_end";

                    
        $params = [':date_init' => $date_init, ':date_end' => $date_end];

        if ($rol_id === 3 || $rol_id === 4) {
            $sql .= " AND company.c_id = :c_id";
            $params[':c_id'] = $IdCompany;
        }

        $report = $this->select($sql, $params);
            
        return $report;
    }

    public function generateReportOrdersWithCompanyAndRol(int $IdCompany = null, int $rol_id = null, $date_init, $date_end)
    {
        $sql = "SELECT DISTINCT `order`.order_id, `order`.order_date, `order`.order_name, `order`.order_subtotal, `order`.order_total, `order`.order_iva, extra_attributes_order.order_attrs_name, extra_attributes_order.order_attrs_desc, company.*, users.*,
            (SELECT SUM(order_subtotal) FROM `order`) AS total_subtotal,
            (SELECT SUM(order_total) FROM `order`) AS total_total,
            (SELECT SUM(order_iva) FROM `order`) AS total_iva
            FROM `order`
            INNER JOIN users
                ON users.u_id = `order`.u_id
            INNER JOIN company
                ON company.c_id = users.c_id
            INNER JOIN order_articles
                ON order_articles.order_id = `order`.order_id
            LEFT JOIN extra_attributes_order
                ON extra_attributes_order.order_id = `order`.order_id
            WHERE `order`.order_date BETWEEN :date_init AND :date_end";
    
        $params = [':date_init' => $date_init, ':date_end' => $date_end];
    
        if ($rol_id === 3 || $rol_id === 4) {
            $sql .= " AND company.c_id = :c_id";
            $params[':c_id'] = $IdCompany;
        }
    
        $report = $this->select($sql, $params);
    
        return $report;
    }
    public function generateReportStockWithCompanyAndRol($date_init,$date_end){
        $sql="SELECT articles.ar_id,articles.ar_name,
              stock.stock_id,stock.stock_Quantity,warehouse.wh_id,
              warehouse.wh_name,order_states.order_state_id
              FROM articles 
              INNER JOIN stock  
              ON stock.ar_id=articles.ar_id
              INNER JOIN warehouse
              ON stock.wh_id=warehouse.wh_id";
            $params = [':date_init' => $date_init, ':date_end' => $date_end];
            $report = $this->select($sql, $params);
    
            return $report;
    }
    
    
} 


?>