<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Store
 * @property Product_model      $product The Product Model
 * @property Shipment_model      $shipment The Shipment Model
 * @property Box_model      $box The Box Model
 * @property Account_model      $account The Account Model
 */
class Store extends KS_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model', 'product');
        $this->load->model('shipment_model', 'shipment');
        $this->load->model('box_model', 'box');
        $this->load->model('account_model', 'account');
        $this->product->seller_id = $this->seller_id;
        $this->shipment->seller_id = $this->seller_id;
    }

    public function get_product()
    {
        $this->product->page_length = -1;
        $this->render_json($this->product->findByJan());
    }

    public function index()
    {
        $this->render('store/index', []);
    }

    public function generate()
    {
        $items = json_decode($this->input->raw_input_stream, true)['items'];
        $this->render_text('hey');
    }

    public function shipments()
    {   
        switch ($this->input->method()) {
            case 'get':
                $this->render('store/shipments');
                break;
            case 'post':
                $fnsku = json_decode($this->input->raw_input_stream, true)['fnsku'];
                if (empty($fnsku)) {
                    $this->render_json($this->shipment->all());
                } else {
                    $this->render_json($this->shipment->findByFnsku($fnsku));
                }
                break;
        }
    }

    public function shipment_name_update($id){
        $shipment_name = json_decode($this->input->raw_input_stream, true)['shipment_name'];
        $this->render_json($this->shipment->update($id, [
            'shipment_name'=>$shipment_name
        ]));
    }

    public function add_shipment()
    {
        $shipment_name = json_decode($this->input->raw_input_stream, true)['name'];
        $id = $this->shipment->create([
            'shipment_name' => $shipment_name,
            'shipment_date' => date('Y-m-d'),
            'seller_id' => $this->seller_id
        ]);
        $this->render_text($id);
    }

    public function get_shipment($id)
    {
        $shipment = $this->shipment->get($id);
        $weight = $this->box->getWeightByShipment($id);
        $item_count = $this->box->getCountItemByShipment($id);
        $this->render_json([
            'shipment_name' => $shipment['shipment_name'],
            'shipment_weight' => $weight,
            'shipment_items_count' => $item_count
        ]);
    }

    public function get_sku($fnsku)
    {
        $product = $this->product->findByFnsku($fnsku);
        $this->render_text($product['sku']);
    }

    public function save_box($id)
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $box = [
            'box_name' => $data['box_name'],
            'weight' => $data['weight'],
            'shipment_id' => $data['shipment_id']
        ];
        if ($id == 0) {
            $id = $this->box->create($box);
        } else {
            $this->box->update($id, $box);
        }
        $this->box->saveItems($data['shipment_id'], $id, $data['items'], $data['deleted_items']);
        $this->render_json([
            'box_id'=>$id,
            'items'=>$this->box->getItems($id)
        ]);
    }
    
    public function get_boxs($shipment_id)
    {
        $this->render_json($this->box->getByShipment($shipment_id));
    }
    
    public function get_box_items($box_id)
    {
        $this->render_json($this->box->getItems($box_id));
    }

    public function export_tsv($shipment_id)
    {
        $shipment = $this->shipment->get($shipment_id);
        $seller_id = $shipment['seller_id'];
        $account = $this->account->get($seller_id);
        $items = $this->box->tsvData($shipment_id);

        $excel = new SimpleExcel\SimpleExcel('TSV');
        
        $excel->writer->addRow(['PlanName', $shipment['shipment_name']]);
        $excel->writer->addRow(['ShipToCountry', $account['shiptocountry']]);
        $excel->writer->addRow(['AddressName', $account['addressname']]);
        $excel->writer->addRow(['AddressFieldOne', $account['addressfieldone']]);
        $excel->writer->addRow(['AddressFieldTwo', $account['addressfieldtwo']]);
        $excel->writer->addRow(['AddressCity', $account['addresscity']]);
        $excel->writer->addRow(['AddressCountryCode', $account['addresscountrycode']]);
        $excel->writer->addRow(['AddressStateOrRegion', $account['addressstateorregion']]);
        $excel->writer->addRow(['AddressPostalCode', $account['addresspostalcode']]);
        $excel->writer->addRow(['AddressDistrict', $account['addressdistrict']]);

        $excel->writer->addRow(['', '']);
        $excel->writer->addRow(['MerchantSKU', 'Quantity']);
        foreach($items as $item){
            $excel->writer->addRow([$item['sku'], $item['quantity']]);
        }

        $tsv = $excel->writer->saveString();
        $tsv = str_replace('"', '', $tsv);
        
        $this->load->helper('download');
        force_download($shipment['shipment_name'].'.tsv', $tsv);
    }

    public function export_csv($shipment_id)
    {
        $shipment = $this->shipment->get($shipment_id);
        $boxs = $this->box->csvData($shipment_id);

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$shipment['shipment_name'].'.csv'.'";');

        $f = fopen('php://output', 'w');

        foreach($boxs as $i=>$box){
            $item_count = count($box['items']);
            $total_quantity = 0;
            foreach($box['items'] as $k=>$item){
                $total_quantity += $item['quantity'];
            }
            foreach($box['items'] as $k=>$item){
                $row = [];
                if($k == 0){
                    $row[0] = mb_convert_encoding($box['box_name'], "SJIS-win", "UTF-8"); 
                }elseif($k == 1){
                    $row[0] = $total_quantity;
                }elseif($k == 2){
                    $row[0] = $box['weight'].'kg';
                }else{
                    $row[0] = '';
                }
                $row[1] = $item['fnsku'];
                $row[2] = $item['quantity'];
                fputcsv($f, $row, ',');
            }
            if($item_count==1){
                fputcsv($f, [$total_quantity], ',');
                fputcsv($f, [$box['weight'].'kg'], ',');
            }else if($item_count==2){
                fputcsv($f, [$box['weight'].'kg'], ',');
            }
            fputcsv($f, [''], ',');
        }
        exit;
    }
}
