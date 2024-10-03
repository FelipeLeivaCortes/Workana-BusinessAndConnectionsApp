<?php

namespace Models\Order;

use Models\MasterModel;

class OrderModel extends MasterModel
{


    public function consultOrders()
    {
        $sql = "SELECT `orders`.*,order_states.*
        FROM `orders`
        INNER JOIN order_states
        ON `orders`.order_state_id=order_states.order_state_id";
        $params = [];
        $Orders = $this->select($sql, $params);
        return $Orders;
    }

    public function consultOrderById($id)
    {
        $result = $this->selectById('`orders`', 'order_id', $id);
        return $result;
    }

    public function consultArticlesOfTheOrder($order_id)
    {
        $sql = "SELECT * FROM order_articles
                WHERE order_id = :id";
        $params = [':id' => $order_id];
        $articles = $this->select($sql, $params);
        return $articles;
    }

    public function consultOrdersClients()
    {
        $sql = "SELECT `orders`.*,order_states.*, company.c_id, company.c_name
        FROM `orders`
        INNER JOIN users
        ON users.u_id = `orders`.u_id
        INNER JOIN order_states
        ON `orders`.order_state_id=order_states.order_state_id
        INNER JOIN company
        ON company.c_id=users.c_id";
        $params = [];
        
        return $this->select($sql, $params);
    }

    public function insertExtraAttributeOrder($order_attrs_name, $order_attrs_desc, $order_id)
    {
        $sql = "INSERT INTO extra_attributes_order (order_attrs_name, order_attrs_desc, order_id)
                VALUES (:order_attrs_name, :order_attrs_desc, :order_id)";
        $params = [
            ':order_attrs_name' => $order_attrs_name,
            ':order_attrs_desc' => $order_attrs_desc,
            ':order_id' => $order_id,
        ];
        $this->insert($sql, $params);
    }

    public function updateStatesOrder($order_id, $order_state_id)
    {
        $sql = "UPDATE `orders` SET order_state_id = :order_state_id 
        WHERE order_id = :order_id";
        $params = [
            ':order_state_id' => $order_state_id,
            ':order_id' => $order_id,
        ];

        $this->update($sql, $params);
    }

    public function updateStateOrderDetail_seller($order_id, $order_state_id)
    {
        $sql = "UPDATE `detail_seller_order` SET state_order_id = :order_state_id 
        WHERE id_order = :order_id";
        $params = [
            ':order_state_id' => $order_state_id,
            ':order_id' => $order_id,
        ];

        $this->update($sql, $params);
    }

    public function insertOrder($name, $desc, $payment_method, $company, $shipping_address, $email, $phone, $comments, $cedula_nit, $subtotal, $iva, $total, $url, int $u_id, $order_state_id, $id_seller, $discountOrderInput,  $additionalCostsOrderInput)
    {
        // Verificar si $order_state_id es nulo, en cuyo caso asignarle el valor predeterminado de 1
        $order_state_id = $order_state_id ?? 1;

        $sql    = "INSERT INTO `orders` (
                        order_name,
                        order_desc,
                        order_payment_method,
                        order_company,
                        order_shipping_address,
                        order_email,
                        order_phone,
                        order_comments,
                        order_cedula_nit,
                        order_subtotal,
                        order_iva,
                        order_total,
                        order_url_document,
                        u_id,
                        order_state_id
                    ) VALUES (
                        :name,
                        :desc,
                        :payment_method,
                        :company,
                        :shipping_address,
                        :email,
                        :phone,
                        :comments,
                        :cedula_nit,
                        :order_subtotal,
                        :order_iva,
                        :order_total,
                        :order_url_document,
                        :u_id,
                        :order_state_id
                    )";
        $params = [
            ':name'                 => $name,
            ':desc'                 => $desc,
            ':payment_method'       => $payment_method,
            ':company'              => $company,
            ':shipping_address'     => $shipping_address,
            ':email'                => $email,
            ':phone'                => $phone,
            ':comments'             => $comments,
            ':cedula_nit'           => $cedula_nit,
            ':order_subtotal'       => $subtotal,
            ':order_iva'            => $iva,
            ':order_total'          => $total,
            ':order_url_document'   => $url,
            ':u_id'                 => $u_id,
            ':order_state_id'       => $order_state_id
        ];

        $this->insert($sql, $params);
    }

    public function insertOrderArticle($order_id, $ar_id, $quantity, $priceNormal, $discountPercentajeOrPrice, $discountPrice)
    {
        $sql = "INSERT INTO order_articles (order_id, ar_id, orderart_quantity, orderart_pricenormal, orderart_discountPercentajeOrPrice, orderart_discountPrice)
            VALUES (:order_id, :ar_id, :quantity, :priceNormal, :discountPercentajeOrPrice, :discountPrice)";
        $params = [
            ':order_id' => $order_id,
            ':ar_id' => $ar_id,
            ':quantity' => $quantity,
            ':priceNormal' => $priceNormal,
            ':discountPercentajeOrPrice' => $discountPercentajeOrPrice,
            ':discountPrice' => $discountPrice,
        ];
        $this->insert($sql, $params);
    }

    public function insertDetailSellerOrder(int $order_id, int $id_seller, int $id_user, $totalOrder, $order_state_id)
    {
        $order_state_id = $order_state_id ?? 1;
        $current_date   = date("Y-m-d H:i:s");
        
        $sql    = "INSERT INTO detail_seller_order (
                    id_order,
                    id_seller,
                    id_user,
                    total_order,
                    state_order_id,
                    date_order
                ) VALUES (
                    :id_order,
                    :id_seller,
                    :id_user,
                    :total_order,
                    :state_order_id,
                    :date_order
                )";

        $params = [
            ':id_order'         => $order_id,
            ':id_seller'        => $id_seller,
            ':id_user'          => $id_user,
            ':total_order'      => $totalOrder,
            ':state_order_id'   => $order_state_id,
            ':date_order'       => $current_date,
        ];

        $this->insert($sql, $params);
    }
}
