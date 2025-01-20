<?php
namespace Models\User;

use Models\MasterModel;
use PDO;

use function Helpers\dd;

Class UserModel extends MasterModel
{
    public function emailRolCompany(int $rol_id=2){
       $sql=" SELECT u_email
                FROM users 
                WHERE rol_id = :rol_id";
       $params=['rol_id'=>$rol_id];
       $email = $this->select($sql, $params);
       return $email;
    }
    public function consultEmailsOfTheCompany($id_company)
    {
        
        $sql = "SELECT u_email FROM users 
        WHERE c_id = :company";
        $params = [':company' => $id_company]; 
        $results = $this->select($sql, $params); 
        $emails = [];
        foreach ($results as $row) {
            $emails[] = $row['u_email'];
        }

        return $emails;
    }

    public function UpdateRepresentantCompanyRolCompanyAndProgrammer($u_id,$u_name,$u_lastname,$u_document,$u_email,$u_type_document){
        $sql = "UPDATE users SET
                    u_name = :u_name,
                    u_lastname=:u_lastname,
                    u_document = :u_document,
                    u_email = :u_email,
                    u_type_document = :u_type_document
                    WHERE u_id = :u_id";
                        
        $params = [
            ':u_id' => $u_id,
            ':u_name' => $u_name,
            ':u_lastname'=>$u_lastname,
            ':u_document' => $u_document,
            ':u_email' => $u_email,
            ':u_type_document' => $u_type_document,
        ];
        $this->update($sql, $params);
    
    }
    


    public function getUserInfoById($id) {
        $sql = "SELECT u_id,u_name, u_lastname, u_phone, u_email, u_type_document, u_document,status_id,c_id
                FROM users 
                WHERE u_id = :id";
        $params = [':id' => $id];
        $user = $this->select($sql, $params);
        return $user[0];
    }
    
    public function insertUser($email, $password, $code,$c_id,$rol_id=3,$status_id=2,$name=null, $lastname=null, $phone=null,  $document=null, $type_document=null, $country=null, $city=null) {
        $sql    = "INSERT INTO users (u_id, u_name, u_lastname, u_phone, u_email, u_document, u_type_document, u_country, u_city, u_pass, u_code, rol_id, c_id, status_id)
                VALUES (:u_id, :u_name, :u_lastname, :u_phone, :u_email, :u_document, :u_type_document, :u_country, :u_city, :u_pass, :u_code, :rol_id, :c_id, :status_id)";
        $params = [
            'u_id'              => null,
            'u_name'            => $name,
            'u_lastname'        => $lastname,
            'u_phone'           => $phone,
            'u_email'           => $email,
            'u_document'        => $document,
            'u_type_document'   => $type_document,
            'u_country'         => $country,
            'u_city'            => $city,
            'u_pass'            => $password,
            'u_code'            => $code,
            'rol_id'            => $rol_id,
            'c_id'              => $c_id,
            'status_id'         => $status_id
        ];
    
        $this->insert($sql, $params);
    }

    public function updateUser($userId,$name = null, $lastname = null, $phone = null, $document = null, $type_document = null, $country = null, $city = null) {
        $sql = "UPDATE users SET
            u_name = :u_name,
            u_lastname = :u_lastname,
            u_phone = :u_phone,
            u_document = :u_document,
            u_type_document = :u_type_document,
            u_country = :u_country,
            u_city = :u_city
            WHERE u_id = :u_id";
            
        $params = [
            ':u_id' => $userId,
            ':u_name' => $name,
            ':u_lastname' => $lastname,
            ':u_phone' => $phone,
            ':u_document' => $document,
            ':u_type_document' => $type_document,
            ':u_country' => $country,
            ':u_city' => $city
        ];
        
        $this->update($sql, $params);
    }

    public function getUsersByRoleCompanyAndStatus($rol_id, $c_id, $status_id) {
        $sql = "SELECT u_id,u_name,u_lastname,u_email,u_document,u_type_document
        FROM users
        WHERE rol_id = :rol_id 
        AND c_id = :c_id 
        AND status_id = :status_id
        ORDER BY u_id DESC";
        $params = [
            'rol_id' => $rol_id,
            'c_id' => $c_id,
            'status_id' => $status_id
        ];    
        $user=$this->select($sql, $params);        
        return $user;
    }
    
    public function getUserWithRol(int $c_id, int $rol_id){
        $sql    = "SELECT
                        *
                    FROM
                        users
                    WHERE
                        rol_id = :rol_id
                        AND c_id = :c_id";

        return $this->select($sql, ['c_id' => $c_id, 'rol_id'=>$rol_id]);
    }
        
    public function updateStatusUser(int $status,int $u_id){
        // 1: active status
        // 2: inactive status
        $sql = "UPDATE users SET status_id=:new_status WHERE u_id=:id";
        $params = [':new_status' => $status,
                 ':id' => $u_id];
        $this->update($sql, $params);
    }
    
    public function deleteUser(int $id){
        $sql = "DELETE FROM users WHERE u_id=:id";
        $params = [':id' => $id];
        $this->delete($sql, $params);
    }
    
    public function consultUsersWithRolAndStatus(int $rol_id, int $status_id){
        $sql = "SELECT u_id,u_name,u_lastname,c_id,u_email FROM users
        WHERE rol_id = :rol_id
        AND status_id = :status_id";
        $params = [
            ':rol_id'=>$rol_id,
            ':status_id'=>$status_id
        ];
        $users=$this->select($sql, $params);
        return $users;
    }

    public function consultUsersWithRol(int $rol_id){
        $sql    = "SELECT
                        u_id,
                        u_name,
                        u_lastname,
                        c_id,
                        u_email
                    FROM
                        users
                    WHERE
                        rol_id = :rol_id";

        return $this->select($sql, [':rol_id' => $rol_id]);
    }

    public function checkEmailExists($email)
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE u_email = :email";
        $params = [
            ':email' => $email
        ];
    
        $result = $this->select($sql, $params);
    
        // El correo existe si el valor de "total" es mayor a 0
        return $result && isset($result[0]['total']) && $result[0]['total'] > 0;
    }
    
    public function updateUserPassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        $sql = "UPDATE users SET u_pass = :newPassword WHERE u_id = :userId";
        $params = [
            'newPassword' => $hashedPassword,
            'userId' => $userId
        ];
    
        $this->update($sql, $params);
    }
    
    public function verifyUserPassword($userId, $password)
{
    $sql = "SELECT u_pass FROM users WHERE u_id = :userId";
    $params = [
        'userId' => $userId
    ];

    $result = $this->select($sql, $params);

    if ($result && count($result) > 0) {
       
        $hashedPassword = $result[0]['u_pass'];

        return password_verify($password, $hashedPassword);
    }

    return false;
}

    
}





?>