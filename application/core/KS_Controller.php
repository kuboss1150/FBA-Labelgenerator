<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KS_Controller extends CI_Controller
{
    public $site_title = 'FBA GEN';
    public $template = 'admin';
    public $assets_url;

    protected $message;
    protected $show_profile = false;
    protected $ajax_show_profile = false;

    public $seller_id;
    public $userType;
    public $slug;
    public $roles = [];
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'language', 'text']);
        $this->load->model('settings');
        $this->load->model('account_model');
        $this->lang->load('site');

        $this->assets_url = base_url('assets/');
        
        $this->load->library('layout');
        $this->load->library('ajax_pagination');

        $this->output->enable_profiler($this->show_profile);

        $this->config->load('roles');
        $this->roles = $this->config->item('roles');

        $this->slug = $this->router->class . '/' . $this->router->method;
        $check = false;
        if (isset($this->roles[$this->slug])) {
            $groups = $this->roles[$this->slug]['groups'];
            if ($groups === '*') {
                $check = true;
            } else {
                $check = $this->ion_auth->in_group($groups);
            }
        }

        if (!$check) {
            if (!$this->ion_auth->logged_in()) {
                redirect('auth/login');
            } else {
                show_error('errors');
            }
        }
        $this->seller_id = $this->_setting('seller_id_'.$this->ion_auth->get_user_id()) ?? 'Seller no selected!';
    }

    public function render($page, $vars = array(), $template = '')
    {
        if (!empty($template))
            $this->template = $template;
        $vars['controller'] = $this;
        $vars['assets_url'] = $this->assets_url;
        $vars['list_accounts']  = $this->account_model->all();
        $data['page_content'] = $this->load->view($page, $vars, TRUE);
        $data['message'] = $this->message();
        $this->load->view("layout/{$this->template}", $data);
    }

    public function render_ajax($page, $vars = array())
    {
        $this->output->enable_profiler(false);

        $vars['assets_url'] = $this->assets_url;
        $this->load->view($page, $vars);
    }

    public function render_json($json)
    {
        if (is_resource($json)) {
            throw new Exception('Resources can not be converted to JSON data.');
        }

        if (is_array($json)) {
            if ($this->ajax_show_profile) {
                $this->load->library('profiler', array(
                    'benchmarks',
                    'get',
                    'memory_usage',
                    'post',
                    'uri_string',
                    'controller_info',
                    'queries',
                    'http_headers',
                    'session_data',
                    'config'
                ));
                if (!isset($json['fragments'])) {
                    $json['fragments'] = [];
                }
                $json['fragments']['profiler'] = $this->profiler->run();
                $json['fragments']['notices'] = $this->message();
            }
        }
        $this->output->enable_profiler(false)
            ->set_content_type('application/json')
            ->set_output(json_encode($json))
            ->_display();
        exit;
    }

    public function render_html($html)
    {
        if (!is_string($html)) {
            throw new Exception('No html passed to the render_html() method.');
        }

        $this->output->enable_profiler(false)
            ->set_content_type('text/html')
            ->set_output($html)
            ->_display();
        exit;
    }

    public function render_text($text, $typography = false)
    {
        if ($typography === true) {
            $this->load->helper('typography');
            $text = auto_typography($text);
        }
        $this->output->enable_profiler(false)
            ->set_content_type('text/plain')
            ->set_output($text)
            ->_display();
        exit;
    }

    public function render_js($js = null)
    {
        if (!is_string($js)) {
            throw new Exception('No javascript passed to the render_js() method.');
        }
        $this->output->enable_profiler(false)
            ->set_content_type('application/x-javascript')
            ->set_output($js)
            ->_display();
        exit;
    }

    public function set_title($title)
    {
        $this->layout->set_title($title);
    }

    public function append_js_load($file, $data = [], $position = 'footer')
    {
        $this->append_js($this->load->view($file, $data, true), $position);
    }

    public function append_js($content, $position = 'footer')
    {
        $this->layout->add_js_rawtext($content, $position);
    }

    public function append_css($content)
    {
        $this->layout->add_css_rawtext($content);
    }

    public function append_js_file($file = '', $path = '', $position = 'footer', $attr = '')
    {
        if (empty($file)) return;
        if (is_string($file)) {
            $this->layout->add_js_file($file, $path, $position, $attr);
        } else if (is_array($file)) {
            $this->layout->add_js_files($file, $path, $position, $attr);
        }
    }

    public function append_css_file($file = '', $path = '')
    {
        if (empty($file)) return;
        if (is_string($file)) {
            $this->layout->add_css_file($file, $path);
        } else if (is_array($file)) {
            $this->layout->add_css_files($file, $path);
        }
    }
    public function set_message($message = '', $type = 'info')
    {
        if (!empty($message)) {
            if (isset($this->session)) {
                $this->session->set_flashdata('message', $type . '::' . $message);
            }
            $this->message = array(
                'type'      => $type,
                'message'   => $message
            );
        }
    }

    public function message($message = '', $type = 'info')
    {
        $return = array(
            'message'   => $message,
            'type'      => $type
        );
        // Does session data exist?
        if (empty($message) && class_exists('CI_Session')) {
            $message = $this->session->flashdata('message');
            if (!empty($message)) {
                // Split out our message parts
                $temp_message = explode('::', $message);
                $return['type']     = $temp_message[0];
                $return['message']  = $temp_message[1];
                unset($temp_message);
            }
        }
        // If message is empty, we need to check our own storage.
        if (empty($message)) {
            if (empty($this->message['message'])) {
                return '';
            }
            $return = $this->message;
        }
        // Clear our session data so we don't get extra messages on rare occassions.
        if (class_exists('CI_Session')) {
            $this->session->set_flashdata('message', '');
        }
        return $return;
    }

    public function get_json($format = 'object', $depth = 512)
    {
        $as_array   = $format == 'array' ? true : false;
        return json_decode(file_get_contents('php://input'), $as_array, $depth);
    }

    public function _setting($key, $value = FALSE)
    {
        if ($value === FALSE) {
            return $this->settings->get($key);
        }
        return $this->settings->set($key, $value);
    }
}
