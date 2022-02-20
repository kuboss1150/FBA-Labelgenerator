<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Box_model extends CI_Model
{
    public $table = 'boxs';

    public function __construct()
    {
        parent::__construct();
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

    public function getByShipment($shipment_id){
        return $this->db->get_where($this->table, ['shipment_id'=>$shipment_id])->result_array();
    }
    
    public function getWeightByShipment($shipment_id){
        return $this->db->select_sum('weight', 's')->from($this->table)->where('shipment_id', $shipment_id)->get()->row()->s;
    }
    
    public function getCountItemByShipment($shipment_id){
        return $this->db->select_sum('quantity', 's')->from('ks_box_items')->where('shipment_id', $shipment_id)->get()->row()->s;
    }

    public function saveItems($shipment_id, $box_id, $items, $deleted_items){
        foreach($deleted_items as $id){
            if($id!=0){
                $this->db->delete('box_items', "id={$id}");
            }
        }
        foreach($items as $item){
            $data = [
                'shipment_id'=>$shipment_id,
                'box_id'=>$box_id,
                'fnsku'=>$item['fnsku'],
                'sku'=>$item['sku'],
                'quantity'=>$item['quantity']
            ];
            if($item['id']==0){
                $this->db->insert('box_items', $data);
            }else{
                $this->db->update('box_items', $data, ['id'=>$item['id']]);
            }
        }
    }

    public function getItems($box_id){
        return $this->db->get_where('box_items', ['box_id'=>$box_id])->result_array();
    }

    public function tsvData($shipment_id){
        return $this->db->query("select sku, sum(quantity) as quantity from ks_box_items where shipment_id={$shipment_id} group by sku")->result_array();
    }

    public function csvData($shipment_id){
        $return = [];
        $boxs = $this->getByShipment($shipment_id);
        foreach($boxs as $box){
            $return[] = [
                'box_name'=>$box['box_name'],
                'weight'=>$box['weight'],
                'items'=>$this->getItems($box['id']),
            ];
        }
        return $return;
    }
}
