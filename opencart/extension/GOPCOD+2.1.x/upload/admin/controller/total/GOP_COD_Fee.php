<?php
/**
 * @extension-total	GOP_COD_Fee
 * @author-name		Michail Gkasios
 * @copyright		Copyright (C) 2013 GKASIOS
 * @license			GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

class ControllerTotalGOPCODFEE extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->model('setting/setting');

		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$this->model_setting_setting->editSetting('GOP_COD_Fee', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		//Language Loading
		$data = array();
		$data += $this->language->load('total/GOP_COD_Fee');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array	(
											'text'	=>	$this->language->get('text_home'),
											'href'	=>	$this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
										);

		$data['breadcrumbs'][] = array	(
											'text'	=>	$this->language->get('text_total'),
											'href'	=>	$this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL')
										);

		$data['breadcrumbs'][] = array	(
											'text'	=>	$this->language->get('heading_title'),
											'href'	=>	$this->url->link('total/GOP_COD_Fee', 'token=' . $this->session->data['token'], 'SSL')
										);

		$data['small_logo'] = "view/image/payment/GKASIOS_Logo_Main_Animated.gif";
		$data['paypal_button_id'] ="TXJMRFUWHCFKG";

		$data['action'] = $this->url->link('total/GOP_COD_Fee', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if(isset($this->request->post['GOP_COD_Fee_status']))
		{
			$data['GOP_COD_Fee_status'] = $this->request->post['GOP_COD_Fee_status'];
		}
		else
		{
			$data['GOP_COD_Fee_status'] = $this->config->get('GOP_COD_Fee_status');
		}

		if(isset($this->request->post['GOP_COD_Fee_sort_order']))
		{
			$data['GOP_COD_Fee_sort_order'] = $this->request->post['GOP_COD_Fee_sort_order'];
		}
		else
		{
			$data['GOP_COD_Fee_sort_order'] = $this->config->get('GOP_COD_Fee_sort_order');
		}

		//Errors
		if(isset($this->error['GOP_COD_Fee_warning']))
		{
			$data['GOP_COD_Fee_warning_error'] = $this->error['GOP_COD_Fee_warning'];
		}
		else
		{
			$data['GOP_COD_Fee_warning_error'] = '';
		}

		if(isset($this->error['GOP_COD_Fee_sort_order']))
		{
			$data['GOP_COD_Fee_sort_order_error'] = $this->error['GOP_COD_Fee_sort_order'];
		}
		else
		{
			$data['GOP_COD_Fee_sort_order_error'] = '';
		}

		//-----------------------Render--------------------------

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/GOP_COD_Fee.tpl', $data));
	}

	private function validate()
	{
		$this->language->load('total/GOP_COD_Fee');

		if(!$this->user->hasPermission('modify', 'total/GOP_COD_Fee'))
		{
			$this->error['GOP_COD_Fee_warning'] = $this->language->get('error_permission');
		}

		if($this->request->post['GOP_COD_Fee_sort_order'] != '' && !is_numeric($this->request->post['GOP_COD_Fee_sort_order']))
		{
			$this->error['GOP_COD_Fee_sort_order'] = $this->language->get('error_sort_order');
		}

		return !$this->error;
	}
}
?>