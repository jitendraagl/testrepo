<?php
/**
 * @extension-total	GOP_COD_Fee
 * @author-name		Michail Gkasios
 * @copyright		Copyright (C) 2013 GKASIOS
 * @license			GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

class ModelTotalGOPCODFEE extends Model
{
	public function getTotal(&$total_data, &$total, &$taxes)
	{
		if(isset($this->session->data['payment_method']['code']))
		{
			if($this->session->data['payment_method']['code'] == 'GOP_COD' && $this->session->data['payment_method']['order_total'] == true)
			{
				$title = $this->session->data['payment_method']['order_total_title'];
				if($title == null)
				{
					$this->language->load('total/GOP_COD_Fee');
					$title = $this->language->get('text_cod_fee');
				}

				$sort_order = $this->session->data['payment_method']['order_total_sort_order'];
				if($sort_order == null)
				{
					$sort_order = $this->config->get('GOP_COD_Fee_sort_order');
				}

				$total_data[] = array	(
											'code'			=>	'GOP_COD_Fee',
											'title'			=>	$title,
											'text'			=>	$this->currency->format($this->session->data['payment_method']['cost']),
											'value'			=>	$this->session->data['payment_method']['cost'],
											'sort_order'	=>	$sort_order
										);

				if($this->session->data['payment_method']['tax_class_id'])
				{
					$tax_rates = $this->tax->getRates($this->session->data['payment_method']['cost'], $this->session->data['payment_method']['tax_class_id']);

					foreach($tax_rates as $tax_rate)
					{
						if(!isset($taxes[$tax_rate['tax_rate_id']]))
						{
							$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
						}
						else
						{
							$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
						}
					}
				}

				$total += $this->session->data['payment_method']['cost'];
			}
		}
	}
}
?>