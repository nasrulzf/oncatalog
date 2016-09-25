<?php

class OCMM003_Model extends CI_Model 
{

    private $query_insert = 'INSERT INTO tb_m_roles (NAME, DESCRIPTION, CREATED_BY, CREATED_DT, UPDATED_BY, UPDATED_DT) 
                                VALUES (?, ?, ?, current_timestamp, ?, current_timestamp);';

    private $query_update = 'UPDATE tb_m_roles
                                SET
                                    NAME = ?, DESCRIPTION = ?, UPDATED_BY = ?, UPDATED_DT = current_timestamp
                                WHERE
                                    ID = ?;';
    


    public function get_all()
    {
        $result = $this->db->get('tb_m_roles r');
        return $result->result();
    }

    public function get($id)
    {
        $this->db->where('ID', $id);
        $result = $this->db->get('tb_m_roles r');
        return $result->row();
    }

    public function insert($insert_arr)
    {
        if(is_array($insert_arr))
        {
            $result = $this->db->query($this->query_insert, array(
                    $insert_arr['NAME'],
                    $insert_arr['DESCRIPTION'],
                    $insert_arr['CREATED_BY']
                ));

            return $result;

        }
        else
        {
            return false;
        }
    }

    public function update($condition, $values)
    {
        if(is_array($values))
        {
            $result = $this->db->query($this->query_update, array(
                $values['NAME'],
                $values['DESCRIPTION'],
                $values['UPDATED_BY'],
                $condition
            ));

            return $result;
        }
        else
        {
            return false;
        }
    }

}