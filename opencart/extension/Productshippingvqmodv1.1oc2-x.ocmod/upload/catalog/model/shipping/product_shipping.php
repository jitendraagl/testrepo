<?php
class ModelShippingProductShipping extends Model {
	function getQuote($address) {
		$this->load->language('shipping/product_shipping');
		
		if ($this->config->get('product_shipping_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('product_shipping_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if (!$this->config->get('product_shipping_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
        		$status = TRUE;
      		} else {
        		$status = FALSE;
      		}
		} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {
			$quote_data = array();
			$shipp_cost = 0;
			
			// getting shipping cost for each product in cart
			foreach ($this->cart->getProducts() as $result) {
			
				$prodShipping = $this->db->query("select shipping_price from ". DB_PREFIX."product where product_id = " . $result['product_id']);		//Bug Fix By Jason Anderson, jasonma84@yahoo.com
				$shipp_cost = $shipp_cost + (double)$prodShipping->row['shipping_price'] * $result['quantity'];

			}
			
			if($this->config->get('product_shipping_all_products') == 0 && $shipp_cost <= 0) {		//if shipping cost is zero and Option For All products is not selected, then sending empty data result
				return $method_data;
			}
			
			
      		$quote_data['product_shipping'] = array(
        		'code'           => 'product_shipping.product_shipping',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $shipp_cost,
         		'tax_class_id' => $this->config->get('product_shipping_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($shipp_cost, $this->config->get('product_shipping_tax_class_id'), $this->config->get('config_tax')))
      		);

      		$method_data = array(
        		'code'         => 'product_shipping',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('product_shipping_sort_order'),
        		'error'      => FALSE
      		);
		}
	
		return $method_data;
	}
}
