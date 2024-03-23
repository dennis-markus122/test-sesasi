<?php

namespace App\Controllers;

class AuthController extends BaseController
{

    public function signIn()
    {
        $userModel = $this->userModel;
        $jsonData = $this->request->getJSON();

        if($jsonData){
            $username = $jsonData->username;
            $password = $jsonData->password;
            $data = $userModel->getUserByUsername($username);
            if($data){
                if($data["password"] === md5($password)){
                    $auth = $this->authModel->insertLog($data["id"]);

                    $this->response->appendHeader('Authorization', 'Bearer '.$auth);
                    return $this->printJson(true,"Berhasil", $data);
                }else{
                    return $this->printJson(false,"Username atau password salah");
                }
                
            }else{
                return $this->printJson(false,"Username atau password salah");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }

    public function signUp(){
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
                $data = $userModel->insertUser($name,$username,$password,"USER");
                if($data){
                    $auth = $this->authModel->insertLog($data["id"]);
                    $this->response->appendHeader('Authorization', 'Bearer '.$auth);
                    return $this->printJson(true,"Berhasil", $data);
                }else{
                    return $this->printJson(false,"Gagal membuat user baru");
                }
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }

    public function signOut()
    {
        $authorizationHeader = $this->request->getHeaderLine('Authorization');
        
        if (!empty($authorizationHeader)) {
            if (strpos($authorizationHeader, 'Bearer ') === 0) {
                $token = substr($authorizationHeader, 7);
                $this->authModel->updateStatusByAuthorization($token,false);
                return $this->printJson(true,"Berhasil keluar",);
            }
        }
        return $this->printJson(true,"Berhasil keluar");
    }

}
