<?php

class OCMM000_Model extends CI_Model 
{

    private $query_insert = 'INSERT INTO tb_m_users (NAME, USERNAME, PASSWORDS, ROLE_ID, U_STATUS, CREATED_BY, CREATED_DT, UPDATED_BY, UPDATED_DT) 
                                VALUES (?, ?, ?, ?, 1, ?, current_timestamp, ?, current_timestamp);';

    private $query_update = 'UPDATE tb_m_users
                                SET
                                    NAME = ?, PASSWORDS = ?, ROLE_ID = ?, UPDATED_BY = ?, UPDATED_DT = current_timestamp
                                WHERE
                                    ID = ?;';

    private $query_delete = 'UPDATE tb_m_users
                                SET
                                    U_STATUS = 0
                                WHERE
                                    ID = ?;';

    public function get_id($id)
    {
        $this->db->select('a.id, a.name, a.username');
        $this->db->where('a.u_status', '1');
        $this->db->where('a.id', $id);
        $result = $this->db->get('tb_m_users a');
        return $result->row_array();
    }

    public function get_username($username)
    {
        $this->db->select('a.id, a.name, a.username');
        $this->db->where('a.u_status', '1');
        $this->db->where('a.username', $username);
        $result = $this->db->get('tb_m_users a');
        return $result->row_array();
    }

    public function get_password($username, $password)
    {
        $this->db->select('a.id, a.username');
        $this->db->where('a.username', $username);
        $this->db->where('a.passwords', $password);
        $this->db->from('tb_m_users a');
        return $this->db->count_all_results();
    }

    public function get_all($id)
    {
        $this->db->where_not('a.id', $id);
        $result = $this->db->get('tb_m_users a');
        return $result->result();
    }

    public function get($id)
    {
        $this->db->where('a.id', $id);
        $result = $this->db->get('tb_m_users a');
        return $result->row();
    }

    public function insert($arr_insert)
    {
        if(is_array($arr_insert))
        {

            $default_password = 'defaultpassword';

            $result = $this->db->query($this->query_insert, array(
                $arr_insert['NAME'],
                $arr_insert['USERNAME'],
                $default_password,
                $arr_insert['ROLE_ID'],
                $arr_insert['CREATED_BY'],
                $arr_insert['CREATED_BY']
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
                $value['NAME'],
                $value['PASSWORD'],
                $value['ROLE_ID'],
                $value['UPDATED_BY'],
            ));

            return $result;
        }
        else
        {
            return false;
        }
    }

    public function delete($id)
    {
        $result = $this->db->query($this->query_delete, array($id));
        return $result;
    }

}