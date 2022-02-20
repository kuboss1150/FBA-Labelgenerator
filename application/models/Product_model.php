<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public $table = 'products';
    public $page_length = 100;
    public $seller_id;

    public function __construct()
    {
        parent::__construct();
        $this->page_length = $this->input->post('length') ?? $this->page_length;
        if($this->page_length>100){
            $this->page_length = 100;
        }
    }

    public function _filter()
    {
        $filter = $this->input->post('filter');
        if (!empty($filter)) {
            if (!empty($filter['value'])) {
                $this->db->like($filter['field'], trim($filter['value']));
            }
        }
        $this->db->where('seller_id', $this->seller_id);
    }

    public function _order(){
        if (!empty($this->input->post('sort_field'))) {
            $this->db->order_by($this->input->post('sort_field'), $this->input->post('sort_direction'));
        }else{
            $this->db->order_by('asin', 'desc');
        }
    }

    public function _limit(){
		$page = $this->input->post('page');
        $offset = !$page ? 0 : $page;
        if($this->page_length!=-1){
            $this->db->limit($this->page_length, $offset);
        }
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
        $this->db->delete($this->table, ['fnsku'=>$data['fnsku']]);
        return $this->db->insert($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id'=>$id]);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id'=>$id]);
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, ['id'=>$id])->row_array();
    }

    public function all(){
        $this->_filter();
        return $this->db->get($this->table)->result_array();
    }

    public function clear()
    {
        return $this->db->delete($this->table, ['seller_id'=>$this->seller_id]);
    }

    public function findByJan(){
        // return $this->db->limit(10, 0)->get($this->table)->result_array();
        $request = json_decode($this->input->raw_input_stream, true);
        if($request!==false){
            $this->db->from($this->table);
            $this->_filter();
            $this->db->like('jan', $request['jan'], 'after');
            return $this->db->get()->result_array();
        }
        return false;
    }

    public function findByFnsku($fnsku){
        return $this->db->get_where($this->table, ['fnsku'=>$fnsku, 'seller_id'=>$this->seller_id])->row_array();
    }
}
