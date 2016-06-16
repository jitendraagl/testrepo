<?php

		$data['tab_class'] = 'vtabs';

		$data['tabs'][] = array(
			'id'		=> 'tab_general',
			'title'		=> $this->language->get('tab_general')
		);

		$data['tabs'][] = array(
			'id'		=> 'tab_support',
			'title'		=> $this->language->get('tab_support')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry' 		=> $this->language->get('entry_status'),
			'type'			=> 'select',
			'name' 			=> 'status',
			'value' 		=> (isset($this->request->post['status'])) ? $this->request->post['status'] : $this->config->get($classname . '_status'),
			'required' 		=> false,
			'options'		=> array(
				'0' => $this->language->get('text_disabled'),
				'1' => $this->language->get('text_enabled')
			),
			'help'			=> ($this->language->get('help_status') != 'help_status' ? $this->language->get('help_status') : ''),
			'tooltip'		=> ($this->language->get('tooltip_status') != 'tooltip_status' ? $this->language->get('tooltip_status') : '')
		);

		foreach ($languages as $language_id => $language_name) {
			$data['fields'][] = array(
				'entry' 		=> '[ ' . $language_name . ' ] ' . $this->language->get('entry_title'),
				'type'			=> 'text',
				'size'			=> '20',
				'name' 			=> 'title_' . $language_id,
				'value' 		=> ((isset($this->request->post['title_' . $language_id])) ? $this->request->post['title_' . $language_id] : $this->config->get($classname . '_title_' . $language_id) ? $this->config->get($classname . '_title_' . $language_id) : ucwords(str_replace(array('-','_','.'), " ", $classname))),
				'required' 		=> false,
				'help'			=> ($this->language->get('help_title') != 'help_title' ? $this->language->get('help_title') : ''),
				'tooltip'		=> ($this->language->get('tooltip_title') != 'tooltip_title' ? $this->language->get('tooltip_title') : '')
			);
		}


		if (version_compare(VERSION, '2.0', '<')) { // v15x Compatibility
			$this->load->model('setting/extension');
			$payments = $this->model_setting_extension->getInstalled('payment');
		} else { // 2.0
			$this->load->model('extension/extension');
			$payments = $this->model_extension_extension->getInstalled('payment');
		}
		$types = array();
		foreach ($payments as $payment) {
			$this->load->language('payment/' . $payment);
			$types[$payment] = $this->language->get('heading_title');
		}
		// Reload the language as the individual payment loading will overwrite some data
		$data = array_merge($data, $this->load->language($extension_type . '/' . $classname));
		$data['help_total'] = 'help_total';

		foreach ($types as $code => $text) {

			$data['tabs'][] = array(
				'id'		=> 'tab_' . $code,
				'title'		=> $text
			);

			$data['fields'][] = array(
				'tab'			=> 'tab_' . $code,
				'entry'			=> $this->language->get('entry_total'),
				'type'			=> 'text',
				'name' 			=> 'total_' . $code,
				'value' 		=> (isset($this->request->post['total_' . $code])) ? $this->request->post['total_' . $code] : $this->config->get($classname . '_total_' . $code),
				'required'		=> false,
				'help'			=> ($data['help_total'] != 'help_total' ? $data['help_total'] : ''),
				'tooltip'		=> ($data['tooltip_total'] != 'tooltip_total' ? $data['tooltip_total'] : '')
			);

			$data['fields'][] = array(
				'tab'			=> 'tab_' . $code,
				'entry'			=> $this->language->get('entry_amount'),
				'type'			=> 'text',
				'name' 			=> 'amount_' . $code,
				'value' 		=> (isset($this->request->post['amount_' . $code])) ? $this->request->post['amount_' . $code] : $this->config->get($classname . '_amount_' . $code),
				'required'		=> false,
				'help'			=> ($this->language->get('help_amount') != 'help_amount' ? $this->language->get('help_amount') : ''),
				'tooltip'		=> ($this->language->get('tooltip_amount') != 'tooltip_amount' ? $this->language->get('tooltip_amount') : '')
			);

			$data['fields'][] = array(
				'tab'			=> 'tab_' . $code,
				'entry'			=> $this->language->get('entry_amount2'),
				'type'			=> 'text',
				'name' 			=> 'amount2_' . $code,
				'value' 		=> (isset($this->request->post['amount2_' . $code])) ? $this->request->post['amount2_' . $code] : $this->config->get($classname . '_amount2_' . $code),
				'required'		=> false,
				'help'			=> ($this->language->get('help_amount2') != 'help_amount2' ? $this->language->get('help_amount2') : ''),
				'tooltip'		=> ($this->language->get('tooltip_amount2') != 'tooltip_amount2' ? $this->language->get('tooltip_amount2') : '')
			);
		}

		/*
		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry'			=> $this->language->get('entry_total'),
			'type'			=> 'text',
			'name'			=> 'total',
			'value'			=> (isset($this->request->post['total'])) ? $this->request->post['total'] : $this->config->get($classname . '_total'),
			'required'		=> false,
			'help'			=> ($this->language->get('help_total') != 'help_total' ? $this->language->get('help_total') : ''),
			'tooltip'		=> ($this->language->get('tooltip_total') != 'tooltip_total' ? $this->language->get('tooltip_total') : '')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry'			=> $this->language->get('entry_amount'),
			'type'			=> 'text',
			'name'			=> 'amount',
			'value'			=> (isset($this->request->post['amount'])) ? $this->request->post['amount'] : $this->config->get($classname . '_amount'),
			'required'		=> false,
			'help'			=> ($this->language->get('help_amount') != 'help_amount' ? $this->language->get('help_amount') : ''),
			'tooltip'		=> ($this->language->get('tooltip_amount') != 'tooltip_amount' ? $this->language->get('tooltip_amount') : '')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry'			=> $this->language->get('entry_amount2'),
			'type'			=> 'text',
			'name'			=> 'amount2',
			'value'			=> (isset($this->request->post['amount2'])) ? $this->request->post['amount2'] : $this->config->get($classname . '_amount2'),
			'required'		=> false,
			'help'			=> ($this->language->get('help_amount2') != 'help_amount2' ? $this->language->get('help_amount2') : ''),
			'tooltip'		=> ($this->language->get('tooltip_amount2') != 'tooltip_amount2' ? $this->language->get('tooltip_amount2') : '')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry' 		=> $this->language->get('entry_types'),
			'type'			=> 'scrollbox',
			'name' 			=> 'types[]',
			'value' 		=> explode(',', (isset($this->request->post['types'])) ? $this->request->post['types'] : $this->config->get($classname . '_types')),
			'required' 		=> true,
			'options'		=> $types,
			'error'			=> (isset($this->error['allowed_typess'])) ? $this->error['allowed_typess'] : '',
			'help'			=> ($this->language->get('help_types') != 'help_types' ? $this->language->get('help_types') : ''),
			'tooltip'		=> ($this->language->get('tooltip_types') != 'tooltip_types' ? $this->language->get('tooltip_types') : '')
		);
		*/


		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry' 		=> $this->language->get('entry_tax_class'),
			'type'			=> 'select',
			'name' 			=> 'tax_class_id',
			'value' 		=> (isset($this->request->post['tax_class_id'])) ? $this->request->post['tax_class_id'] : $this->config->get($classname . '_tax_class_id'),
			'required' 		=> false,
			'options'		=> $tax_classes,
			'help'			=> ($this->language->get('help_tax_class') != 'help_tax_class' ? $this->language->get('help_tax_class') : ''),
			'tooltip'		=> ($this->language->get('tooltip_tax_class') != 'tooltip_tax_class' ? $this->language->get('tooltip_tax_class') : '')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry' 		=> $this->language->get('entry_geo_zone'),
			'type'			=> 'select',
			'name' 			=> 'geo_zone_id',
			'value' 		=> (isset($this->request->post['geo_zone_id'])) ? $this->request->post['geo_zone_id'] : $this->config->get($classname . '_geo_zone_id'),
			'required' 		=> false,
			'options'		=> $geo_zones,
			'help'			=> ($this->language->get('help_geo_zone') != 'help_geo_zone' ? $this->language->get('help_geo_zone') : ''),
			'tooltip'		=> ($this->language->get('tooltip_geo_zone') != 'tooltip_geo_zone' ? $this->language->get('tooltip_geo_zone') : '')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_general',
			'entry'			=> $this->language->get('entry_sort_order'),
			'type'			=> 'text',
			'name'			=> 'sort_order',
			'value'			=> (isset($this->request->post['sort_order'])) ? $this->request->post['sort_order'] : $this->config->get($classname . '_sort_order'),
			'required'		=> false,
			'help'			=> ($this->language->get('help_sort_order') != 'help_sort_order' ? $this->language->get('help_sort_order') : ''),
			'tooltip'		=> ($this->language->get('tooltip_sort_order') != 'tooltip_sort_order' ? $this->language->get('tooltip_sort_order') : '')
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_support',
			'entry'			=> 'Troubleshooting Info: ',
			'type'			=> 'label',
			'name'			=> 'troubleshooting',
			'value'			=> '',
			'help'			=> '',
			'tooltip'		=> ''
		);

		$data['fields'][] = array(
			'tab'			=> 'tab_support',
			'entry'			=> 'Support Info:',
			'type'			=> 'label',
			'name'			=> 'support',
			'value'			=> 'For support questions, contact me at qphoria@gmail.com or on skype: taqmobile',
			'help'			=> '',
			'tooltip'		=> ''
		);

?>