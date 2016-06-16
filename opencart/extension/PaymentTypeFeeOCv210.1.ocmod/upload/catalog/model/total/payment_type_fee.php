<?php
class ModelTotalPaymentTypeFee extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {

		$extension_type = 'total';
		$classname = str_replace('vq2-' . basename(DIR_APPLICATION) . '_' . strtolower(get_parent_class($this)) . '_' . $extension_type . '_', '', basename(__FILE__, '.php'));

		if ($this->config->get($classname . '_status') && $this->cart->getSubTotal()) {

			// Get Address Data (Model)
		    $address = array();
		    $address['country_id']	= 0;
			$address['zone_id'] 	= 0;
			if (isset($this->session->data['payment_address_id']) && $this->session->data['payment_address_id']) { // Normal 15x checkout
				$this->load->model('account/address');
				$address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
			} elseif (isset($this->session->data['payment_address']['address_id']) && $this->session->data['payment_address']['address_id']) { // Normal 20x checkout
				$this->load->model('account/address');
				$address = $this->model_account_address->getAddress($this->session->data['payment_address']['address_id']);
			} elseif (isset($this->session->data['payment_address']['address_id']) && $this->session->data['payment_address']['address_id']) { // Guest checkout
				$address = (isset($this->session->data['guest'])) ? $this->session->data['guest'] : array();
			}
			//

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get($classname . '_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$this->config->get($classname . '_geo_zone_id')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}

			// Only show if a payment has been selected
			if (!isset($this->session->data['payment_method'])) {
				$status = FALSE;
			}

		 	if (!$status) { return; }
		 	//

		 	if (!$total) { $total = $this->cart->getSubTotal(); }

			$this->load->model('localisation/currency');

			$payment_code = $this->session->data['payment_method']['code'];

			$payment_min_total = $this->config->get('payment_type_fee_total_' . $payment_code);

			if (is_null($payment_min_total)) {
				return;
			}

			$payment_amount = $this->config->get('payment_type_fee_amount_' . $payment_code);
			$payment_amount2 = $this->config->get('payment_type_fee_amount2_' . $payment_code);

			if (strpos($payment_amount,'%') !== false) {
				$fee = (trim($payment_amount,'%'))/100;
				$value = $total * $fee;
			} else {
				$value = $payment_amount;
			}

			if (strpos($payment_amount2,'%') !== false) {
				$fee = (trim($payment_amount2,'%'))/100;
				$value += $total * $fee;
			} else {
				$value += $payment_amount2;
			}

			$total_data[] = array(
				'code'		 => $classname,
        		'title'      => ($this->config->get($classname . '_title_' . $this->config->get('config_language_id')) ? $this->config->get($classname . '_title_' . $this->config->get('config_language_id')) : ucwords(str_replace(array('-','_','.'), " ", $classname))),
        		'text'       => $this->currency->format($value), // needed for v15x only
        		'value'      => $value,
				'sort_order' => $this->config->get($classname . '_sort_order')
			);

			if ($this->config->get($classname . '_tax_class_id')) {

				$tax_rates = $this->tax->getRates($value, $this->config->get($classname . '_tax_class_id'));

				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}


			$total += $value;
		}
	}
}
?>