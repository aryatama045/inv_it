<?php

class Model_general extends CI_Model
{
	function __construct() {
        parent::__construct();

        $this->load->library('auth');
    }

    function getDataSetting()
    {
        $this->db->select('*');
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->result_array();
    }


    function saveEdit()
    {
        tesx($_POST);
        $data = array(
            'name' => $_POST['name'],
            'value' => $_POST['value']
        );

        $this->db->where('id', $_POST['id']);
        $this->db->update('settings', $data);

        return true;
    }
}