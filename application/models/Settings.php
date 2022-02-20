<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($key)
    {
        $row = $this->db->get_where("settings", array("setting_key" => $key))->row();
        if(empty($row)){
            return null;
        }
        return $row->setting_value;
    }

    public function set($key, $value)
    {
        return $this->db->replace('settings', [
            'setting_key' => $key,
            'setting_value' => $value
        ]);
    }
}
