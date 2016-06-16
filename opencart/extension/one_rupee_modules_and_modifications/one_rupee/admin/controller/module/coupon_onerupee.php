<?php

/*------------------------------------------------------------------------
# Coupon One Ruppee
# ------------------------------------------------------------------------
# Jitendra
# Website: http://facebook.com/jitengaur
# Support: jitengaur@gmail.com
-------------------------------------------------------------------------*/

class ControllerModuleCouponOnerupee extends Controller
{
    private $type = "module";
	private $extension = "coupon_onerupee";
	private $error = array();
	private $options = array(
		'tax_class' => 'select',
		'geo_zone' => 'select',
		'status' => 'select',
		'sort_order' => 'input');

	public function index()
	{

		$params['extension'] = $this->extension;
		$params['type'] = $this->type;

        $this->language->load($this->type.'/'.$this->extension);

		$params['heading_title'] = $this->language->get('heading_title');

		$this->load->model('marketing/coupon');
		$coupons = $this->model_marketing_coupon->getCoupons();
		$coupons_data = array();
		$coupons_data[] = array("", "Select Coupon");
		foreach($coupons as $coupon)
		{
			$coupons_data[] = array($coupon['code'], $coupon['code']);
		}
		$params['coupon_code'] = $coupons_data;
		$this->document->setTitle($params['heading_title']);

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->extension, $this->request->post);
			$this->session->data['success'] = sprintf($this->language->get('message_success'), $params['heading_title']);

			if ($this->request->post['apply']) {
				if (version_compare(VERSION, '2.0', '<')) {
					$this->redirect($this->url->link($this->type.'/'.$this->extension, 'token='.$this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link($this->type.'/'.$this->extension, 'token='.$this->session->data['token'], 'SSL'));
				}
			} else {
				if (version_compare(VERSION, '2.0', '<')) {
					$this->redirect($this->url->link('extension/'.$this->type, 'token='.$this->session->data['token'], 'SSL'));
				} else {
					$this->response->redirect($this->url->link('extension/'.$this->type, 'token='.$this->session->data['token'], 'SSL'));
				}
			}
		}

		if (isset($this->session->data['success'])) $params['success'] = $this->session->data['success'];
		else $params['success'] = "";

		$this->session->data['success'] = "";
		

		if (version_compare(VERSION, '2.0', '>=')) $params['text_edit'] = sprintf($this->language->get('text_edit_title'), $this->language->get('heading_title'));

		$params['text_enabled'] = $this->language->get('text_enabled');
		$params['text_disabled'] = $this->language->get('text_disabled');

		$params['button_save'] = $this->language->get('button_save');
		$params['button_apply'] = $this->language->get('button_apply');
		$params['button_cancel'] = $this->language->get('button_cancel');

		$params['breadcrumbs'] = array();

   		$params['breadcrumbs'][] = array(
       		'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/'.(version_compare(VERSION, '2.0', '<') ? 'home' : 'dashboard'), 'token='.$this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$params['breadcrumbs'][] = array(
       		'text' => $this->language->get('text_'.$this->type),
			'href' => $this->url->link('extension/'.$this->type, 'token='.$this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$params['breadcrumbs'][] = array(
       		'text' => $params['heading_title'],
			'href' => $this->url->link($this->type.'/'.$this->extension, 'token='.$this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$params['action'] = $this->url->link($this->type.'/'.$this->extension, 'token='.$this->session->data['token'], 'SSL');
		$params['cancel'] = $this->url->link('extension/'.$this->type, 'token='.$this->session->data['token'], 'SSL');


		
		$params['status'] = array(
			array('0', $params['text_disabled']),
			array('1', $params['text_enabled']));


		$params['stylesheet'] = $this->extension;

		/* Extension specific code */

		$params['options'] = array_merge(array(
			'coupon_code' => 'select',
			'product_price' => 'input',
			'quantity' => 'input',
			'header_message' => 'textarea'
			), $this->options);

		unset($params['options']['geo_zone']);
		unset($params['options']['tax_class']);
		unset($params['options']['sort_order']);
		unset($params['options']['customer_groups']);

		

		$this->language->load($this->type.'/'.$this->extension);

		/* Generic code */

		foreach ($params['options'] as $key => $type) {
			$params['entry_'.$key] = $this->language->get('entry_'.$key);
			$params['help_'.$key] = $this->language->get('help_'.$key);

			$from_post = (isset($this->request->post[$this->extension.'_'.$key]) ? $this->request->post[$this->extension.'_'.$key] : "");
			$from_config = $this->config->get($this->extension.'_'.$key);
			$default = ($type == 'checkbox' ? array() : "");

			if (!isset($params[$this->extension.'_'.$key])) {
				if (!empty($from_post)) $params[$this->extension.'_'.$key] = $from_post;
				elseif (isset($from_config)) $params[$this->extension.'_'.$key] = $from_config;
				else $params[$this->extension.'_'.$key] = $default;
			}
		}

		if (isset($this->session->data['errors'])) {
			foreach ($this->session->data['errors'] as $key => $text) {
				$this->error[$key] = $text;
			}

			unset($this->session->data['errors']);
        }

		if (!empty($this->error)) {
			$params['errors'] = $this->error;
		} else {
			$params['errors'] = "";
		}

		if (version_compare(VERSION, '2.0', '<')) {
			$this->data = $params;
			$this->template = $this->type.'/'.$this->extension.'.tpl';
			$this->children = array('common/header', 'common/footer');
        	$this->response->setoutput($this->render(true));
        } else {
        	$data = $params;
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view($this->type.'/'.$this->extension.'.tpl', $data));
		}
	}

    private function validate()
	{
		if (!$this->user->hasPermission('modify', $this->type.'/'.$this->extension)) {
			$this->error['warning'] = sprintf($this->language->get('error_permission'), $this->language->get('heading_title'));
		}

		$numerics = array();
		$percent = array();
		$nonempty = array('coupon_code', 'product_price', 'quantity', 'header_message');

		$fields = array_unique(array_merge($numerics, array_merge($percent, $nonempty)));
		$post = $this->request->post;

		if ($fields) {
			foreach ($fields as $field) {
				if (isset($post[$this->extension.'_'.$field])) {
					$value = $post[$this->extension.'_'.$field];

					if (in_array($field, $nonempty) && !$value) {
						$this->error[] = sprintf($this->language->get('error_empty'), $this->language->get('entry_'.$field));
					} elseif (!is_array($value)) {
						$value = trim($value, "%");

						if (!empty($value) && !is_numeric($value)) {
							if (in_array($field, $numerics)) {
								$this->error[] = sprintf($this->language->get('error_numerical'), $this->language->get('entry_'.$field));
							} elseif (in_array($field, $percent)) {
								$this->error[] = sprintf($this->language->get('error_percent'), $this->language->get('entry_'.$field));
							}
    	        		} elseif ($value < 0) {
        	    			$this->error[] = sprintf($this->language->get('error_positive'), $this->language->get('entry_'.$field));
            			}
            		}
	            } elseif (in_array($field, $nonempty)) {
    	        	$this->error[] = sprintf($this->language->get('error_empty'), $this->language->get('entry_'.$field));
        	    }
			}
		}

		if (!$this->error) return true;
		else return false;
	}

}

?>