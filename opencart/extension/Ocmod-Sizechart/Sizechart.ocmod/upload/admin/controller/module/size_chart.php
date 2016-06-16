<?php
class ControllerModuleSizeChart extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('module/size_chart');
		$this->load->model('catalog/size_chart');
		$this->document->setTitle($this->language->get('site_title'));
		$this->load->model('setting/setting');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('size_chart', $this->request->post);
			$this->cache->delete('product');

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['action'] = $this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->post['size_chart_status'])) {
			$data['size_chart_status'] = $this->request->post['size_chart_status'];
		} else {
			$data['size_chart_status'] = $this->config->get('size_chart_status');
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);		
		$total = $this->model_catalog_size_chart->total();
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/size_chart', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total - $this->config->get('config_limit_admin'))) ? $total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total, ceil($total / $this->config->get('config_limit_admin')));
		$data['charts'] = $this->model_catalog_size_chart->showtemplatename($filter_data);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/size_chart.tpl', $data));
	}
	
	public function insert(){
		$this->load->language('module/size_chart');
		$this->load->model('catalog/size_chart');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = "Insert Template";
		$data['help_category'] = "Select Autofill Category";
		$data['entry_category'] = "Category";
		$data['entry_image'] = "Image";
		$data['thumbimage'] = 'no_image.png';	
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => 'Insert Template',
			'href' => $this->url->link('module/size_chart/insert', 'token=' . $this->session->data['token'], 'SSL')
		);
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		/* echo "<pre>";
		echo "test";
		print_r($this->request->post); die; */
	
		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);	
		if($this->request->post){
			if($this->request->post['templatename'] == ""){
				$data['error_warning'] = 'Insert Valid Data';
			}
			$array = $this->request->post;
			$template_id = $this->model_catalog_size_chart->puttemplate($array);
			if($template_id){
				$this->response->redirect($this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['action'] = $this->url->link('module/size_chart/insert', 'token=' . $this->session->data['token'], 'SSL');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/size_chart_insert.tpl', $data));
	}
	
	public function edit_size_chart(){
		$this->load->language('module/size_chart');
		$this->load->model('catalog/size_chart');
		$this->load->model('catalog/product');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['help_category'] = "Select Autofill Category";
		$data['entry_category'] = "Category";
		$data['entry_image'] = "Image";	
		if($this->request->get['size_chart_id']){ 
			$this->load->model('catalog/category');
			$this->load->model('tool/image');
			/*----------- Categories --------------*/
			$categories = $this->model_catalog_size_chart->getCategories($this->request->get['size_chart_id']);
			$data['product_categories'] = array();
			foreach ($categories as $key => $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id['category_id']);
				if ($category_info) {
					$data['product_categories'][] = array(
						'category_id' => $category_info['category_id'],
						'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
					);
				}
			}		
			$data['size_chart'] = $this->model_catalog_size_chart->edit_size_chart($this->request->get['size_chart_id']);
			
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);	
			$data['thumbimage'] = 'no_image.png';	
			$data['size_chart_images']=array();
			$size_chart_images = unserialize(stripslashes($data['size_chart']['size_chart_images']));
			$template_data = unserialize(stripslashes($data['size_chart']['size_chart_data']));
			$fields = array_shift($template_data);	
			$data['fields'] = $fields;
			$data['template_data'] = $template_data;
			$i=1;
			if(isset($size_chart_images) && $size_chart_images!='' && count($size_chart_images)){
				foreach($size_chart_images as $key =>$value){ 
				
						$data['size_chart_images'][$i]['image'] = $this->model_tool_image->resize($value['image'], 100, 100);	
						$data['size_chart_images'][$i]['width'] = $value['width'];	
						$data['size_chart_images'][$i]['height'] = $value['height'];	
						$data['size_chart_images'][$i]['imagename'] = $value['imagename'];	
						$data['size_chart_images'][$i]['imagesrc'] = $value['image'];	
						$i++;
				}
			}
			

			$data['placeholder'] = 'Upload Image';
			$products = $this->model_catalog_size_chart->product_size_chart($this->request->get['size_chart_id']);
			$data['products'] = array();
			$size_chart_product = array();
			foreach ($products as $product_id) {
				$size_chart_product[] = $product_id['product_id'];
				$product_info = $this->model_catalog_product->getProduct($product_id['product_id']);

				if ($product_info) {
					$data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
			$data['size_chart_product'] = implode(',',$size_chart_product);
		} else{
			$this->response->redirect($this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Edit Template',
			'href' => $this->url->link('module/size_chart/edit_size_chart&size_chart_id='.$this->request->get['size_chart_id'], 'token=' . $this->session->data['token'], 'SSL')
		);
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$data['header'] = $this->load->controller('common/header');
		$data['update_action'] = $this->url->link('module/size_chart/size_chart_update', 'token=' . $this->session->data['token'], 'SSL');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/size_chart_edit.tpl', $data));
	}
	
	public function size_chart_update(){
		if($this->request->post){
			$size_chart_data = $this->request->post;
			$this->load->model('catalog/size_chart');
			$this->model_catalog_size_chart->update_size_chart($size_chart_data);
		}
		$this->response->redirect($this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function delete_size_chart(){
		$this->load->model('catalog/size_chart');
		if(isset($this->request->get['size_chart_id'])){
			$this->model_catalog_size_chart->delete_size_chart($this->request->get['size_chart_id']);
		}
		if(isset($this->request->post['selected'])){
			foreach($this->request->post['selected'] as $size_chart_id){
				$this->model_catalog_size_chart->delete_size_chart($size_chart_id);
			}
		}
		$this->response->redirect($this->url->link('module/size_chart', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function install(){
		$this->load->model('catalog/size_chart');
		$this->model_catalog_size_chart->createtable();
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/size_chart')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	public function support(){
		$this->document->setTitle('Size Chart 2.0');
		$data['heading_title']='Onjection Support';
		$data['text_edit'] = 'Welcome to our ONJECTION family!';
		$data['link_back'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('common/sizechart_onj_support2.0.tpl', $data));
	}
}
?>