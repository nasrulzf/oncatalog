<?php

class OCMM006_Model extends CI_Model 
{

    private $query_insert = 'INSERT INTO tb_m_categories (TITLE, DESCRIPTION, C_STATUS, CREATED_BY, CREATED_DT, UPDATED_BY, UPDATED_DT) 
            VALUES (?, ?, ?, ?, current_timestamp, ?, current_timestamp);';

    private $query_update = 'UPDATE tb_m_categories
            SET
                TITLE = ?, DESCRIPTION = ?, UPDATED_BY = ?, UPDATED_DT = current_timestamp
            WHERE
                ID = ?;';

    private $query_delete = 'UPDATE tb_m_categories
            SET
                C_STATUS = 0
            WHERE
                ID = ?;';

    public function get_all()
    {
        $result = $this->db->get('tb_m_categories c');
        return $result->result();
    }

    public function get($id)
    {
        $this->db->where('ID', $id);
        $result = $this->db->get('tb_m_categories c');
        return $result->row();
    }

    public function insert($array_data)
    {
        if(is_array($array_data))
        {
            $result = $this->db->query($this->query_insert, array(
                $array_data['TITLE'],
                $array_data['DESCRIPTION'],
                1,
                $array_data['CREATED_BY'],
                $array_data['CREATED_BY']
            ));

            return $result;
        }
        else
        {
            return false;
        }
    }

    public function update($condition, $value)
    {
        if(is_array($value))
        {
            $result = $this->db->query($this->query_update, array(
                $value['TITLE'],
                $value['DESCRIPTION'],
                $value['UPDATED_BY'],
                $condition
            ));

            return $result;
        }
        else
        {
            return false;
        }
    }

    public function delete($condition)
    {
        $result = $this->db->query($this->query_delete, array($condition));
        return $result;
    }

}