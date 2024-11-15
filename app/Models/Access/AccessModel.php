<?php
namespace Models\Access;
require '../vendor/autoload.php';
use Models\MasterModel;

class AccessModel extends MasterModel
{
    public function userExistence(string $email, string $password) {
        $sql = "SELECT u_id, u_name, u_lastname, u_pass FROM users WHERE u_email = :email";
        $params = [':email' => $email];
        $result = $this->select($sql, $params);
        
        $response = [
            'success' => false,
            'message' => ''
        ];
        
        if ($result && count($result) > 0) {
            $user = $result[0];
            $storedPassword = $user['u_pass'];
            
            if (password_verify($password, $storedPassword)) {
                $code = $this->generateCode($user['u_id'], $email);
                $response['success'] = true;
                $response['message'] = 'Autenticación exitosa';
                $response['data'] = [
                    'name' => $user['u_name'],
                    'lastname' => $user['u_lastname'],
                    'code' => $code
                ];
            } else {
                $response['message'] = 'Contraseña incorrecta';
            }
        } else {
            $response['message'] = 'Correo electrónico no encontrado';
        }
        
        return $response;
    }
    
    
        
        private function generateCode(int $id, string $email){
            $bytes = openssl_random_pseudo_bytes(8);
            $code = bin2hex($bytes);
            $sql = "UPDATE users SET u_code= :code WHERE u_id=:id AND u_email=:email";
            $params = [':code' => $code,':id'=>$id,':email'=>$email];
            $result = $this->select($sql, $params);
            return $code;
        }
        
        public function ValidationUser(string $u_email,string $u_pass, string $code) {
            $sql    = "SELECT u_pass,u_id FROM users WHERE u_email = :email AND u_code=:code";
            $result = $this->select($sql, [':email' => $u_email,':code'=>$code]);

            if ($result && count($result) > 0) {
                $passHash   = $result[0]['u_pass'];
                $u_id       = $result[0]['u_id'];
                $result     = password_verify($u_pass, $passHash);
                
                if (!$result) {
                    return false;

                } else {
                    $data   = $this->dataUser($u_email, $u_id);

                    foreach ($data as $d) {
                        $sessionData = array(
                            'nameUser'          => $d['u_name'],
                            'LastNameUser'      => $d['u_lastname'],
                            'EmailUser'         => $d['u_email'],
                            'PhoneUser'         => $d['u_phone'],
                            'UserNumDocument'   => $d['u_document'],
                            'CountryUser'       => $d['u_country'],
                            'CityUser'          => $d['u_city'],
                            'RolUser'           => $d['rol_id'],
                            'RolName'           => $d['rol_name'],
                            'idUser'            => $d['u_id'],
                            'CompanyName'       => $d['c_name'],
                            'StatusUser'        => $d['status_id'],
                            'IdCompany'         => $d['c_id'],
                            'StatusCompany'     => $d['status_company']
                        );
                    }

                    return $sessionData;
                }
            } else {
                return false;
                
            }
        }

        private function dataUser($u_email,$u_id){
        
            $sql = "SELECT users.u_id, users.u_name, users.u_lastname, users.u_email, users.u_document,
            users.u_phone, users.u_city, users.u_country, users.rol_id,
            roles.rol_name, company.c_name, company.status_id as status_company, company.c_id, status.status_id
            FROM (users 
            INNER JOIN roles 
            ON users.rol_id = roles.rol_id)
            INNER JOIN company
            ON users.c_id = company.c_id
            INNER JOIN status
            ON status.status_id = users.status_id
            WHERE users.u_email = :email 
            AND users.u_id = :id";
        $params = [':email' => $u_email, ':id' => $u_id];
        $result = $this->select($sql, $params);
        return $result;

        }
        

    
} 


?>