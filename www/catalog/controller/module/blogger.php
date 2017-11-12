<?php
class ControllerModuleBlogger extends Controller {
	public function index($setting) {
		$this->load->language('module/blogger');
		$this->load->model('megnor/blogger');
		$this->load->model('tool/image');
		
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_read_more'] = $this->language->get('text_read_more');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['entry_comment'] = $this->language->get('entry_comment');
		
		
		
		

		$data['button_all_blogs'] = $this->language->get('button_all_blogs');

		$data['all_blogs'] = $this->url->link('information/blogger/blogs');

		$data['blogs'] = array();
		
		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}
		
				
		foreach ($this->model_megnor_blogger->getBlogsByModule($setting['module_id'], $setting['limit']) as $result) {			
			
			$total_comments = $this->model_megnor_blogger->getTotalBlogComments($result['blogger_id']);
			
			$data['blogs'][] = array(
				'blogger_id'  => $result['blogger_id'],
				'image' 	  => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
				'title'       => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $setting['char_limit']) . '...',
				'date_added'  => date($this->language->get('date_format'), strtotime($result['date_added'])),				
				'total_comments' => number_format($total_comments),
				'href'        => $this->url->link('information/blogger', 'blogger_id=' . $result['blogger_id'])
			);  	
		}
		
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogger.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/blogger.tpl', $data);
		} 
	}
}