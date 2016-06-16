<?php
class ControllerModuleAmazonS3 extends Controller {
    private $error = array();

    private $settings = array(
        'amazon_s3_access_key',
        'amazon_s3_secret_key',
        'amazon_s3_bucket',
        'amazon_s3_region',
        'amazon_s3_bucket_path',
        'amazon_s3_http_cache_control',
        'amazon_s3_http_expires',
        'amazon_s3_status',
        'amazon_s3_download_status',
        'amazon_s3_cloudfront_status',
        'amazon_s3_cloudfront_domain',
        'amazon_s3_cloudfront_key_id',
        'amazon_s3_cloudfront_key_path',
        'amazon_s3_cloudfront_custom_domain',
    );

    public function index() {
        $data = array_merge(array(), $this->language->load('module/amazons3'));

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->request->post['amazon_s3_bucket_path'] = trim($this->request->post['amazon_s3_bucket_path'], '/');

            if (empty($this->request->post['amazon_s3_bucket_path'])) {
                $this->request->post['amazon_s3_bucket_path'] = '/';
            } else {
                $this->request->post['amazon_s3_bucket_path'] = '/' . $this->request->post['amazon_s3_bucket_path'] . '/';
            }

            $filterSettings = array(
                'amazon_s3_access_key',
                'amazon_s3_secret_key',
                'amazon_s3_bucket',
                'amazon_s3_region',
                'amazon_s3_cloudfront_domain',
                'amazon_s3_cloudfront_key_id',
                'amazon_s3_cloudfront_custom_domain',
            );

            foreach ($filterSettings as $key) {
                $this->request->post[$key] = trim($this->request->post[$key]);
            }

            $this->model_setting_setting->editSetting('amazon_s3', $this->request->post);

            $this->session->data['success'] = $this->language->get('success_text');

            // Clears the cache
            $this->db->query("TRUNCATE `" . DB_PREFIX . "amazon_s3_image`");
            $this->db->query("TRUNCATE `" . DB_PREFIX . "amazon_s3_download`");

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['errors'] = $this->error;

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('module_text'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/amazons3', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('module/amazons3', 'token=' . $this->session->data['token'], 'SSL');

        foreach ($this->settings as $setting) {
            if (isset($this->request->post[$setting])) {
                $data[$setting] = $this->request->post[$setting];
            } else {
                $data[$setting] = $this->config->get($setting);
            }
        }

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/amazons3.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/amazons3')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->request->post['amazon_s3_cloudfront_status']) {
            if (!empty($this->request->post['amazon_s3_cloudfront_key_path']) &&
                    !file_exists($this->request->post['amazon_s3_cloudfront_key_path'])) {
                $this->error['file'] = $this->language->get('error_key_not_found');
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function install() {
        $this->db->query("
            CREATE TABLE `" . DB_PREFIX . "amazon_s3_image` (
                `amazon_s3_image_id` int(11) NOT NULL AUTO_INCREMENT,
                `filename` varchar(255) COLLATE utf8_bin NOT NULL,
            PRIMARY KEY (`amazon_s3_image_id`)) COLLATE=utf8_bin;");

        $this->db->query("
            CREATE TABLE `" . DB_PREFIX . "amazon_s3_download` (
                `amazon_s3_download_id` int(11) NOT NULL AUTO_INCREMENT,
                `filename_local` varchar(255) COLLATE utf8_bin NOT NULL,
                `filename_remote` varchar(255) COLLATE utf8_bin NOT NULL,
            PRIMARY KEY (`amazon_s3_download_id`)) COLLATE=utf8_bin;");
    }

    public function uninstall() {
        $this->load->model("setting/setting");

        $this->db->query("DROP TABLE `" . DB_PREFIX . "amazon_s3_image`");
        $this->db->query("DROP TABLE `" . DB_PREFIX . "amazon_s3_download`");

        $this->model_setting_setting->deleteSetting('amazon_s3');
    }

    public function getUnuploaded() {
        $data = array_merge(array(), $this->language->load('module/amazons3'));

        $data['downloads'] = $this->db->query("
            SELECT f.filename, f.name
            FROM (
                SELECT d.filename, dd.`name`
                FROM " . DB_PREFIX . "download d
                JOIN " . DB_PREFIX . "download_description dd ON d.download_id = dd.download_id AND dd.language_id = " . (int) $this->config->get('config_language_id') . "
            ) AS f
            LEFT JOIN " . DB_PREFIX . "amazon_s3_download d ON d.filename_local = f.filename
            WHERE d.filename_remote IS NULL")->rows;

        $data['token'] = $this->session->data['token'];

        $this->response->setOutput($this->load->view('module/amazons3_downloads.tpl', $data));
    }

    public function uploadFile() {
        $json = array();

        $status = true;

        if ($this->config->get('amazon_s3_status') && $this->config->get('amazon_s3_download_status') && file_exists(DIR_DOWNLOAD . $this->request->get['file'])) {
            $nameParts = explode('.', $this->request->get['file']);
            $filename = implode('.', array_slice($nameParts, 0, count($nameParts) - 1));

            $data = array(
                'path' => $this->config->get('amazon_s3_bucket_path') . 'download/',
                'bucket' => $this->config->get('amazon_s3_bucket'),
                'name' => $this->request->get['file'],
                'content' => file_get_contents(DIR_DOWNLOAD . $this->request->get['file']),
                'mime' => 'application/octet-stream',
                'name_remote' => sha1(uniqid(mt_rand(), true)) . '-' . $filename,
            );

            if (!$this->amazons3->upload($data, 'download')) {
                $log = new Log('amazon_s3.log');
                $log->write("Could not upload file " . $filename . " to S3 from the upload tool");
                $status = false;
            }

        } else {
            $status = false;
        }

        if ($status) {
            $json['status'] = 'success';
        } else {
            $json['status'] = 'error';
        }

        $this->response->setOutput(json_encode($json));
    }

}
