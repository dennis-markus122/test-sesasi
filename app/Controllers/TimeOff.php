<?php

namespace App\Controllers;

use App\Models\TimeOffModel;

class TimeOff extends UserController
{
    public function showMe(){
        $model = new TimeOffModel();
        $id = $this->user["id"];

        return $this->printJson(true,"success",$model->getWhereUserId($id));
    }

    public function update()
    {
        $jsonData = $this->request->getJSON();
        $model = new TimeOffModel();


        if($jsonData){
            $id = $jsonData->id;
            $description = $jsonData->description;
            $startDate = $jsonData->start_date;
            $endDate = $jsonData->end_date;
            $idUser = $this->user["id"];

            $start = date_create($startDate);
            $end = date_create($endDate);

            $data = [
                'description'=>$description, 
                'start'=>$startDate, 
                'end'=>$endDate
            ];

            if ($start <= $end) {
                $request = $model->updateRequest($idUser, $id, $data);
                if($request){
                    return $this->printJson(true,"Berhasil memperbaharui cuti");
                }else{
                    return $this->printJson(false,"Gagal menyimpan permintaan cuti anda");
                }
            } else {
                return $this->printJson(false,"Start date harus lebih kecil dari end date");
            }
        }
    }

    public function cancel()
    {
        $jsonData = $this->request->getJSON();
        $model = new TimeOffModel();


        if($jsonData){
            $id = $jsonData->id;
            $idUser = $this->user["id"];

            $data = [ 
                'status'=>-2
            ];
            $request = $model->updateStatusWhenSubmit($idUser, $id, $data);
            if($request){
                return $this->printJson(true,"Berhasil dibatalkan cuti");
            }else{
                return $this->printJson(false,"Gagal menyimpan permintaan cuti anda");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }

    public function delete()
    {
        $jsonData = $this->request->getJSON();
        $model = new TimeOffModel();


        if($jsonData){
            $id = $jsonData->id;
            $idUser = $this->user["id"];

            $request = $model->deleteByUserIdAndId($idUser, $id);
            if($request){
                return $this->printJson(true,"Berhasil menghapus ");
            }else{
                return $this->printJson(false,"Gagal menyimpan permintaan cuti anda");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }

    }



    public function request()
    {
        $jsonData = $this->request->getJSON();
        $model = new TimeOffModel();


        if($jsonData){
            // 'id_user', 'description', 'start', 'end',
            $description = $jsonData->description;
            $startDate = $jsonData->start_date;
            $endDate = $jsonData->end_date;

            $start = date_create($startDate);
            $end = date_create($endDate);

            $data = [
                'id_user'=>$this->user["id"], 
                'description'=>$description, 
                'start'=>$startDate, 
                'end'=>$endDate
            ];

            if ($start <= $end) {
                $request = $model->request($data);
                if($request){
                    return $this->printJson(true,"Berhasil menyimpan cuti");
                }else{
                    return $this->printJson(false,"Gagal menyimpan permintaan cuti anda");
                }
            } else {
                return $this->printJson(false,"Start date harus lebih kecil dari end date");
            }
        }else{
            return $this->printJson(false,"Field tidak lengkap");
        }
    }
}
