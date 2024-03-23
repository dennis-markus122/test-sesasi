<?php

namespace App\Models;

use CodeIgniter\Model;

class TimeOffModel extends Model
{
    protected $table = 'timeoff';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'description', 'start', 'end', 'id_verifikator', 'reason', 'status'];

    public function getAll()
    {
        return $this->findAll();
    }

    public function getWhereUserId($userId)
    {
        $builder = $this->db->table('timeoff');
        $builder->select('id, description, start, end');
        $builder->select("CASE 
                                WHEN status IS NULL THEN 'DIKIRIM'
                                WHEN status = 1 THEN 'DITERIMA'
                                WHEN status = 0 THEN 'DITOLAK'
                                ELSE 'DIBATALKAN'
                            END AS status");
        $builder->where('id_user', $userId);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAllTimeOff()
    {
        $builder = $this->db->table('timeoff');
        $builder->select('id, description, start, end');
        $builder->select("CASE 
                                WHEN status IS NULL THEN 'DIKIRIM'
                                WHEN status = 1 THEN 'DITERIMA'
                                WHEN status = 0 THEN 'DITOLAK'
                                ELSE 'DIBATALKAN'
                            END AS status");
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getByIdUser($id)
    {
        return $this->find($id);
    }

    public function updateRequest($id_user, $id, $data)
    {
        $this->where('id_user', $id_user)->where('id', $id)->set($data)->update();
        return $this->affectedRows() > 0;
    }

    public function updateStatusWhenSubmit($id_user, $id, $data)
    {
        $this->where('id_user', $id_user)
            ->where('id', $id)
            ->where('status', null)
                ->set($data)->update();
        return $this->affectedRows() > 0;
    }

    public function updateStatusTimeOff($id, $data)
    {
        $this->where('id', $id)
                ->set($data)->update();
        return $this->affectedRows() > 0;
    }

    public function request($data)
    {
        $result = $this->insert($data);
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function deleteByUserIdAndId($userId, $id)
    {
        return $this->where('id_user', $userId)
                    ->where('id', $id)
                    ->delete();
    }

}
