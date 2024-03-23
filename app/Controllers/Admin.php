<?php

namespace App\Controllers;

use App\Models\TimeOffModel;

class Admin extends UserController
{
    public function user() {
        $this->checkRole(["ADMIN"]);
        return $this->printJson(true, "success",$this->userModel->getAllUser());
    }

    public function addVerifikator(){
        $this->checkRole(["ADMIN"]);

        $userModel = $this->userModel;
        $jsonData = $this->request->getJSON();

        if($jsonData){
            $username = $jsonData->username;
            $password = $jsonData->password;
            $name = $jsonData->name;

            $data = $userModel->getUserByUsername($username);
            if($data){
                return $this->printJson(false,"Username tidak dapat di gunakan");
            }else{
                $data = $userModel->insertUser($name,$username,$password,"VERIFIKATOR");
                if($data){
                    return $this->printJson(true,"Berhasil", $data);
                }else{
                    return $this->printJson(false,"Gagal membuat user baru");
                }
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }

    public function changeRole(){
        $this->checkRole(["ADMIN"]);

        $userModel = $this->userModel;
        $jsonData = $this->request->getJSON();

        if($jsonData){
            $username = $jsonData->username;
            $data = $userModel->getUserByUsername($username);
            if($data){
                $data["role"] = "VERIFIKATOR";
                $result = $userModel->updateUser($data["id"], $data);
                if($result){
                    return $this->printJson(true,"Berhasil mengganti role user");
                }else{
                    return $this->printJson(false,"Gagal mengubah user");
                }
            }else{
                return $this->printJson(false,"Tidak dapat menemukan user");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }

    public function changePasswordUser(){
        $this->checkRole(["ADMIN"]);
        
        $userModel = $this->userModel;
        $jsonData = $this->request->getJSON();

        if($jsonData){
            $username = $jsonData->username;
            $password = $jsonData->password;
            $data = $userModel->getUserByUsername($username);
            if($data){
                $data["password"] = md5($password);
                $result = $userModel->updateUser($data["id"], $data);
                if($result){
                    return $this->printJson(true,"Berhasil mengganti password user");
                }else{
                    return $this->printJson(false,"Gagal mengubah user");
                }
            }else{
                return $this->printJson(false,"Tidak dapat menemukan user");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }
}