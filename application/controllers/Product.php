<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Product
 * @property Product_model      $model The Product Model
 */
class Product extends KS_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model', 'model');
        $this->model->seller_id = $this->seller_id;

        $this->form_validation->set_rules('asin', 'Asin', 'required');
    }


    public function index_data($return = FALSE)
    {
        $data['products'] = $this->model->data();

        $this->ajax_pagination->initialize([
            'total_rows' => $this->model->count(),
            'per_page' => $this->model->page_length,
            'target' => '#table',
            'base_url' => site_url('product/index_data'),
            // 'link_func' => 'get_list',
            'show_count' => FALSE
        ]);

        return $this->load->view('product/index_data', $data, $return);
    }

    public function index()
    {
        switch ($this->input->method()) {
            case 'get':
                $return['table'] = $this->index_data(TRUE);
                $this->render('product/index', $return);
                break;
            case 'delete':
                $id = $this->input->get('id');
                $data['success'] = true;
                if($id=='all'){
                    $data['success'] = $this->model->clear();
                }else{
                    $data['success'] = $this->model->delete($id);
                }
                $this->render_json($data);
                break;
        }
    }

    public function create()
    {
        if ($this->form_validation->run() === TRUE) {
            if($this->model->create([
                'seller_id' => $this->seller_id,
                'jan' => $this->input->post('jan'),
                'asin' => $this->input->post('asin'),
                'sku' => $this->input->post('sku'),
                'fnsku' => $this->input->post('fnsku'),
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en')
            ])){
                $this->set_message('Product Created');
                redirect('product/create', 'refresh');
            }
        }

        $data['error'] = validation_errors() ? validation_errors() : '';
        $this->render('product/create', $data);
    }

    public function edit($id)
    {
        if ($this->form_validation->run() === TRUE) {
            if($this->model->update($id,[
                'seller_id' => $this->input->post('seller_id'),
                'jan' => $this->input->post('jan'),
                'asin' => $this->input->post('asin'),
                'sku' => $this->input->post('sku'),
                'fnsku' => $this->input->post('fnsku'),
                'name' => $this->input->post('name'),
                'name_en' => $this->input->post('name_en')
            ])){
                $this->set_message('Product updated.');
                redirect('product/index', 'refresh');
            }
        }

        $data['error'] = validation_errors() ? validation_errors() : '';
        $data['product'] = $this->model->get($id);
        $this->render('product/edit', $data);
    }

    public function import(){
        $this->load->library('upload', [
            'upload_path' => './uploads/',
            'allowed_types' => 'csv',
            'max_size' => 2048
        ]);

        if (!$this->upload->do_upload('csv'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->render_json($error);
        }
        else
        {
            $csv = League\Csv\Reader::createFromPath($this->upload->data('full_path'), 'r');
            $csv->setHeaderOffset(0);
            $encoder = (new League\Csv\CharsetConverter())->inputEncoding('SJIS');
            $records = $encoder->convert($csv);

            // $header = $csv->getHeader(); //returns the CSV header record
            // $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
            foreach($records as $record){
                if(empty($record['sku']) || empty($record['fnsku'])){
                    continue;
                }
                $this->model->create([
                    'seller_id' => $record['sellerId'],
                    'jan' => $record['jan'],
                    'asin' => $record['asin'],
                    'sku' => $record['sku'],
                    'fnsku' => $record['fnsku'],
                    'name' => $record['name'],
                    'name_en' => $record['name_en'],
                ]);
            }
            $this->render_json(['success'=>true]);
            // echo $csv->getContent(); //returns the CSV document as a string
        }
    }

    public function export(){
        $header = ['sellerId', 'asin','jan','sku','fnsku','name','name_en','created_at'];
        $rows = $this->model->all();
        $records = [];
        foreach($rows as $row){
            $records[] = [
                $row['seller_id'],$row['asin'],$row['jan'],$row['sku'],$row['fnsku'],$row['name'],$row['name_en'],''
            ];
        }
        //load the CSV document from a string
        $csv = League\Csv\Writer::createFromString('');
        //insert the header
        $csv->insertOne($header);
        //insert all the records
        $csv->insertAll($records);
        $data = $csv->getContent();

        $this->load->helper('download');
        force_download("Products-{$this->seller_id}.csv", $data);
    }
    
}
