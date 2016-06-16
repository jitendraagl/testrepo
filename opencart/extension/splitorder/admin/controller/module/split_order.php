<?php
/*------------------------------------------------------------------------
# Split Order
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2015 thekrotek.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: http://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/

class ControllerModuleSplitOrder extends Controller
{
    private $type = "module";
	private $extension = "split_order";
	private $error = array();
	private $options = array(
		'customer_groups' => 'checkbox',
		'tax_class' => 'select',
		'geo_zone' => 'select',
		'status' => 'select',
		'sort_order' => 'input');

	public function index()
	{
		if (version_compare(VERSION, '2.0', '<')) $params = $this->data;
		else $params = array();

		$params['extension'] = $this->extension;
		$params['type'] = $this->type;

        $this->language->load($this->type.'/'.$this->extension);

		$params['heading_title'] = $this->language->get('heading_title');

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

		if (ini_get('allow_url_fopen')) {
			if (@simplexml_load_file('http://thekrotek.com/updates.xml')) {
        		$xml = simplexml_load_file('http://thekrotek.com/updates.xml');
				$latest = $xml->{$this->extension}->version;
				$current = $this->language->get('heading_version');

				if (version_compare($current, $latest, '=')) {
					$version = sprintf($this->language->get('heading_latest'), $latest);
					$class = "latest";
				} elseif (version_compare($current, $latest, '>')) {
					$version = sprintf($this->language->get('heading_future'), $current);
					$class = "future";
				} else {
					$version = sprintf($this->language->get('heading_update'), $latest);
					$class = "update";
				}
			} else {
				$version = $this->language->get('error_version');
				$class = "error";
			}
		} else {
			$version = $this->language->get('error_fopen');
			$class = "error";
		}

		$params['version'] = "<span class='version ".$class."'>".$version."</span>";

		if (version_compare(VERSION, '2.0', '>=')) $params['text_edit'] = sprintf($this->language->get('text_edit_title'), $this->language->get('heading_title'));

		$params['text_yes'] = $this->language->get('text_yes');
		$params['text_no'] = $this->language->get('text_no');
		$params['text_enabled'] = $this->language->get('text_enabled');
		$params['text_disabled'] = $this->language->get('text_disabled');
		$params['text_select_all'] = $this->language->get('text_select_all');
		$params['text_unselect_all'] = $this->language->get('text_unselect_all');

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

		$this->load->model('sale/customer_group');
		$customer_groups = $this->model_sale_customer_group->getCustomerGroups();

		foreach ($customer_groups as $customer_group) {
			$params['customer_groups'][] = array($customer_group['customer_group_id'], $customer_group['name']);
		}

		$this->load->model('localisation/tax_class');
		$taxes = $this->model_localisation_tax_class->getTaxClasses();

		$params['tax_class'][] = array(0, $this->language->get('text_none'));

		foreach ($taxes as $tax) {
			$params['tax_class'][] = array($tax['tax_class_id'], $tax['title']);
		}

		$this->load->model('localisation/geo_zone');
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();

		$params['geo_zone'][] = array(0, $this->language->get('text_all_zones'));

		foreach ($geo_zones as $geo_zone) {
			$params['geo_zone'][] = array($geo_zone['geo_zone_id'], $geo_zone['name']);
		}

		$this->load->model('localisation/order_status');
        $statuses = $this->model_localisation_order_status->getOrderStatuses();

        $params['order_status'] = array();

        foreach ($statuses as $status) {
        	$params['order_status'][] = array($status['order_status_id'], $status['name']);
        }

		$params['status'] = array(
			array('0', $params['text_disabled']),
			array('1', $params['text_enabled']));

		$this->load->model('localisation/language');
		$params['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/stock_status');
		$statuses = $this->model_localisation_stock_status->getStockStatuses();

        foreach ($statuses as $status) {
        	$params['stock_status'][] = array($status['stock_status_id'], $status['name']);
        }

		$params['stylesheet'] = $this->extension;

		/* Extension specific code */

		$params['options'] = array_merge(array(
			'order_status' => 'select',
			'payment' => 'select',
			'shipping' => 'select',
			'notify' => 'radio',
			'comment' => 'radio',
			'coupons' => 'radio',
			'vouchers' => 'radio',
			'rewards' => 'radio',
			'affiliate' => 'radio',
			'feedback' => 'select'), $this->options);

		unset($params['options']['geo_zone']);
		unset($params['options']['tax_class']);
		unset($params['options']['sort_order']);
		unset($params['options']['customer_groups']);

		array_unshift($params['order_status'], array("", $this->language->get('text_default')));

		if (version_compare(VERSION, '2.0', '<')) {
			$this->load->model('setting/extension');
			$payments = $this->model_setting_extension->getInstalled('payment');
		} else {
			$this->load->model('extension/extension');
			$payments = $this->model_extension_extension->getInstalled('payment');
		}

		if ($payments) {
			$params['payment'] = array();

			foreach ($payments as $payment) {
				$this->language->load('payment/'.$payment);
				$params['payment'][] = array($payment, $this->language->get('heading_title'));
			}
		}

		if (version_compare(VERSION, '2.0', '<')) {
			$this->load->model('setting/extension');
			$shippings = $this->model_setting_extension->getInstalled('shipping');
		} else {
			$this->load->model('extension/extension');
			$shippings = $this->model_extension_extension->getInstalled('shipping');
		}

		if ($shippings) {
			$params['shipping'] = array();

			foreach ($shippings as $shipping) {
				$this->language->load('shipping/'.$shipping);
				$params['shipping'][] = array($shipping, $this->language->get('heading_title'));
			}
		}

		$this->language->load($this->type.'/'.$this->extension);

		$params['feedback'] = array(
			array('', $this->language->get('text_feedback_silent')),
			array('full', $this->language->get('text_feedback_full')),
			array('errors', $this->language->get('text_feedback_errors')),
			array('warnings', $this->language->get('text_feedback_warnings')),
			array('messages', $this->language->get('text_feedback_messages')));

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
		$nonempty = array();

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

  	public function split()
  	{
  		$errors = array();
  		$warnings = array();
  		$messages = array();

  		$this->load->language('sale/order');
  		$this->load->language('module/split_order');

		$this->load->model('sale/order');
		$this->load->model('sale/customer');

  		// Basic permission check

		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->addMessage($errors, $this->language->get('error_permission'));
		}

		// API check

		if (!$errors) {
			$result = $this->apiLogin();
  			if (isset($result['error'])) $this->addMessage($errors, json_decode(json_encode($result['error'], true)));
		}

		// Get submitted products

		if (!empty($this->request->get['products'])) {
			$submitted = explode(",", $this->request->get['products']);
		} else {
			$this->addMessage($errors, $this->language->get('error_products'));
		}

		if (!$errors) {
  			$splitted = array();

  			foreach ($submitted as $item) {
  				$item = explode(":", $item);
  				$splitted[$item[0]] = array(
  					'product_id' => $item[1],
  					'quantity' => $item[2]);
  			}

 			$base_order = $this->model_sale_order->getOrder($this->request->get['order_id']);
  			$store_id = $base_order['store_id'];
  			$base_id = $base_order['order_id'];
  			$split_id = 0;
  			
			$base_language = new Language($base_order['language_directory']);
			$base_language->load($base_order['language_directory']);
			$base_language->load('module/split_order');
  		}

  		// Apply customer

  		if (!$errors) {
  			$customer = $this->model_sale_customer->getCustomer($base_order['customer_id']);

  			if (isset($customer['birth_date']) && $this->config->get('bdiscount_status')) {
  				if (strtotime($customer['birth_date']) !== false) $customer['birth_date'] = strtotime($customer['birth_date']);
				if (is_numeric($customer['birth_date'])) $customer['birth_date'] = date($this->config->get('bdiscount_format'), $customer['birth_date']);
  			}

  			$result = $this->apiRequest("index.php?route=api/customer&store_id=".$store_id, $customer);

  			if (isset($result['error'])) $this->addMessage($errors, json_decode(json_encode($result['error']), true));
			else $this->addMessage($messages, $this->language->get('message_customer'));
		}

		// Get cart products

		$result = $this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);

		if (isset($result['error'])) $this->addMessage($errors, json_decode(json_encode($result['error']), true));
		else $base_products = json_decode(json_encode($result['products']), true);

  		// Split products

  		if (!$errors) {
			$orders = array('split' => $split_id, 'base' => $base_id);

  			$base_data = array();

			if ($base_products) {
				foreach ($base_products as $product) {
					if (!empty($product['option'])) {
						$options = $product['option'];
						$product['option'] = array();

						foreach ($options as $option) {
							if (($option['type'] == 'select') || ($option['type'] == 'radio') || ($option['type'] == 'image')) {
								$product['option'][$option['product_option_id']] = $option['product_option_value_id'];
							} elseif ($option['type'] == 'checkbox') {
								$product['option'][$option['product_option_id']][] = $option['product_option_value_id'];
							} else {
								$product['option'][$option['product_option_id']] = $option['value'];
							}
						}
					}

					$base_data['product'][] = $product;
				}

				$split_data = array();

				foreach ($splitted as $key => $data) {
					$split_data['product'][] = $base_data['product'][$key];

					if ($base_data['product'][$key]['quantity'] == $data['quantity']) {
						unset($base_data['product'][$key]);
					} else {
						$base_data['product'][$key]['quantity'] -= $data['quantity'];
						$split_data['product'][$key]['quantity'] = $data['quantity'];
					}
				}

				if (empty($base_data['product'])) {
					$this->addMessage($errors, $this->language->get('error_base_empty'));
				} else {
					$base_data['product'] = array_values($base_data['product']);
				}
			} else {
				 $this->addMessage($errors, $this->language->get('error_base_empty'));
			}
		}

		if (!$errors) {
			foreach ($orders as $type => $order_id) {
				$str = $this->language->get('text_'.$type.'_order').": ";

				// Add products to cart

				$result = $this->apiRequest("index.php?route=api/cart/add&store_id=".$store_id, ${$type.'_data'});

				if (isset($result['error'])) $this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);
				else $this->addMessage($messages, $this->language->get('message_products'), $str);

  				// Get payment methods

				if (!$errors) {
					$address =  array(
						'firstname'      => $base_order['payment_firstname'],
						'lastname'       => $base_order['payment_lastname'],
						'company'        => $base_order['payment_company'],
						'address_1'      => $base_order['payment_address_1'],
						'address_2'      => $base_order['payment_address_2'],
						'postcode'       => $base_order['payment_postcode'],
						'city'           => $base_order['payment_city'],
						'zone_id'        => $base_order['payment_zone_id'],
						'country_id'     => $base_order['payment_country_id'],
						'address_format' => $base_order['payment_address_format'],
						'custom_field'   => unserialize($base_order['payment_custom_field']));

 					$result = $this->apiRequest("index.php?route=api/payment/address&store_id=".$store_id, $address);

  					if (isset($result['error'])) $this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);

					if (!$errors) {
						$payments = json_decode(json_encode($this->apiRequest("index.php?route=api/payment/methods&store_id=".$store_id)), true);
  						if (isset($payments['error'])) $this->addMessage($errors, json_decode(json_encode($payments['error']), true), $str);
  						else $this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
					}
				}

  				// Get shipping methods

				if (!$errors) {
					$address =  array(
						'firstname'      => $base_order['shipping_firstname'],
						'lastname'       => $base_order['shipping_lastname'],
						'company'        => $base_order['shipping_company'],
						'address_1'      => $base_order['shipping_address_1'],
						'address_2'      => $base_order['shipping_address_2'],
						'postcode'       => $base_order['shipping_postcode'],
						'city'           => $base_order['shipping_city'],
						'zone_id'        => $base_order['shipping_zone_id'],
						'country_id'     => $base_order['shipping_country_id'],
						'address_format' => $base_order['shipping_address_format'],
						'custom_field'   => unserialize($base_order['shipping_custom_field']));

  					$result = $this->apiRequest("index.php?route=api/shipping/address&store_id=".$store_id, $address);

  					if (isset($result['error'])) $this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);

					if (!$errors) {
						$shippings = json_decode(json_encode($this->apiRequest("index.php?route=api/shipping/methods&store_id=".$store_id)), true);

  						if (isset($shippings['error'])) $this->addMessage($errors, json_decode(json_encode($shippings['error']), true), $str);
						else $this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
					}
				}

				// Apply payment

				if (!$errors) {
					$data = array();

					if (!isset($payment_method)) {
						if (isset($payments['payment_methods'][$base_order['payment_code']])) {
							$error_payment = "";
							$data['payment_method'] = $base_order['payment_code'];
						} else {
							$error_payment = $this->language->get('error_payment');
							$data['payment_method'] = $this->config->get($this->extension.'_payment');
						}

						$payment_method = $data['payment_method'];
					} else {
						$data['payment_method'] = $payment_method;
					}

					$result = $this->apiRequest("index.php?route=api/payment/method&store_id=".$store_id, $data);

  					if (isset($result['error'])) {
  						$this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);
					} else {
						if ($error_payment) $this->addMessage($warnings, $error_payment, $str);
						else $this->addMessage($messages, $this->language->get('message_payment'), $str);

						$this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
					}
				}

				// Apply shipping

				if (!$errors) {
					$data = array();

					if (!isset($shipping_method)) {
						$shipping_code = explode(".", $base_order['shipping_code']);

						foreach ($shippings['shipping_methods'] as $code => $values) {
							if ($code == $shipping_code[0]) {
								if (!$values['error'] && isset($values['quote'][$shipping_code[1]])) {
									$error_shipping = "";
									$data['shipping_method'] = $base_order['shipping_code'];
								} else {
									if ($values['error']) $error = $values['error'];
									else $error = $this->language->get('error_unavailable');
						
									$error_shipping = sprintf($this->language->get('error_shipping'), $error);
					
									foreach ($shippings['shipping_methods'][$this->config->get($this->extension.'_shipping')]['quote'] as $quote) {
										$data['shipping_method'] = $quote['code'];
										break;
									}
								}
							}
						}

						$shipping_method = $data['shipping_method'];
					} else {
						$data['shipping_method'] = $shipping_method;
					}

					$result = $this->apiRequest("index.php?route=api/shipping/method&store_id=".$store_id, $data);

  					if (isset($result['error'])) {
  						$this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);
					} else {
						if ($error_shipping) $this->addMessage($warnings, $error_shipping, $str);
						else $this->addMessage($messages, $this->language->get('message_shipping'), $str);

						$this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
					}
				}

  				if (!$errors) {

  					// Apply coupon

  					if ($this->config->get($this->extension.'_coupons')) {
  						if (!isset($coupon)) $coupon = $this->getCoupon($base_id);

  						if ($coupon) {
 							$this->deleteCoupon($coupon['coupon_id']);
  							$result = $this->apiRequest("index.php?route=api/coupon&store_id=".$store_id, array('coupon' => $coupon['code']));

  							if (isset($result['error'])) {
  								$this->addMessage($warnings, json_decode(json_encode($result['error']), true), $str);
  							} else {
  								$this->addMessage($messages, $this->language->get('message_coupons'), $str);
								$this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
							}
						}
					}

  					// Apply vouchers

  					if ($this->config->get($this->extension.'_vouchers')) {
  						if (!isset($voucher)) $voucher = $this->getVoucher($base_id);

  						if ($voucher) {
 							$this->deleteVoucher($voucher['voucher_id']);
  							$result = $this->apiRequest("index.php?route=api/voucher&store_id=".$store_id, array('voucher' => $voucher['code']));

  							if (isset($result['error'])) {
  								$this->addMessage($warnings, json_decode(json_encode($result['error']), true), $str);
  							} else {
  								$this->addMessage($messages, $this->language->get('message_vouchers'), $str);
  								$result = $this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
  							}
						}
					}

  					// Apply rewards

  					if ($this->config->get($this->extension.'_rewards')) {
  						if (!isset($reward)) $reward = $this->getReward($base_id);

  						if ($reward) {
  							$this->deleteReward($reward['customer_reward_id']);
  							$result = $this->apiRequest("index.php?route=api/reward&store_id=".$store_id, array('reward' => abs($reward['points'])));

  							if (isset($result['error'])) {
  								$this->addMessage($warnings, json_decode(json_encode($result['error']), true), $str);
							} else {
								$this->addMessage($messages, $this->language->get('message_rewards'), $str);
								$this->apiRequest("index.php?route=api/cart/products&store_id=".$store_id);
							}
						}
					}

					// Save order

					if ($this->config->get($this->extension.'_comment')) {
						$comment = sprintf($base_language->get('text_'.$type.'_comment'), (($type == 'base') ? $split_id : $base_id));
					} else {
						$comment = "";
					}

					if ($this->config->get($this->extension.'_order_status')) {
						$order_status = $this->config->get($this->extension.'_order_status');
						$this->addMessage($messages, $this->language->get('message_status'));
					} else {
						$order_status = $base_order['order_status_id'];
					}

					$data = array(
						'shipping_method' => $shipping_method,
						'comment' => $comment,
						'order_status_id' => 0,
						'affiliate_id' => ($this->config->get($this->extension.'_affiliate') ? $base_order['affiliate_id'] : ""));

					if (($type == 'base') && $split_id) {
						$result = $this->apiRequest("index.php?route=api/order/edit&store_id=".$store_id."&order_id=".$base_id, $data);
						
						$this->updateStatus($base_id, $base_order['order_status_id']);

						if (isset($result['error'])) {
  							$this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);
  						} else {
 							if ($this->config->get($this->extension.'_notify')) {
 								$this->updateStatus($base_id, 99999);
 								
  								$data = array(
  									'notify' => true,
									'order_status_id' => $order_status,
									'comment' => $comment);

  								$result = $this->apiRequest("index.php?route=api/order/history&store_id=".$store_id."&order_id=".$base_id, $data);

  								if (isset($result['error'])) $this->addMessage($warnings, json_decode(json_encode($result['error']), true));
								else $this->addMessage($messages, $this->language->get('message_notified'), $str);
							}
						}  							
					} else {
						if ($this->config->get($this->extension.'_notify')) {
							$data['order_status_id'] = $order_status;
						}
						
						$result = $this->apiRequest("index.php?route=api/order/add&store_id=".$store_id, $data);

  						if (isset($result['error'])) {
  							$this->addMessage($errors, json_decode(json_encode($result['error']), true), $str);
  							break;
  						} else {
  							$split_id = $result['order_id'];
  							$this->addMessage($messages, sprintf($this->language->get('message_split'), $split_id));
  							
 							if ($this->config->get($this->extension.'_notify')) {
 								$this->addMessage($messages, $this->language->get('message_notified'), $str);
 							} else {
 								$this->addOrderHistory($split_id, $order_status, $comment);
 							}
  						}
					}
	  			}
	  		}
		}
					
		// Process messages

		$feedback = $this->config->get($this->extension.'_feedback');

		if ($feedback) {
			if ($errors && (($feedback == 'full') || ($feedback == 'errors'))) {
				$this->session->data['split_errors']  = $this->language->get('text_errors');
				$this->session->data['split_errors'] .= "<ul><li>".implode("</li><li>", $errors)."</li></ul>";
			}

			if ($warnings && (($feedback == 'full') || ($feedback == 'warnings'))) {
				$this->session->data['split_warnings']  = $this->language->get('text_warnings');
				$this->session->data['split_warnings'] .= "<ul><li>".implode("</li><li>", $warnings)."</li></ul>";
			}

  			if ($messages && (($feedback == 'full') || ($feedback == 'messages'))) {
				$this->session->data['split_messages']  = $this->language->get('text_messages');
				$this->session->data['split_messages'] .= "<ul><li>".implode("</li><li>", $messages)."</li></ul>";
			}
		}

  		$this->response->redirect($this->url->link('sale/order/edit', 'token='.$this->session->data['token'].'&order_id='.$base_id, 'SSL'));
	}

	private function addMessage(&$array, $item, $str = '')
	{
		if (is_array($item)) {
			foreach ($item as $text) {
				$array[] = $str.$text;
			}
		} else {
			$array[] = $str.$item;
		}

		return $array;
	}

	private function apiLogin()
	{
		$json = array();

		$this->load->language('sale/order');

		$this->load->model('sale/order');
		$this->load->model('user/api');

		unset($this->session->data['cookie']);

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			$curl = curl_init();

			if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
				curl_setopt($curl, CURLOPT_PORT, 443);
			}

			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLINFO_HEADER_OUT, true);
			curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.'index.php?route=api/login');
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

			$result = curl_exec($curl);

			if (!$result) {
				$json['error'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
			} else {
				$response = json_decode($result, true);

				if (isset($response['cookie'])) {
					$this->session->data['cookie'] = $response['cookie'];
				} else {
					$json['error'] = $this->language->get('error_api_login');
				}

				curl_close($curl);
			}
		} else {
			$json['error'] = $this->language->get('error_api_id');
		}

		return $json;
	}

	private function apiRequest($url, $data = array())
	{
		if (isset($this->session->data['cookie'])) {
			$curl = curl_init();

			if (substr($url, 0, 5) == 'https') {
				curl_setopt($curl, CURLOPT_PORT, 443);
			}

			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLINFO_HEADER_OUT, true);
			curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG.$url);

			if ($data) {
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
			}

			curl_setopt($curl, CURLOPT_COOKIE, session_name().'='.$this->session->data['cookie'].';');

			$result = curl_exec($curl);

			if (!$result) {
				$json['error'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
			} else {
				$json = (array)json_decode($result);
			}

			curl_close($curl);
		} else {
			$json['error'] = $this->language->get('error_api_login');
		}

		return $json;
	}

	private function getCoupon($order_id)
	{
		$query = $this->db->query("SELECT c.coupon_id, c.code FROM `".DB_PREFIX."coupon` AS c LEFT JOIN `".DB_PREFIX."coupon_history` AS ch ON ch.coupon_id = c.coupon_id WHERE ch.order_id = '".(int)$order_id."'");

		return $query->row;
	}

	private function deleteCoupon($coupon_id)
	{
		$this->db->query("DELETE FROM `".DB_PREFIX."coupon_history` WHERE coupon_id = '".(int)$coupon_id."'");
	}

	private function getVoucher($order_id)
	{
		$query = $this->db->query("SELECT v.voucher_id, v.code FROM `".DB_PREFIX."voucher` AS v LEFT JOIN `".DB_PREFIX."voucher_history` AS vh ON vh.voucher_id = v.voucher_id WHERE vh.order_id = '".(int)$order_id."'");

		return $query->row;
	}

	private function deleteVoucher($voucher_id)
	{
		$this->db->query("DELETE FROM `".DB_PREFIX."voucher_history` WHERE voucher_id = '".(int)$voucher_id."'");
	}

	private function getReward($order_id)
	{
		$query = $this->db->query("SELECT customer_reward_id, points FROM `".DB_PREFIX."customer_reward` WHERE order_id = '".(int)$order_id."' AND points < 0");

		return $query->row;
	}

	private function deleteReward($reward_id)
	{
		$this->db->query("DELETE FROM `".DB_PREFIX."customer_reward` WHERE customer_reward_id = '".(int)$reward_id."' AND points < 0");
	}
	
	private function updateStatus($order_id, $order_status_id)
	{
		$this->db->query("UPDATE `".DB_PREFIX."order` SET order_status_id = '".(int)$order_status_id."' WHERE order_id = '".(int)$order_id."'");
	}
	
	private function addOrderHistory($order_id, $order_status_id, $comment = '')
	{	
		$this->db->query("UPDATE `".DB_PREFIX."order` SET order_status_id = '".(int)$order_status_id."', date_modified = NOW() WHERE order_id = '".(int)$order_id."'");

		$this->db->query("INSERT INTO ".DB_PREFIX."order_history SET order_id = '".(int)$order_id."', order_status_id = '".(int)$order_status_id."', notify = '1', comment = '".$this->db->escape($comment)."', date_added = NOW()");
	}
}

?>