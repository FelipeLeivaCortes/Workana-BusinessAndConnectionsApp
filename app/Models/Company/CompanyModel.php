<?php

namespace Models\Company;

use Models\MasterModel;
ini_set('display_errors', 1);
error_reporting(E_ALL);


Class CompanyModel extends MasterModel
{
    public function updateCompanySubscription($companyId, $subscriptionId)
    {
        $sql    = "UPDATE company SET
                        id_subs = :subscriptionId
                    WHERE
                        c_id = :companyId";

        $this->update($sql, [':subscriptionId' => $subscriptionId, ':companyId' => $companyId]);
    }
    
    public function updateCompanyClients($companyId, $nameCompany = null, $descCompany = null, $num_nit = null, $industry = null, $status_id = 1, $rut = null, $cc_representant = null, $chamber_comerce = null, $certificate_bank = null, $form_inscription = null, $c_country = null, $c_city = null, $c_state = null)
    {
        $sql = "UPDATE company SET
            c_name = :c_name,
            c_desc = :c_desc,
            c_num_nit = :c_num_nit,
            c_route_rut = :c_route_rut,
            c_route_cc_representant = :c_route_cc_representant,
            c_chamber_commerce = :c_chamber_commerce,
            c_form_inscription = :c_form_inscription,
            c_certificate_bank = :c_certificate_bank,
            c_country = :c_country,
            c_city = :c_city,
            c_state = :c_state,
            tpi_id = :tpi_id,
            status_id = :status_id
            WHERE c_id = :id";
            
        $params = [
            ':id' => $companyId,
            ':c_name' => $nameCompany,
            ':c_desc' => $descCompany,
            ':c_num_nit' => $num_nit,
            ':c_route_rut' => $rut,
            ':c_route_cc_representant' => $cc_representant,
            ':c_chamber_commerce' => $chamber_comerce,
            ':c_form_inscription' => $form_inscription,
            ':c_certificate_bank' => $certificate_bank,
            ':c_country' => $c_country,
            ':c_city' => $c_city,
            ':c_state' => $c_state,
            ':tpi_id' => $industry,
            ':status_id' => $status_id
        ];
        
        $this->update($sql, $params);
    }

    public function UpdateInfoCompanyRolCompanyAndProgrammer(
        $c_id, $c_name, $c_desc, $c_num_nit, $c_num_ver_nit,
        $c_street, $c_apartament, $c_country, $c_city, $c_state,
        $c_postal_code, $c_shippingStreet, $c_shippingApartament,
        $c_shippingCountry, $c_shippingState, $c_shippingCity,
        $c_shippingPostalcode, $industry, $cardCode
    ){
        $sql    = "UPDATE company SET
                        c_name                  = :c_name,
                        c_desc                  = :c_desc,
                        c_num_nit               = :c_num_nit,
                        c_num_ver_nit           = :c_num_ver_nit,
                        c_street                = :c_street,
                        c_apartament            = :c_apartament,
                        c_country               = :c_country,
                        c_city                  = :c_city,
                        c_state                 = :c_state,
                        c_postal_code           = :c_postal_code,
                        c_shippingStreet        = :c_shippingStreet,
                        c_shippingApartament    = :c_shippingApartament,
                        c_shippingCountry       = :c_shippingCountry,
                        c_shippingState         = :c_shippingState,
                        c_shippingCity          = :c_shippingCity,
                        c_shippingPostalcode    = :c_shippingPostalcode,
                        tpi_id                  = :industry
                    WHERE c_id = :c_id";
                        
        $params = [
            ':c_id'                 => $c_id,
            ':c_name'               => $c_name,
            ':c_desc'               => $c_desc,
            ':c_num_nit'            => $c_num_nit,
            ':c_num_ver_nit'        => $c_num_ver_nit,
            ':c_street'             => $c_street,
            ':c_apartament'         => $c_apartament,
            ':c_country'            => $c_country,
            ':c_city'               => $c_city,
            ':c_state'              => $c_state,
            ':c_postal_code'        => $c_postal_code,
            ':c_shippingStreet'     => $c_shippingStreet,
            ':c_shippingApartament' => $c_shippingApartament,
            ':c_shippingCountry'    => $c_shippingCountry,
            ':c_shippingState'      => $c_shippingState,
            ':c_shippingCity'       => $c_shippingCity,
            ':c_shippingPostalcode' => $c_shippingPostalcode,
            ':industry'             => $industry
        ];

        $this->update($sql, $params);
    }

    public function RegisterCompaniesClients(
        $nameCompany = null, $descCompany = null, $num_nit = null, $num_ver_nit = null, $industry = null, $status_id = 1,
        $country = null, $departament = null, $city = null, $rut = null, $cc_representant = null, $chamber_comerce = null,
        $certificate_bank = null, $form_inscription = null, $s_id = null
    ) {
        $sql    = "INSERT INTO company (
                        c_name, c_desc, c_num_nit, c_num_ver_nit, c_route_rut, c_route_cc_representant,
                        c_chamber_commerce, c_form_inscription, c_certificate_bank, c_street, c_apartament,
                        c_country, c_city, c_state, c_postal_code, c_shippingStreet, c_shippingApartament,
                        c_shippingCountry, c_shippingCity, c_shippingState, c_shippingPostalcode, c_dateQuoteValidity,
                        created_at, id_subs, tpi_id, status_id, s_id
                    ) VALUES (
                        :c_name,
                        :c_desc,
                        :c_num_nit,
                        :c_num_ver_nit,
                        :c_route_rut,
                        :c_route_cc_representant,
                        :c_chamber_commerce,
                        :c_form_inscription,
                        :c_certificate_bank,
                        :c_street,
                        :c_apartament,
                        :c_country,
                        :c_city,
                        :c_state,
                        :c_postal_code,
                        :c_shippingStreet,
                        :c_shippingApartament,
                        :c_shippingCountry,
                        :c_shippingCity,
                        :c_shippingState,
                        :c_shippingPostalcode,
                        :c_dateQuoteValidity,
                        :created_at,
                        :id_subs,
                        :tpi_id,
                        :status_id,
                        :s_id
                    )";

        $params = [
            'c_name'                    => $nameCompany,
            'c_desc'                    => $descCompany,
            'c_num_nit'                 => $num_nit,
            'c_num_ver_nit'             => $num_ver_nit,
            'c_route_rut'               => $rut,
            'c_route_cc_representant'   => $cc_representant,
            'c_chamber_commerce'        => $chamber_comerce,
            'c_form_inscription'        => $form_inscription,
            'c_certificate_bank'        => $certificate_bank,
            'c_street'                  => null,
            'c_apartament'              => null,
            'c_country'                 => $country,
            'c_city'                    => $city,
            'c_state'                   => $departament,
            'c_postal_code'             => null,
            'c_shippingStreet'          => null,
            'c_shippingApartament'      => null,
            'c_shippingCountry'         => null,
            'c_shippingCity'            => null,
            'c_shippingState'           => null,
            'c_shippingPostalcode'      => null,
            'c_dateQuoteValidity'       => null,
            'created_at'                => date('Y-m-d H:i:s'),
            'id_subs'                   => null,
            'tpi_id'                    => $industry,
            'status_id'                 => $status_id,
            's_id'                      => $s_id
        ];

        $this->insert($sql, $params);
    }

    public function updateCompanyFields($companyId, $rutFile, $representativeCedulaFile, $chamberCommerceFile,$formFile,$certificateFile) {
        $sql = "UPDATE company SET c_route_rut = :rut, c_route_cc_representant = :cedula, c_chamber_commerce = :chamber, c_form_inscription=:form, c_certificate_bank=:certificate WHERE c_id = :id";
        $params = [
            'rut' => $rutFile,
            'cedula' => $representativeCedulaFile,
            'chamber' => $chamberCommerceFile,
            'form' => $formFile,
            'certificate' => $certificateFile,
            'id' => $companyId
        ];
    
        $this->update($sql, $params);
    }

    public function updateSellerCompany(int $s_id,int $c_id){
        $sql="UPDATE company SET s_id=:s_id
              WHERE c_id=:c_id";
        $params = [':s_id'=>$s_id,':c_id'=>$c_id];
        $this->update($sql,$params);
    }

    public function consultCompanies(){
        $sql="SELECT * FROM company";
        $params = [];
        $result=$this->select($sql, $params);
        return $result;
    }

    public function ConsultCompaniesSelected(int $s_id){
        $sql="SELECT * FROM company WHERE s_id=:s_id";
        $params = [':s_id'=>$s_id];
        $result=$this->select($sql, $params);
        return $result;
    }
    public function ConsultCompaniesUnselected(){
        $sql="SELECT company.*,users.*
              FROM company
              INNER JOIN users
              ON users.c_id=company.c_id
              WHERE company.s_id IS NULL
              AND users.rol_id='3'";
        $params = [];
        $result=$this->select($sql, $params);
        return $result;
    }
    //status
    //1 active
    //2 inactive
    public function consultAllClients(){
        $sql="SELECT c.c_id, c.c_name, c.c_desc, c.c_num_nit, c.c_num_ver_nit, CONCAT(c.c_street, ' - ', c.c_apartament, ' - ', c.c_country, 
                     ' - ',c.c_city, ' - ', c.c_state, ' - ', c.c_postal_code) AS adress, CONCAT(c.c_shippingStreet, ' - ', c.c_shippingApartament, ' - ', c.c_shippingCountry,
                     ' - ',c.c_shippingCity, ' - ', c.c_shippingState, '-', c.c_shippingPostalcode) AS adress_shipping, tpi.industry_name, s.s_name, st.status_name
              FROM company c
              INNER JOIN status st ON c.status_id = st.status_id
              INNER JOIN types_industry tpi ON c.tpi_id = tpi.tpi_id
              INNER JOIN sellers s ON c.s_id = s.s_id;";
        $params = [];
        $companies=$this->select($sql, $params);
        return $companies;
    }

    public function consultCompaniesStatus($status_id){
        $sql="SELECT * FROM company WHERE status_id=:status";
        $params = [':status'=>$status_id];
        $result=$this->select($sql, $params);
        return $result;
    }
    
    public function ConsultCompany($company_id){
        $sql    = "SELECT
                        company.*,
                        status.status_name
                    FROM
                        company
                        INNER JOIN status ON company.status_id = status.status_id
                    WHERE
                        c_id= :company_id";

        return $this->select($sql, [':company_id' => $company_id]);
    }

    public function updatePasswordUser($u_id,$password){
        $sql="UPDATE users SET u_pass=:pass
              WHERE u_id=:u_id";
        $params = [
            ':pass' => $password,
            ':u_id' => $u_id
        ];
        $this->update($sql, $params);
        return $password;
    }

    public function updateAddressBilling($street, $apartament, $country, $city, $state, $postal_code, $IdCompany){
        $sql = "UPDATE company SET c_street = :street, c_apartament = :apartament, c_country = :country, c_city = :city, c_state = :state, c_postal_code = :postal_code WHERE c_id = :c_id";
        $params = [
            ':street' => $street,
            ':apartament' => $apartament,
            ':country' => $country,
            ':city' => $city,
            ':state' => $state,
            ':postal_code' => $postal_code,
            ':c_id' => $IdCompany
        ];
        $this->update($sql, $params); 
    }
    
    public function updateUserInfoById($id, $name, $lastname, $phone, $email, $type_document, $document,$IdCompany) {
        $sql = "UPDATE users 
                SET u_name = :name, u_lastname = :lastname, u_phone = :phone, u_email = :email, u_type_document = :type_document, u_document = :document
                WHERE u_id = :id
                AND c_id = :c_id";
        $params = [':name' => $name,
                   ':lastname' => $lastname,
                   ':phone' => $phone,
                   ':email' => $email,
                   ':type_document' => $type_document,
                   ':document' => $document,
                   ':id' => $id,
                   ':c_id' => $IdCompany];
        $this->update($sql, $params);
    }
    

    public function updateAddressShipping($street, $apartament, $country, $city, $state, $postal_code, $IdCompany){
        $sql = "UPDATE company 
                SET c_shippingStreet = :street, c_shippingApartament = :apartament,
                c_shippingCountry = :country, c_shippingCity = :city,
                c_shippingState = :state, c_shippingPostalcode = :postal_code 
                WHERE c_id = :c_id";
        $params = [
            ':street' => $street,
            ':apartament' => $apartament,
            ':country' => $country,
            ':city' => $city,
            ':state' => $state,
            ':postal_code' => $postal_code,
            ':c_id' => $IdCompany
        ];
        $this->update($sql, $params); 
    }


    public function updateAddressShippingToAddressBilling($IdCompany) {
        $sql = "UPDATE company SET 
                    c_shippingStreet = c_street, 
                    c_shippingApartament = c_apartament, 
                    c_shippingCountry = c_country, 
                    c_shippingCity = c_city, 
                    c_shippingState = c_state, 
                    c_shippingPostalcode = c_postal_code
                WHERE c_id = :c_id";
        $params = [
            ':c_id' => $IdCompany
        ];
        $this->update($sql, $params);
    }
    

    
    public function UsersOfCompany(int $IdCompany, int $rol) {
        $sql = "SELECT users.u_id, users.u_name, users.u_lastname, users.u_phone, users.u_email, roles.rol_name, roles.rol_id, company.c_name,status.status_name
                FROM users 
                INNER JOIN status ON users.status_id=status.status_id
                INNER JOIN roles ON users.rol_id = roles.rol_id
                INNER JOIN company ON users.c_id = company.c_id";
            
        switch ($rol) {
            case '1':
                $sql .= " AND users.rol_id = '2'";
                break;
            case '2':
                $sql .= " WHERE users.rol_id = '3' OR users.rol_id = '4'";
                break;
            case '3':
                $sql .= " WHERE users.rol_id = '4' AND users.c_id = :c_id";
                break;
            default:
                // No se agrega ninguna condición adicional en el caso por defecto
                break;
        }
        $params = null; 
        if ($rol == '3') {
            $params = [':c_id' => $IdCompany];
        }
        $result = $this->select($sql, $params); 
        return $result;
    }
    
    
    public function RolAndCompany(int $c_id,int $IdRol){
        
        $sql="SELECT users.*,company.*
        FROM users
        INNER JOIN company
        ON company.c_id=users.c_id
        WHERE users.rol_id=:rol_id
        AND users.c_id=:c_id";

         $params = [':c_id' => $c_id,
                    'rol_id'=>$IdRol];
         $result = $this->select($sql, $params); 
         return $result;
    }

    public function insertUsersCompany($name, $lastname, $phone, $email,$document, $type_document, $pass, $IdCompany, $IdRol)
    {   
        // 1:PROGRAMMER
        // 2:COMPANY
        // 3:ADMIN
        // 4:USER
        $insertRol = null;  
        switch ($IdRol) {
            case '1':
                $insertRol = 2;
                break;
            case '2':
                $insertRol = 3;
                break;
            case '3':
                $insertRol = 4;
                break;
        }   
        $sql = "INSERT INTO users (u_name, u_lastname, u_phone, u_email,u_document, u_type_document, u_country, u_city, u_pass, u_code, rol_id, c_id, status_id)
                VALUES (:name, :lastname, :phone, :email,:document, :type_document, :country, :city, :pass, :code, :rol, :c_id, :status_id)";
        
        $params = [
            ':name' => $name,
            ':lastname' => $lastname,
            ':phone' => $phone,
            ':email' => $email,
            ':type_document' => $type_document,
            ':document' => $document,
            ':country' => null,
            ':city' => null,
            ':pass' => $pass,
            ':code' => null,
            ':rol' => $insertRol,
            ':c_id' => $IdCompany,
            ':status_id' => '1'
        ];  
        $this->select($sql, $params);
    }

    public function updateStatusCompany(int $status,int $c_id){
        // 1: active status
        // 2: inactive status
        $sql = "UPDATE company SET status_id=:new_status WHERE c_id=:id";
        $params = [':new_status' => $status, ':id' => $c_id];
        $this->update($sql, $params);
    }

    public function deleteCompany(int $id){
        $sql = "DELETE FROM company WHERE c_id=:id";
        $params = [':id' => $id];
        $this->delete($sql, $params);
    }
    
    public function insertExtraAttribute($c_id, $attributeName, $attributeValue)
    {       

        // Preparar la consulta SQL para insertar datos en la tabla
        $sql = "INSERT INTO extra_attributes_company (c_id, attribute_name, attribute_value)
                VALUES (:c_id, :attribute_name, :attribute_value)";

        $params =[':c_id'=>$c_id,':attribute_name'=>$attributeName,':attribute_value'=>$attributeValue];

        $this->insert($sql, $params);
       
    }

    public function getAttributesByCompanyId($c_id)
    {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM extra_attributes_company WHERE c_id = :c_id";

        $params = [':c_id' => $c_id];

        // Ejecutar la consulta SQL
        return $this->select($sql, $params);
    }

    public function getCompanySellerAsignId($c_id)
    {
        // Preparar la consulta SQL
        $sql = "SELECT c_id, c_name, status_id, s_id FROM company WHERE c_id = :c_id AND s_id IS NOT NULL";
        
        $params = [':c_id' => $c_id];

        // Ejecutar la consulta SQL
        return $this->select($sql, $params);
    }

} 


?>