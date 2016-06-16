<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-weight" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product-based-shipping" class="form-horizontal">
      <div class="form-group">
            <label class="col-sm-2 control-label" for="product_shipping_all_products"><?php echo $entry_all_prod; ?></label>
            <div class="col-sm-10"><select class="form-control" name="product_shipping_all_products" id="product_shipping_all_products">
              <?php if ($product_shipping_all_products == "1") { ?>
              <option value="1" selected="selected"><?php echo $entry_all_yes; ?></option>
               <option value="0" ><?php echo $entry_all_no; ?></option>
              <?php } else { ?>
               <option value="1" ><?php echo $entry_all_yes; ?></option>
              <option value="0" selected="selected"><?php echo $entry_all_no; ?></option>
              <?php } ?>
            </select></div>
       </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="product_shipping_tax_class_id"><?php echo $entry_tax; ?></label>
            <div class="col-sm-10"><select class="form-control" name="product_shipping_tax_class_id" id="product_shipping_tax_class_id">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $product_shipping_tax_class_id) { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></div>
       </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="product_shipping_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10"><select class="form-control" id="product_shipping_geo_zone_id" name="product_shipping_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $product_shipping_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></div>
       </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="product_shipping_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10"><select class="form-control" id="product_shipping_status" name="product_shipping_status">
              <?php if ($product_shipping_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></div>
       </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="product_shipping_sort_order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10"><input class="form-control"  type="text" id="product_shipping_sort_order" name="product_shipping_sort_order" value="<?php echo $product_shipping_sort_order; ?>" size="1" /></div>
       </div>
    </form>
	</div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 