<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'username', 'password', 'role'];

    // Method untuk mencari pengguna berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)
                    // ->where("password", md5($password))
                    ->first();
    }

    public function getUserById($id)
    {
        return $this->where('id', $id)
                    ->first();
    }

    public function updateUser($id,$data) {
        $this->where('id', $id)->set($data)->update();
        return $this->affectedRows() > 0;
    }

    public function insertUser($name, $username, $password, $role)
    {
        $data = [
            'name'=>$name, 
            'username' => $username, 
            'password'=>md5($password), 
            'role'=> $role
        ];

        if($this->insert($data))
        {
            $data["id"] = $this->insertID();
            return $data;
        }else{
            return null;
        }
    }

    public function getAllUser()
    {
        return $this->findAll();
    }
}