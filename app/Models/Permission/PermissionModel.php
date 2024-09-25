<?php

namespace Models\Permission;

require '../vendor/autoload.php';

use Models\MasterModel;


class PermissionModel extends MasterModel
{

    public function checkPermission($id_module){
        $sql = "SELECT COUNT(*) AS count 
                FROM permissions 
                WHERE rol_id = :rol_id 
                AND m_id = :m_id";
        $params = [
            'm_id'=>$id_module,
            'rol_id'=>$_SESSION['RolUser']
        ];
        $result = $this->select($sql, $params); 
        return $result  > 0;
    }
}

?>