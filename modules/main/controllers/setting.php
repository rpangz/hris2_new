<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends CMS_Controller{

    protected $theme = 'neutral';

    private function update_static_content($widget_name, $content){
        $this->db->update(cms_table_name('main_widget'), array('static_content'=>$content), array('widget_name'=>$widget_name));
    }

    public function index(){
        $this->theme = $this->cms_get_config('site_theme');
        // save the uploaded files
        if(isset($_FILES['site_logo'])){
            $site_logo = $_FILES['site_logo'];
            if(isset($site_logo['tmp_name']) && $site_logo['tmp_name'] != ''){
                move_uploaded_file($site_logo['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logo['name']);
                $this->cms_set_config('site_logo', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logo['name']);
            }
        }

        if(isset($_FILES['site_logosis'])){
            $site_logosis = $_FILES['site_logosis'];
            if(isset($site_logosis['tmp_name']) && $site_logosis['tmp_name'] != ''){
                move_uploaded_file($site_logosis['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logosis['name']);
                $this->cms_set_config('site_logosis', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logosis['name']);
            }
        }

        if(isset($_FILES['site_logojas'])){
            $site_logojas = $_FILES['site_logojas'];
            if(isset($site_logojas['tmp_name']) && $site_logojas['tmp_name'] != ''){
                move_uploaded_file($site_logojas['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logojas['name']);
                $this->cms_set_config('site_logojas', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logojas['name']);
            }
        }


        if(isset($_FILES['site_logomediatek'])){
            $site_logomediatek = $_FILES['site_logomediatek'];
            if(isset($site_logomediatek['tmp_name']) && $site_logomediatek['tmp_name'] != ''){
                move_uploaded_file($site_logomediatek['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logomediatek['name']);
                $this->cms_set_config('site_logomediatek', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logomediatek['name']);
            }
        }


        if(isset($_FILES['site_logodatacell'])){
            $site_logodatacell = $_FILES['site_logodatacell'];
            if(isset($site_logodatacell['tmp_name']) && $site_logodatacell['tmp_name'] != ''){
                move_uploaded_file($site_logodatacell['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logodatacell['name']);
                $this->cms_set_config('site_logodatacell', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logodatacell['name']);
            }
        }

        if(isset($_FILES['site_logoprovis'])){
            $site_logoprovis = $_FILES['site_logoprovis'];
            if(isset($site_logoprovis['tmp_name']) && $site_logoprovis['tmp_name'] != ''){
                move_uploaded_file($site_logoprovis['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logoprovis['name']);
                $this->cms_set_config('site_logoprovis', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logoprovis['name']);
            }
        }

        if(isset($_FILES['site_logomediaindonusa'])){
            $site_logomediaindonusa = $_FILES['site_logomediaindonusa'];
            if(isset($site_logomediaindonusa['tmp_name']) && $site_logomediaindonusa['tmp_name'] != ''){
                move_uploaded_file($site_logomediaindonusa['tmp_name'], BASEPATH.'../assets/nocms/images/custom_logo/'.$site_logomediaindonusa['name']);
                $this->cms_set_config('site_logomediaindonusa', '{{ base_url }}assets/nocms/images/custom_logo/'.$site_logomediaindonusa['name']);
            }
        }


        if(isset($_FILES['site_favicon'])){
            $site_favicon = $_FILES['site_favicon'];
            if(isset($site_favicon['tmp_name']) && $site_favicon['tmp_name'] != ''){
                move_uploaded_file($site_favicon['tmp_name'], BASEPATH.'../assets/nocms/images/custom_favicon/'.$site_favicon['name']);
                $this->cms_set_config('site_favicon', '{{ base_url }}assets/nocms/images/custom_favicon/'.$site_favicon['name']);
            }
        }

        if(isset($_FILES['site_background'])){
            $site_background = $_FILES['site_background'];
            if(isset($site_background['tmp_name']) && $site_background['tmp_name'] != ''){
                move_uploaded_file($site_background['tmp_name'], BASEPATH.'../assets/nocms/images/custom_background/'.$site_background['name']);
                $this->cms_set_config('site_background', '{{ base_url }}assets/nocms/images/custom_background/'.$site_background['name']);
            }
        }

        if(count($_POST)>0){
            // save the section widgets
            $this->update_static_content('section_custom_script', $this->input->post('section_custom_script'));
            $this->update_static_content('section_top_fix', $this->input->post('section_top_fix'));
            $this->update_static_content('section_banner', $this->input->post('section_banner'));
            $this->update_static_content('section_left', $this->input->post('section_left'));
            $this->update_static_content('section_right', $this->input->post('section_right'));
            $this->update_static_content('section_bottom', $this->input->post('section_bottom'));
            $this->update_static_content('navigation_right_partial', $this->input->post('navigation_right_partial'));
            // save configurations
            $configuration_list = array(
                'site_name', 'site_layout', 'site_slogan', 'site_footer', 'site_language',
                'cms_signup_activation', 'cms_email_protocol',
                'cms_email_reply_address', 'cms_email_reply_name', 'cms_email_forgot_subject',
                'cms_email_forgot_message', 'cms_email_signup_subject', 'cms_email_signup_message',
                'cms_email_useragent', 'cms_email_mailpath', 'cms_email_smtp_host', 'cms_email_smtp_user',
                'cms_email_smtp_pass', 'cms_email_smtp_port', 'cms_email_smtp_timeout','cms_google_analytic_property_id',
                'cms_notice_login','cms_notice_login_color','cms_astel_id','cms_sisindokom_id','cms_jasnikom_id','cms_mediaindonusa_id',
                'cms_mediatek_id','cms_aryajaya_id','cms_mediablulok_id','cms_datacell_id','cms_provis_id','hrd_cuti_modules','hrd_profile_modules',
                'cms_notice_cuti_khusus','hrd_bpjs_modules',
            );
            // only for non-subsite
            if(CMS_SUBSITE == ''){
                $configuration_list[] = 'cms_add_subsite_on_register';
                $configuration_list[] = 'cms_subsite_use_subdomain';
                $configuration_list[] = 'cms_subsite_home_content';
            }
            foreach($configuration_list as $configuration){
                $this->cms_set_config($configuration, $this->input->post($configuration));
            }
            $this->cms_language($this->input->post('site_language'));

        }
        // widgets
        $query = $this->db->select('widget_id, widget_name, static_content')->from(cms_table_name('main_widget'))->get();
        $widget_list = $query->result_array();
        $normal_widget_list = array();
        $section_widget_list = array();
        foreach($widget_list as $widget){
            if($widget['widget_id']<7 || $widget['widget_name'] == 'navigation_right_partial'){
                $section_widget_list[$widget['widget_name']] = $widget;
            }else{
                $normal_widget_list[] = $widget;
            }
        }
        // languages
        $language_list = $this->cms_language_list();
        // config
        $query = $this->db->select('config_name, value')->from(cms_table_name('main_config'))->get();
        $config_list = array();
        foreach($query->result_array() as $row){
            $config_list[$row['config_name']] = $row['value'];
        }

        // layout
        $layout_list = array();
        $site_theme = $config_list['site_theme'];
        $this->load->helper('directory');
        $files = directory_map('themes/'.$site_theme.'/views/layouts/', 1);
        sort($files);
        foreach($files as $file){
            if(is_dir('themes/'.$site_theme.'/views/layouts/'.$file)){
                continue;
            }
            $file = str_ireplace('.php', '', $file);
            if($file == $config_list['site_layout']){
                continue;
            }
            $layout_list[] = $file;
        }


        // send to the view
        $data['normal_widget_list'] = $normal_widget_list;
        $data['section_widget_list'] = $section_widget_list;
        $data['language_list'] = $language_list;
        $data['config_list'] = $config_list;
        $data['layout_list'] = $layout_list;
        $data['current_language'] = $this->cms_get_config('site_language', True);
        $this->view('setting_index', $data, 'main_setting');
    }
}
