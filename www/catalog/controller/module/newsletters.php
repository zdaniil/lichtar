<?php
class ControllerModuleNewsletters extends Controller {
	public function index() {
		$this->load->language('module/newsletter');
		$this->load->model('module/newsletters');
		
		
		$this->model_module_newsletters->createNewsletter();
		
		$data['newstext'] = $this->load->controller('common/newstext');
		$data['newscms'] = $this->load->controller('common/newscms');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_brands'] = $this->language->get('text_brands');
		$data['text_index'] = $this->language->get('text_index');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['text_button'] = $this->language->get('text_button');
		
		$data['brands'] = array();
		
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newsletters.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/newsletters.tpl', $data);
		} 
	}
	public function news()
	{
		$this->load->model('module/newsletters');
		
		$json = array();
		$json['message'] = $this->model_module_newsletters->subscribes($this->request->post);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	
}
