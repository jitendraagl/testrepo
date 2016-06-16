<?php
/**
 * @extension-payment	GOP_COD
 * @author-name			Michail Gkasios
 * @copyright			Copyright (C) 2013 GKASIOS
 * @license				GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

class ControllerPaymentGOPCOD extends Controller
{
	public function index()
	{
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['continue'] = $this->url->link('checkout/success');

		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/GOP_COD.tpl'))
		{
			return $this->load->view($this->config->get('config_template') . '/template/payment/GOP_COD.tpl', $data);
		}
		else
		{
			return $this->load->view('default/template/payment/GOP_COD.tpl', $data);
		}
	}

	public function confirm()
	{
		if($this->session->data['payment_method']['code'] == 'GOP_COD')
		{
			$this->load->model('checkout/order');
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->session->data['payment_method']['order_status_id']);
		}
	}
}
?>