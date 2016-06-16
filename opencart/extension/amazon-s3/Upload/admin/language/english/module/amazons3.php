<?php

$_['heading_title'] = 'Amazon S3';

$_['settings_tab'] = 'Settings';
$_['upload_tab'] = 'Upload tool';
$_['cloudfront_tab'] = 'Cloudfront';

// Settings

$_['http_settings_text'] = 'HTTP Settings';
$_['cache_control_text'] = 'Cache-Control';
$_['cache_control_help'] = 'E.g. public, max-age=432000';
$_['expires_text'] = 'Expires';
$_['module_text'] = 'Module';
$_['access_key_text'] = 'AWS Access Key';
$_['secret_key_text'] = 'Secret Key';
$_['bucket_text'] = "Bucket's name";
$_['region_text'] = "Region";
$_['bucket_path_text'] = 'Path on the bucket';
$_['bucket_path_help_text'] = 'Must be writable! Example: /image/folder/here/';
$_['enabled_text'] = 'Enabled';
$_['disabled_text'] = 'Disabled';
$_['yes_text'] = 'Yes';
$_['no_text'] = 'No';
$_['status_text'] = 'Status';
$_['download_status_text'] = 'Store product downloads on S3';
$_['download_status_help'] = 'Uploading large files to S3 might take a lot of time';
$_['get_not_uploaded_text'] = 'Load all Downloads which are not uploaded to S3';
$_['load_text'] = 'Load';

// Upload Tool

$_['cache_clear_help'] = "Each time you save module's settings, the cache is cleared!";
$_['upload_tool_help'] = 'Use this upload tool to upload all your Downloads to S3';

$_['filename_text'] = "Local Filename";
$_['name_text'] = "Download's name";
$_['status_text'] = "Status";
$_['upload_selected_text'] = "Upload selected";
$_['no_downloads_text'] = "There are no product downloads to show";

// Cloudfront

$_['cloudfront_enabled_text'] = 'Use Cloudfront';
$_['yes_text'] = 'Yes';
$_['no_text'] = 'No';
$_['cloudfront_domain_text'] = 'Cloudfront Domain';
$_['cloudfront_domain_help'] = 'Example: d111111abcdef8';
$_['cloudfront_private_key_path_text'] = "Path to Cloudfront Key Pair's private key";
$_['cloudfront_private_key_path_help'] = "Example: /home/user/key.pem";
$_['cloudfront_key_pair_id_text'] = "Key Pair ID";
$_['cloudfront_custom_domain_text'] = 'Use a custom domain to serve the content';
$_['cloudfront_custom_domain_help'] = 'CloudFront does not support HTTPS with custom domains!';

$_['success_text'] = "Amazon S3 module's settings were successfully saved!";
$_['error_permission'] = 'Warning: You do not have permission to modify the Amazon S3 module!';
$_['error_key_not_found'] = "Could not find CloudFront's Private Key. Make sure you provided a correct path to it.";