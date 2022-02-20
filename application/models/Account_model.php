<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account_model extends CI_Model
{
    public $table = 'accounts';
    public $page_length = 10;

    public function __construct()
    {
        parent::__construct();
        $this->page_length = $this->input->post('length') ?? 10;
        if($this->page_length>100){
            $this->page_length = 100;
        }
    }

    public function _filter()
    {
        $filter = $this->input->post('filter');
        $this->db->where('user_id', $this->ion_auth->get_user_id());
        if (!empty($filter)) {
            if (!empty($filter['seller_id'])) {
                $this->db->like('seller_id', $filter['seller_id']);
            }
        }
    }

    public function _order(){
        if (!empty($this->input->post('sort_field'))) {
            $this->db->order_by($this->input->post('sort_field'), $this->input->post('sort_direction'));
        }else{
            $this->db->order_by('seller_id', 'desc');
        }
    }

    public function _limit(){
		$page = $this->input->post('page');
		$offset = !$page ? 0 : $page;
		$this->db->limit($this->page_length, $offset);
    }

    public function count()
    {
        $this->db->from($this->table);
        $this->_filter();
        return $this->db->count_all_results();
    }

    public function data()
    {
        $this->db->from($this->table);
        $this->_filter();
        $this->_order();
        $this->_limit();
        return $this->db->get()->result_array();
    }

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function delete($seller_id)
    {
        return $this->db->delete($this->table, ['seller_id'=>$seller_id]);
    }

    public function update($seller_id, $data)
    {
        return $this->db->update($this->table, $data, ['seller_id'=>$seller_id]);
    }

    public function get($seller_id)
    {
        return $this->db->get_where($this->table, ['seller_id'=>$seller_id])->row_array();
    }

    public function all(){
        return $this->db->get($this->table)->result_array();
    }
}
