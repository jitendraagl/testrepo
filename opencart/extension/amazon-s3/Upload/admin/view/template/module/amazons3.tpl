<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pp-login" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php } ?>
      <div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-amazons3" class="form-horizontal">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-settings" data-toggle="tab"><?php echo $settings_tab; ?></a></li>
              <li><a href="#tab-upload" data-toggle="tab"><?php echo $upload_tab; ?></a></li>
              <li><a href="#tab-cloudfront" data-toggle="tab"><?php echo $cloudfront_tab; ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-settings">
                    <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $cache_clear_help; ?></div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-amazon_s3_access_key"><?php echo $access_key_text; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="amazon_s3_access_key" value="<?php echo $amazon_s3_access_key; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-amazon_s3_secret_key"><?php echo $secret_key_text; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="amazon_s3_secret_key" value="<?php echo $amazon_s3_secret_key; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-amazon_s3_bucket"><?php echo $bucket_text; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="amazon_s3_bucket" value="<?php echo $amazon_s3_bucket; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="amazon_s3_region"><?php echo $region_text; ?></label>
                        <div class="col-sm-10">
                            <select name="amazon_s3_region" class="form-control" id="amazon_s3_region">
                                <option value="us-east-1">us-east-1 (US Standard)</option>
                                <option value="us-west-2">us-west-2 (Oregon)</option>
                                <option value="us-west-1">us-west-1 (N. California )</option>
                                <option value="eu-west-1">eu-west-1 (Ireland)</option>
                                <option value="eu-central-1">eu-central-1 (Frankfurt)</option>
                                <option value="ap-southeast-1">ap-southeast-1 (Singapore)</option>
                                <option value="ap-southeast-2">ap-southeast-2 (Sydney)</option>
                                <option value="ap-northeast-1">ap-northeast-1 (Tokyo)</option>
                                <option value="sa-east-1">sa-east-1 (Sao Paulo)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-amazon_s3_bucket_path"><span data-toggle="tooltip" title="<?php echo $bucket_path_help_text; ?>"><?php echo $bucket_path_text; ?></span></label>
                        <div class="col-sm-10">
                            <input type="text" name="amazon_s3_bucket_path" value="<?php echo $amazon_s3_bucket_path; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-amazon_s3_status"><?php echo $status_text; ?></label>
                      <div class="col-sm-10">
                        <select name="amazon_s3_status" id="input-amazon_s3_status" class="form-control">
                          <?php if ($amazon_s3_status) { ?>
                          <option value="1" selected="selected"><?php echo $enabled_text; ?></option>
                          <option value="0"><?php echo $disabled_text; ?></option>
                          <?php } else { ?>
                          <option value="1"><?php echo $enabled_text; ?></option>
                          <option value="0" selected="selected"><?php echo $disabled_text; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $download_status_help; ?>"><?php echo $download_status_text; ?></span></label>
                      <div class="col-sm-10">
                        <select name="amazon_s3_download_status" id="input-amazon_s3_download_status" class="form-control">
                            <?php if ($amazon_s3_download_status == 1) { ?>
                                <option value="1" selected="selected"><?php echo $yes_text; ?></option>
                                <option value="0"><?php echo $no_text; ?></option>
                            <?php } else { ?>
                                <option value="1"><?php echo $yes_text; ?></option>
                                <option value="0" selected="selected"><?php echo $no_text; ?></option>
                            <?php } ?>
                        </select>
                      </div>
                    </div>
                    <fieldset>
                      <legend><?php echo $http_settings_text; ?></legend>
                    </fieldset>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $cache_control_text; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="amazon_s3_http_cache_control" value="<?php echo $amazon_s3_http_cache_control; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $expires_text; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="amazon_s3_http_expires" value="<?php echo $amazon_s3_http_expires; ?>" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-upload">
                    <div class="alert"><?php echo $upload_tool_help; ?></div>
                    <div class="alert">
                        <?php echo $get_not_uploaded_text; ?>
                        <button id="load-unuploaded" type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-download"></i> <?php echo $load_text; ?></button>
                    </div>
                    <div id="downloads"></div>
                </div>
                <div class="tab-pane" id="tab-cloudfront">
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo $cloudfront_enabled_text; ?></label>
                      <div class="col-sm-10">
                        <select name="amazon_s3_cloudfront_status" id="input-amazon_s3_cloudfront_status" class="form-control">
                            <?php if ($amazon_s3_cloudfront_status == 1) { ?>
                                <option value="1" selected="selected"><?php echo $yes_text; ?></option>
                                <option value="0"><?php echo $no_text; ?></option>
                            <?php } else { ?>
                                <option value="1"><?php echo $yes_text; ?></option>
                                <option value="0" selected="selected"><?php echo $no_text; ?></option>
                            <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo $cloudfront_key_pair_id_text; ?></label>
                      <div class="col-sm-10">
                        <input name="amazon_s3_cloudfront_key_id" value="<?php echo $amazon_s3_cloudfront_key_id ?>" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $cloudfront_private_key_path_help; ?>"><?php echo $cloudfront_private_key_path_text; ?></span></label>
                        <div class="col-sm-10">
                            <input name="amazon_s3_cloudfront_key_path" value="<?php echo $amazon_s3_cloudfront_key_path ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $cloudfront_domain_help; ?>"><?php echo $cloudfront_domain_text; ?></span></label>
                        <div class="col-sm-10">
                            <input name="amazon_s3_cloudfront_domain" value="<?php echo $amazon_s3_cloudfront_domain ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $cloudfront_custom_domain_help; ?>"><?php echo $cloudfront_custom_domain_text; ?></span></label>
                        <div class="col-sm-10">
                            <input name="amazon_s3_cloudfront_custom_domain" value="<?php echo $amazon_s3_cloudfront_custom_domain ?>" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#load-unuploaded').click(function() {
    $('.loading').remove();
    $('#downloads').html('');
    $('#load-unuploaded').after(' <i class="fa fa-circle-o-notch fa-spin loading"></i>');

    $.ajax({
        url: 'index.php?route=module/amazons3/getUnuploaded&token=<?php echo $token; ?>',
        dataType: 'text',
        success: function(htmlResponse) {
            $('#downloads').html(htmlResponse);

            $('.loading').remove();
        }
    });
});

$('#amazon_s3_region').val("<?php echo $amazon_s3_region; ?>");
//--></script>
<?php echo $footer; ?>