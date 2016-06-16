<?php
require DIR_SYSTEM . '../vendor/aws.phar';

class AmazonS3 {
    private $db;
    private $config;
    private $accessKey;
    private $secretKey;
    private $region;
    private $bucket;
    private $client;

    public function __construct($registry) {
        $this->db = $registry->get('db');
        $this->config = $registry->get('config');
        $this->accessKey = $this->config->get('amazon_s3_access_key');
        $this->secretKey = $this->config->get('amazon_s3_secret_key');
        $this->region = $this->config->get('amazon_s3_region');
        $this->bucket = $this->config->get('amazon_s3_bucket');
        $this->client = Aws\S3\S3Client::factory([
            'version' => 'latest',
            'region'  => $this->region,
            'key'     => $this->accessKey,
            'secret'  => $this->secretKey,
        ]);
    }

    public function getDownloadLink($file) {
        $result = $this->db->query("
            SELECT `filename_remote` FROM `" . DB_PREFIX . "amazon_s3_download`
            WHERE `filename_local` = '" . $this->db->escape($file) . "'")->row;
        if (!isset($result['filename_remote']) || empty($result['filename_remote'])) {
            return false;
        }

        $remoteFilename = $result['filename_remote'];
        return $this->client->getObjectUrl($this->bucket, 'download/' . $remoteFilename, '+30 seconds');
    }

    public function deleteFile($filename, $type) {
        $file = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));

        if ($type == 'image') {
            $this->db->query("
                DELETE FROM `" . DB_PREFIX . "amazon_s3_image`
                WHERE `filename` LIKE '" . $this->db->escape($file) . "%'
            ");

        } elseif ($type == 'download') {
            $this->db->query("
                DELETE FROM `" . DB_PREFIX . "amazon_s3_download`
                WHERE `filename_local` LIKE '" . $this->db->escape($file) . "%'
            ");
        }
    }

    public function upload($data, $type) {
        if (!$this->config->get('amazon_s3_status')) {
            $log = new Log('amazon_s3.log');
            $log->write('Amazon S3 module is disabled.');

            return false;
        }

        $bucketPath = $data['path'];

        if (!$this->accessKey || !$this->secretKey || !$this->bucket || !$bucketPath) {
            $log = new Log('amazon_s3.log');
            $log->write('Missing Amazon S3 setting(s).');

            return false;
        }

        $fileContents = $data['content'];

        $fileName = isset($data['name_remote']) ? $data['name_remote'] : $data['name'];

        $acl = '';

        if ($type == 'download') {
            if ($this->config->get('amazon_s3_cloudfront_status') == '1') {
                $acl = 'public-read';
            } else {
                $acl = 'authenticated-read';
            }
        } elseif ($type == 'image') {
            $acl = 'public-read';
        }

        $this->client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $bucketPath . $fileName,
            'Body' => $fileContents,
            'ACL' => $acl
        ]);

        if ($type == 'image') {
            $this->db->query("
                REPLACE INTO `" . DB_PREFIX . "amazon_s3_image` (`filename`)
                VALUES ('" . $this->db->escape($data['name']) . "')");
        } elseif ($type == 'download') {
            $this->db->query("
                REPLACE INTO `" . DB_PREFIX . "amazon_s3_download` (`filename_local`, `filename_remote`)
                VALUES ('" . $this->db->escape($data['name']) . "', '" . $this->db->escape($data['name_remote']) . "')");
        }

        return true;
    }

    public function fileExists($file) {
        return $this->db->query("
            SELECT SUM(`count`) AS 'count'
            FROM (
                SELECT COUNT(*) AS `count`
                FROM `" . DB_PREFIX . "amazon_s3_image`
                WHERE `filename` = '" . $this->db->escape($file) . "'

                UNION ALL

                SELECT COUNT(*)
                FROM `" . DB_PREFIX . "amazon_s3_download`
                WHERE `filename_local` = '" . $this->db->escape($file) . "'
            ) AS `counts`")->row['count'] == 1;
    }
}
