<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Static_Accessories_Widget extends CMS_Controller {
    public function slide(){
        $this->load->model('slide_model');
        $data['slide_list'] = $this->slide_model->get();
        $data['slide_height'] = cms_module_config($this->cms_module_path(), 'slideshow_height');
        $data['module_path'] = $this->cms_module_path();
        if(count($data['slide_list'])>0){
            $this->view($this->cms_module_path().'/widget_slide', $data);
        }
    }
    
    public function tab(){
        $this->load->model('tab_model');
        $data['tab_list'] = $this->tab_model->get();
        if(count($data['tab_list'])>0){
            $this->view($this->cms_module_path().'/widget_tab', $data);
        }
    }
    
    public function visitor_counter(){
        $this->load->model('visitor_counter_model');
        $data['visitor_count'] = $this->visitor_counter_model->get();
        $this->view($this->cms_module_path().'/widget_visitor_counter', $data);
    }

    public function welcome_alert(){
        
        $data['content'] = '{{ widget_name:welcome_alert_text }}';
        $this->view($this->cms_module_path().'/widget_welcome_alert', $data);
    }

    public function welcome_alert_message(){        
        $this->load->model('Welcome_Alert_Model');
        $data = array(            
            "is_read_welcome_alert" => $_SESSION['__cms_user_read_welcome_alert'],            
            "content" => '',
            "title" => 'Hi, '.$this->Welcome_Alert_Model->get_full_name($this->cms_user_id()),
            "status" => true,
        );

        $this->cms_show_json($data);        
    }

    public function welcome_alert_already_read(){        
        $_SESSION['__cms_user_read_welcome_alert'] = TRUE;
        $data = array(
            "is_read_welcome_alert" => $_SESSION['__cms_user_read_welcome_alert'],            
            "title" => 'Hi, '.$this->cms_user_name(),
            "content" => 'Selamat Pagi',
            "status" => true,            
            );
        $this->cms_show_json($data);        
    }
}