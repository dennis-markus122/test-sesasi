<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAuthModel extends Model
{
    protected $table = 'logauth'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['id_user', 'authorization', 'status']; 

    public function insertLog($idUser)
    {
        $currentTime = date('Y-m-d H:i:s');
        $authorization = md5($currentTime);
        $data['id_user'] = $idUser;
        $data['status'] = true;
        $data['authorization'] = $authorization;
        $result = $this->insert($data);
        if ($result) {
            return $authorization; 
        } else {
            return null; 
        }
    }

    public function getIdUserByAuthorization($authorization)
    {
        $row = $this->select('id_user, status')->where('authorization', $authorization)->first();
        if ($row) {
            return $row;
        } else {
            return null; 
        }
    }

    public function updateStatusByAuthorization($authorization, $status)
    {
        $this->set('status', $status)->where('authorization', $authorization)->update();
    }
}