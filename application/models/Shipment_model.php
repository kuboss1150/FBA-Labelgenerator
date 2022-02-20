<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipment_model extends CI_Model
{
    public $table = 'shipments';
    public $seller_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function _filter()
    {
        $this->db->order_by('shipment_date', 'desc');
        $this->db->where('seller_id', $this->seller_id);
    }

    public function count()
    {
        $this->db->from($this->table);
        $this->_filter();
        return $this->db->count_all_results();
    }

    public function create($data)
    {
        if($this->db->insert($this->table, $data)){
            return $this->db->insert_id();
        }
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

    public function findByFnsku($fnsku){
        $query = $this->db->query("select a.* from ks_shipments as a left join ks_box_items as b on a.id=b.shipment_id where b.fnsku='{$fnsku}' group by a.id");
        return $query->result_array();
    }
}
