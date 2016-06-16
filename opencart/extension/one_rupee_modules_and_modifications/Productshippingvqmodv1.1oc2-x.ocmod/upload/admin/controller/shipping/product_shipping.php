<?php
class ControllerShippingProductShipping extends Controller { 
	private $error = array(); 
	
	public function index() {  
		$this->load->language('shipping/product_shipping');

		$this->document->setTitle($this->language->get('heading_title') );
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('product_shipping', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');
									
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['entry_all_prod'] = $this->language->get('entry_all_prod');
		$data['entry_all_yes'] = $this->language->get('entry_all_yes');
		$data['entry_all_no'] = $this->language->get('entry_all_no');				
		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
				
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
  		
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
		);

   		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_shipping'),
    		);
		
   		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('shipping/product_shipping', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
   		);
		
		$data['action'] = $this->url->link('shipping/product_shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');


		if (isset($this->request->post['product_shipping_all_products'])) {
			$data['product_shipping_all_products'] = $this->request->post['product_shipping_all_products'];
		} else {
			$data['product_shipping_all_products'] = $this->config->get('product_shipping_all_products');
		}
		
		if (isset($this->request->post['product_shipping_tax_class_id'])) {
			$data['product_shipping_tax_class_id'] = $this->request->post['product_shipping_tax_class_id'];
		} else {
			$data['product_shipping_tax_class_id'] = $this->config->get('product_shipping_tax_class_id');
		}
				
		if (isset($this->request->post['product_shipping_geo_zone_id'])) {
			$data['product_shipping_geo_zone_id'] = $this->request->post['product_shipping_geo_zone_id'];
		} else {
			$data['product_shipping_geo_zone_id'] = $this->config->get('product_shipping_geo_zone_id');
		}
		
		if (isset($this->request->post['product_shipping_status'])) {
			$data['product_shipping_status'] = $this->request->post['product_shipping_status'];
		} else {
			$data['product_shipping_status'] = $this->config->get('product_shipping_status');
		}
		
		if (isset($this->request->post['product_shipping_sort_order'])) {
			$data['product_shipping_sort_order'] = $this->request->post['product_shipping_sort_order'];
		} else {
			$data['product_shipping_sort_order'] = $this->config->get('product_shipping_sort_order');
		}	
		
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('shipping/product_shipping.tpl', $data));
		
		
	}

	public function install() {
		$this->db->query("alter table ". DB_PREFIX."product add column shipping_price varchar(20) default \"0.0\" ");
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/product_shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
