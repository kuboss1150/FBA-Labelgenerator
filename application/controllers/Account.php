<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class account
 * @property account_model      $model The account Model
 */
class Account extends KS_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('account_model', 'model');

        $this->form_validation->set_rules('seller_id', 'Seller ID', 'required');
    }


    public function index_data($return = FALSE)
    {
        $data['accounts'] = $this->model->data();

        $this->ajax_pagination->initialize([
            'total_rows' => $this->model->count(),
            'per_page' => $this->model->page_length,
            'target' => '#table',
            'base_url' => site_url('account/index_data'),
            // 'link_func' => 'get_list',
            'show_count' => FALSE
        ]);

        return $this->load->view('account/index_data', $data, $return);
    }

    public function index()
    {
        switch ($this->input->method()) {
            case 'get':
                $return['table'] = $this->index_data(TRUE);

                $this->render('account/index', $return);
                break;
            case 'delete':
                $data['success'] = $this->model->delete($this->input->get('seller_id'));
                $this->render_json($data);
                break;
        }
    }

    public function create()
    {
        if ($this->form_validation->run() === TRUE) {
            if($this->model->create([
                'seller_id' => $this->input->post('seller_id'),
                'shiptocountry' => $this->input->post('shiptocountry'),
                'addressname' => $this->input->post('addressname'),
                'addressfieldone' => $this->input->post('addressfieldone'),
                'addressfieldtwo' => $this->input->post('addressfieldtwo'),
                'addresscity' => $this->input->post('addresscity'),
                'addresscountrycode' => $this->input->post('addresscountrycode'),
                'addressstateorregion' => $this->input->post('addressstateorregion'),
                'addresspostalcode' => $this->input->post('addresspostalcode'),
                'addressdistrict' => $this->input->post('addressdistrict'),
                'user_id'=>$this->ion_auth->get_user_id()
            ])){
                $this->set_message('Account Created');
                redirect('account/create', 'refresh');
            }
        }

        $data['error'] = validation_errors() ? validation_errors() : '';
        $this->render('account/create', $data);
    }

    public function edit($seller_id)
    {
        if ($this->form_validation->run() === TRUE) {
            if($this->model->update($seller_id,[
                'shiptocountry' => $this->input->post('shiptocountry'),
                'addressname' => $this->input->post('addressname'),
                'addressfieldone' => $this->input->post('addressfieldone'),
                'addressfieldtwo' => $this->input->post('addressfieldtwo'),
                'addresscity' => $this->input->post('addresscity'),
                'addresscountrycode' => $this->input->post('addresscountrycode'),
                'addressstateorregion' => $this->input->post('addressstateorregion'),
                'addresspostalcode' => $this->input->post('addresspostalcode'),
                'addressdistrict' => $this->input->post('addressdistrict')
            ])){
                $this->set_message('Account updated.');
                redirect('account/index', 'refresh');
            }
        }

        $data['error'] = validation_errors() ? validation_errors() : '';
        $data['account'] = $this->model->get($seller_id);
        $this->render('account/edit', $data);
    }
    
    public function set_account($seller_id){
        $this->_setting('seller_id_'.$this->ion_auth->get_user_id(), $seller_id);
        $this->seller_id = $seller_id;
        redirect($_GET['url']);
    }
}
