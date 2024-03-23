<?php

namespace App\Controllers;

use App\Models\TimeOffModel;

class Profile extends UserController
{
    public function index(){
        $jsonData = $this->request->getJSON();
        $userModel = $this->userModel;


        if($jsonData){
            $oldPwd = $jsonData->old_password;
            $newPwd = $jsonData->new_password;

            if($this->user["password"] === md5($oldPwd)){
                $this->user["password"] = md5($newPwd);
                if($userModel->updateUser($this->user["id"],$this->user)){
                    return $this->printJson(true,"Password berhasil di ganti");
                }else{
                    return $this->printJson(false,"Gagal mengganti password");
                }
            }else{
                return $this->printJson(false,"Password anda salah");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }
}