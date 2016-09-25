<?php

class OCMM001_Model extends CI_Model
{

    private $getAll_query = 'SELECT A.SYS_CATEGORY
        , A.SYS_SUB_CATEGORY
        , A.SYS_CODE
        , A.SYS_VALUE
        , A.CREATED_BY
        , A.CREATED_DT
        , A.UPDATED_BY
        , A.UPDATED_DT
        FROM tb_m_system A;';

    private $getOne_query = 'SELECT A.SYS_CAT;EGORY
        , A.SYS_SUB_CATEGORY
        , A.SYS_CODE
        , A.SYS_VALUE
        , A.CREATED_BY
        , A.CREATED_DT
        , A.UPDATED_BY
        , A.UPDATED_DT
        FROM tb_m_system A
        WHERE A.SYS_CATEGORY = ?
        AND A.SYS_SUB_CATEGORY = ?
        AND A.SYS_CODE = ?;';
    
    private $insert_query = 'INSERT INTO tb_m_system (SYS_CATEGORY
        , SYS_SUB_CATEGORY
        , SYS_CODE
        , SYS_VALUE
        , CREATED_BY
        , CREATED_DT
        , UPDATED_BY
        , UPDATED_DT)
        VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, CURRENT_TIMESTAMP);';

    private $update_query = 'UPDATE tb_m_system
        SET
            SYS_VALUE = ?
            , UPDATED_BY = ?
            , UPDATED_DT = CURRENT_TIMESTAMP
        WHERE
            SYS_CATEGORY = ?
            AND SYS_SUB_CATEGORY = ?
            AND SYS_CODE = ?;';

    private $delete_query = 'DELETE
        FROM
            tb_m_system
        WHERE
            SYS_CATEGORY = ?
            AND SYS_SUB_CATEGORY = ?
            AND SYS_CODE = ?;';

    public function get_all()
    {
        $result = $this->db->query($this->getAll_query);
        return $result->result_array();
    }

    public function get($sys_cat = '', $sys_sub_cat = '', $sys_code = '')
    {
        $result = $this->db->query($this->getOne_query, array($sys_cat, $sys_sub_cat, $sys_code));
        return $result->row_array();
    }

    public function insert($column)
    {
        if(is_array($column))
        {
            $result = $this->db->query($this->insert_query, array($column['SYS_CATEGORY']
            , $column['SYS_SUB_CATEGORY'], $column['SYS_CODE'], $column['SYS_VALUE']
            , $column['CREATED_BY'], $column['CREATED_BY']));
            
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function update($condition, $value)
    {
        if(is_array($condition))
        {
            $result = $this->db->query($this->update_query, array($value, $condition['UPDATED_BY'], $condition['SYS_CATEGORY'], $condition['SYS_SUB_CATEGORY'], $condition['SYS_CODE']));
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function delete($condition)
    {
        if(is_array($condition))
        {
            $result = $this->db->query($this->delete_query, $array($condition['SYS_CATEGORY'], $condition['SYS_SUB_CATEGORY'], $condition['SYS_CODE']));
            return $result;
        }
        else
        {
            return false;
        }
    }

}