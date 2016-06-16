<?php
/**
 * @extension-payment	GOP_COD
 * @author-name			Michail Gkasios
 * @copyright			Copyright (C) 2013 GKASIOS
 * @license				GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

class ControllerPaymentGOPCOD extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->model('setting/setting');

		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$this->model_setting_setting->editSetting('GOP_COD', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		//Language Loading
		$data = array();
		$data += $this->language->load('payment/GOP_COD');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array	(
											'text' => $this->language->get('text_home'),
											'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
										);

		$data['breadcrumbs'][] = array	(
											'text' => $this->language->get('text_payment'),
											'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
										);

		$data['breadcrumbs'][] = array	(
											'text' => $this->language->get('heading_title'),
											'href' => $this->url->link('payment/GOP_COD', 'token=' . $this->session->data['token'], 'SSL')
										);

		$data['small_logo'] = "view/image/payment/GKASIOS_Logo_Main_Animated.gif";
		$data['paypal_button_id'] = "TXJMRFUWHCFKG";

		$data['action'] = $this->url->link('payment/GOP_COD', 'token='.$this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/payment', 'token='.$this->session->data['token'], 'SSL');

		$this->load->model('localisation/geo_zone');

		$geo_zones = Array(0 => Array("geo_zone_id" => 0, "name" => $data['text_all_zones'], "description" => $data['text_all_zones'], "date_modified" => '0000-00-00 00:00:00', "date_added" => '0000-00-00 00:00:00'));
		$geo_zones = array_merge($geo_zones, $this->model_localisation_geo_zone->getGeoZones());
		$data['geo_zones'] = $geo_zones;

		$this->load->model('customer/customer_group');

		$customer_groups = $this->model_customer_customer_group->getCustomerGroups();

		$data['customer_groups'] = $customer_groups;

		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('shipping');

		foreach($extensions as $key => $value)
		{
			if(!file_exists(DIR_APPLICATION . 'controller/shipping/' . $value . '.php'))
			{
				$this->model_setting_extension->uninstall('shipping', $value);
				unset($extensions[$key]);
			}
		}

		$data['extensions'] = array();
		$data['extensions'][] = array	(
											'name'	=>	'noshipping',
											'title'	=>	$this->language->get('tab_noshipping')
										);

		$files = glob(DIR_APPLICATION . 'controller/shipping/*.php');

		if($files)
		{
			foreach($files as $file)
			{
				$extension = basename($file, '.php');
				$this->language->load('shipping/' . $extension);

				if(in_array($extension, $extensions))
				{
					$data['extensions'][] = array	(
														'name'	=>	$extension,
														'title'	=>	$this->language->get('heading_title')
													);
				}
			}
		}

		$geo_zones = Array(0 => Array("geo_zone_id" => 0, "name" => $data['text_all_zones'], "description" => $data['text_all_zones'], "date_modified" => '0000-00-00 00:00:00', "date_added" => '0000-00-00 00:00:00'));
		$geo_zones = array_merge($geo_zones, $this->model_localisation_geo_zone->getGeoZones());

		$this->language->load('payment/GOP_COD');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency");

		$currencies = array();
		foreach($query->rows as $result)
		{
			$currencies[$result['code']] = array(
													'currency_id'	=>	$result['currency_id'],
													'title'			=>	$result['title'],
													'symbol_left'	=>	$result['symbol_left'],
													'symbol_right'	=>	$result['symbol_right'],
													'decimal_place'	=>	$result['decimal_place'],
													'value'			=>	$result['value']
												);
		}

		$data['currencies'] = $currencies;

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();


		//----------------------Data-----------------------

		//Default

		if(isset($this->request->post['GOP_COD_status']))
		{
			$data['GOP_COD_status'] = $this->request->post['GOP_COD_status'];
		}
		else
		{
			$data['GOP_COD_status'] = $this->config->get('GOP_COD_status');
		}

		if(isset($this->request->post['GOP_COD_default_status']))
		{
			$data['GOP_COD_default_status'] = $this->request->post['GOP_COD_default_status'];
		}
		else
		{
			$data['GOP_COD_default_status'] = $this->config->get('GOP_COD_default_status');
		}

		if(isset($this->request->post['GOP_COD_default_shipping_geo_zone']))
		{
			$data['GOP_COD_default_shipping_geo_zone'] = $this->request->post['GOP_COD_default_shipping_geo_zone'];
		}
		else
		{
			$data['GOP_COD_default_shipping_geo_zone'] = $this->config->get('GOP_COD_default_shipping_geo_zone');
		}

		if(isset($this->request->post['GOP_COD_default_sort_order']))
		{
			$data['GOP_COD_default_sort_order'] = $this->request->post['GOP_COD_default_sort_order'];
		}
		else
		{
			$data['GOP_COD_default_sort_order'] = $this->config->get('GOP_COD_default_sort_order');
		}

		foreach($geo_zones as $geo_zone)
		{
			foreach($customer_groups as $customer_group)
			{
				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status'] = $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status'] = $this->config->get('GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status');
				}
			}
		}

		//Extension

		foreach($data['extensions'] as $extension)
		{
			if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_status']))
			{
				$data['GOP_COD_' . $extension['name'] . '_status'] = $this->request->post['GOP_COD_' . $extension['name'] . '_status'];
			}
			else
			{
				$data['GOP_COD_' . $extension['name'] . '_status'] = $this->config->get('GOP_COD_' . $extension['name'] . '_status');
			}

			if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_shipping_geo_zone']))
			{
				$data['GOP_COD_' . $extension['name'] . '_shipping_geo_zone'] = $this->request->post['GOP_COD_' . $extension['name'] . '_shipping_geo_zone'];
			}
			else
			{
				$data['GOP_COD_' . $extension['name'] . '_shipping_geo_zone'] = $this->config->get('GOP_COD_' . $extension['name'] . '_shipping_geo_zone');
			}

			if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_sort_order']))
			{
				$data['GOP_COD_' . $extension['name'] . '_sort_order'] = $this->request->post['GOP_COD_' . $extension['name'] . '_sort_order'];
			}
			else
			{
				$data['GOP_COD_' . $extension['name'] . '_sort_order'] = $this->config->get('GOP_COD_' . $extension['name'] . '_sort_order');
			}

			foreach($geo_zones as $geo_zone)
			{
				foreach($customer_groups as $customer_group)
				{
					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_tax_class_id');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_currency');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_custom');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_enable_rule');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_status_id');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status'] = $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status'] = $this->config->get('GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_status');
					}
				}
			}
		}

		//----------------------Errors-----------------------

		if(isset($this->error['GOP_COD_warning']))
		{
			$data['GOP_COD_warning_error'] = $this->error['GOP_COD_warning'];
		}
		else
		{
			$data['GOP_COD_warning_error'] = '';
		}

		//Default

		if(isset($this->error['GOP_COD_default_sort_order']))
		{
			$data['GOP_COD_default_sort_order_error'] = $this->error['GOP_COD_default_sort_order'];
		}
		else
		{
			$data['GOP_COD_default_sort_order_error'] = '';
		}

		$geo_zones = Array(0 => Array("geo_zone_id" => 0, "name" => $data['text_all_zones'], "description" => $data['text_all_zones'], "date_modified" => '0000-00-00 00:00:00', "date_added" => '0000-00-00 00:00:00'));
		$geo_zones = array_merge($geo_zones, $this->model_localisation_geo_zone->getGeoZones());

		foreach($geo_zones as $geo_zone)
		{
			foreach($customer_groups as $customer_group)
			{
				if(isset($this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_error'] = $this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_error'] = '';
				}

				if(isset($this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent_error'] = $this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent_error'] = '';
				}

				if(isset($this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']))
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order_error'] = $this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'];
				}
				else
				{
					$data['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order_error'] = '';
				}
			}
		}

		//Extensions

		foreach($data['extensions'] as $extension)
		{
			if(isset($this->error['GOP_COD_' . $extension['name'] . '_sort_order']))
			{
				$data['GOP_COD_' . $extension['name'] . '_sort_order_error'] = $this->error['GOP_COD_' . $extension['name'] . '_sort_order'] ;
			}
			else
			{
				$data['GOP_COD_' . $extension['name'] . '_sort_order_error'] = '';
			}

			foreach($geo_zones as $geo_zone)
			{
				foreach($customer_groups as $customer_group)
				{
					if(isset($this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_error'] = $this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat_error'] = '';
					}

					if(isset($this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent_error'] = $this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent_error'] = '';
					}

					if(isset($this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']))
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order_error'] = $this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'];
					}
					else
					{
						$data['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order_error'] = '';
					}
				}
			}
		}

		//-----------------------Render--------------------------

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/GOP_COD.tpl', $data));
	}

	private function validate()
	{
		$this->language->load('payment/GOP_COD');

		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('shipping');

		foreach($extensions as $key => $value)
		{
			if(!file_exists(DIR_APPLICATION . 'controller/shipping/' . $value . '.php'))
			{
				$this->model_setting_extension->uninstall('shipping', $value);
				unset($extensions[$key]);
			}
		}

		$data['extensions'] = array();
		$data['extensions'][] = array	(
											'name'	=>	'noshipping',
											'title'	=>	$this->language->get('tab_noshipping'),
										);

		$files = glob(DIR_APPLICATION . 'controller/shipping/*.php');

		if($files)
		{
			foreach($files as $file)
			{
				$extension = basename($file, '.php');

				$this->language->load('shipping/' . $extension);
				if(in_array($extension, $extensions))
				{

					$data['extensions'][] = array	(
														'name'	=>	$extension,
														'title'	=>	$this->language->get('heading_title')
													);
				}
			}
		}

		$this->language->load('payment/GOP_COD');

		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->load->model('customer/customer_group');

		$customer_groups = $this->model_customer_customer_group->getCustomerGroups();

		$this->load->model('localisation/geo_zone');

		$geo_zones = Array(0 => Array( "geo_zone_id" => 0, "name" => $data['text_all_zones'], "description" => $data['text_all_zones'], "date_modified" => '0000-00-00 00:00:00', "date_added" => '0000-00-00 00:00:00'));
		$geo_zones = array_merge($geo_zones, $this->model_localisation_geo_zone->getGeoZones());

		if(!$this->user->hasPermission('modify', 'payment/GOP_COD'))
		{
			$this->error['GOP_COD_warning'] = $this->language->get('error_permission');
		}

		//Default

		if(isset($this->request->post['GOP_COD_default_sort_order']) && !is_numeric($this->request->post['GOP_COD_default_sort_order']) && $this->request->post['GOP_COD_default_sort_order'] != '')
		{
			$this->error['GOP_COD_default_sort_order'] = $this->language->get('error_number');
		}

		foreach($geo_zones as $geo_zone)
		{
			foreach($customer_groups as $customer_group)
			{
				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']) && !is_numeric($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']) && $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] != '')
				{
					$this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] = $this->language->get('error_number');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']) && !is_numeric($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']) && $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] != '')
				{
					$this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] = $this->language->get('error_number');
				}

				if(isset($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']) && !is_numeric($this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']) && $this->request->post['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] != '')
				{
					$this->error['GOP_COD_default_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] = $this->language->get('error_number');
				}
			}
		}

		//Extensions

		foreach($data['extensions'] as $extension)
		{
			if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_sort_order']) && !is_numeric($this->request->post['GOP_COD_' . $extension['name'] . '_sort_order']) && $this->request->post['GOP_COD_' . $extension['name'] . '_sort_order'] != '')
			{
				$this->error['GOP_COD_' . $extension['name'] . '_sort_order'] = $this->language->get('error_number');
			}

			foreach($geo_zones as $geo_zone)
			{
				foreach($customer_groups as $customer_group)
				{
					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']) && !is_numeric($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat']) && $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] != '' && $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'] == 1)
					{
						$this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_flat'] = $this->language->get('error_number');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']) && !is_numeric($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent']) && $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] != '' && $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_method'] == 2)
					{
						$this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_percent'] = $this->language->get('error_number');
					}

					if(isset($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']) && !is_numeric($this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order']) && $this->request->post['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] != '')
					{
						$this->error['GOP_COD_' . $extension['name'] . '_' . $geo_zone['geo_zone_id'] . '_' . $customer_group['customer_group_id'] . '_order_total_sort_order'] = $this->language->get('error_number');
					}
				}
			}
		}

		return !$this->error;
	}

	public function confirm()
	{
		$this->load->model('checkout/order');
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
	}
}
?>