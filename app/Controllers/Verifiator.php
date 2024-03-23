<?php

namespace App\Controllers;

use App\Models\TimeOffModel;

class Verifiator extends UserController
{
    public function index(){
        $this->checkRole(["ADMIN","VERIFIKATOR"]);

        $model = new TimeOffModel();
        return $this->printJson(true,"sukses",$model->getAllTimeOff());
    }

    public function updateTimeOff() {
        $this->checkRole(["ADMIN","VERIFIKATOR"]);

        $jsonData = $this->request->getJSON();
        $model = new TimeOffModel();

        if($jsonData){
            $id = $jsonData->id;
            $idVerifikator = $this->user["id"];
            $reason = $jsonData->reason;
            $status = $jsonData->status;

            // 'id_verifikator', 'reason', 'status'

            $data = [
                'id_verifikator'=>$idVerifikator,
                'reason'=>$reason,
                'status'=>$status
            ];

            if($model->updateStatusTimeOff($id,$data)){
                return $this->printJson(true,"sukses");
            }else{
                return $this->printJson(false,"gagal ");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }
}