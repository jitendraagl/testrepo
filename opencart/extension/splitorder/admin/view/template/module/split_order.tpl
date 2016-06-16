<?php
/*------------------------------------------------------------------------
# Split Order
# ------------------------------------------------------------------------
# The Krotek
# Copyright (C) 2011-2015 thekrotek.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website: http://thekrotek.com
# Support: support@thekrotek.com
-------------------------------------------------------------------------*/
?>	
<?php echo $header;?>
<link rel="stylesheet" type="text/css" href="<?php echo (defined('JPATH_ADMINISTRATOR') ? 'admin/' : ''); ?>view/stylesheet/<?php echo $stylesheet; ?>.css" />

<?php if (version_compare(VERSION, '2.0', '>=')) { ?>
	<?php echo $column_left; ?>
<?php } ?>
		
<div id="content" class="<?php echo str_replace('_', '-', $extension); echo (version_compare(VERSION, '2.0', '<') ? ' opencart15' : ''); ?>">
	
<?php if (version_compare(VERSION, '2.0', '<')) { ?>

<!-- Generic OpenCart 1.5 template -->

	<div class="breadcrumb">
    	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
    		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    	<?php } ?>
  	</div>
	<?php if ($errors) { ?>
		<?php foreach ($errors as $error) { ?>
			<div class="warning"><?php echo $error; ?></div>
		<?php } ?>
	<?php } elseif ($success) { ?>
		<div class="success"><?php echo $success; ?></div>
	<?php } ?>
  	<div class="box">
    	<div class="heading">
      		<h1><img src="view/image/<?php echo $type; ?>.png" alt="" /> <?php echo $heading_title; ?></h1>
      		<div class="buttons">
      			<a onclick="$('#apply').attr('value', '0'); $('#form').submit();" class="button"><?php echo $button_save; ?></a>
      			<a onclick="$('#apply').attr('value', '1'); $('#form').submit();" class="button"><?php echo $button_apply; ?></a>
      			<a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      		</div>
    	</div>
    	<div class="content">
    		<div class="update"><?php echo $version ?></div>
      		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      			<input type="hidden" name="apply" id="apply" value="0">
				<table class="form">
      				      			
        			<?php foreach ($options as $key => $type) { ?>
        				<?php if ($type == 'title') { ?>
        					<tr>
              					<td colspan="2"><h2><?php echo ${$extension.'_'.$key}; ?></h2></td>
              				</tr>
	          	  		<?php } else { ?>
        					<tr>
              					<td>
              						<?php echo ${'entry_'.$key}; ?>
            						<?php if (${'help_'.$key}) { ?>
            							<span class="help"><?php echo ${'help_'.$key}; ?></span>
            						<?php } ?>              				
	              				</td>
              					<td class="<?php echo $extension.'-'.str_replace('_', '-', $key); ?>">        					
									<?php if ($type == 'text') { ?>
										<span id="input-<?php echo str_replace('_', '-', $key); ?>" class="input-text">
											<?php echo ${$extension.'_'.$key}; ?>
										</span>
            						<?php } elseif (($type == 'input') || ($type == 'multi-input')) { ?>
										<?php if ($type == 'multi-input') { ?>
											<?php foreach ($languages as $language) { ?>
												<input type="text" name="<?php echo $extension; ?>_<?php echo $key; ?>[<?php echo $language['language_id']; ?>]" value="<?php echo (isset(${$extension.'_'.$key}[$language['language_id']]) ? ${$extension.'_'.$key}[$language['language_id']] : ''); ?>" />
              									<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              									<?php if (isset($error_name[$language['language_id']])) { ?>
              										<span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
              									<?php } ?>
											<?php } ?>
										<?php } else { ?>
	          	  							<input type="text" name="<?php echo $extension; ?>_<?php echo $key; ?>" value="<?php echo ${$extension.'_'.$key}; ?>" />
	          	  						<?php } ?>
	          	  					<?php } elseif ($type == 'textarea') { ?>
	          	  						<textarea name="<?php echo $extension; ?>_<?php echo $key; ?>"><?php echo ${$extension.'_'.$key}; ?></textarea>
									<?php } elseif ($type == 'select') { ?>
            							<select name="<?php echo $extension; ?>_<?php echo $key; ?>">
                							<?php foreach (${$key} as $item) { ?>
               									<option value="<?php echo $item[0]; ?>"<?php echo ($item[0] == ${$extension.'_'.$key} ? ' selected="selected"' : ''); ?>><?php echo $item[1]; ?></option>
                							<?php } ?>
                						</select>
									<?php } elseif ($type == 'checkbox') { ?>
              							<div class="scrollbox">
                  							<?php
                  							$class = 'odd';

                  							foreach (${$key} as $item) {
                  								$class = ($class == 'even' ? 'odd' : 'even'); ?>
                  								<div class="<?php echo $class; ?>">
	                   								<input type="checkbox" name="<?php echo $extension; ?>_<?php echo $key; ?>[]" value="<?php echo $item[0]; ?>"<?php echo (in_array($item[0], ${$extension.'_'.$key}) ? ' checked="checked"' : ''); ?> />
    	                							<?php echo $item[1]; ?>
        	          							</div>
            		     					<?php } ?>
                						</div>
                						<div class="checkbox-select">
                							<a onclick="$(this).parent().parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                						</div>
									<?php } elseif ($type == 'radio') { ?>
                						<input type="radio" name="<?php echo $extension.'_'.$key; ?>" value="1"<?php echo (${$extension.'_'.$key} ? ' checked="checked"' : ''); ?> /><?php echo $text_yes; ?>									
                						<input type="radio" name="<?php echo $extension.'_'.$key; ?>" value=""<?php echo (!${$extension.'_'.$key} ? ' checked="checked"' : ''); ?> /><?php echo $text_no; ?>									
									<?php } ?>
                				</td>
            				</tr>
     	  				<?php } ?>
     	  			<?php } ?>

				</table>																											
    		</form>
   			<div class="copyright">Get more OpenCart extensions from The Krotek for lower price on <a href="http://thekrotek.com" title="Visit The Krotek site">The Krotek site</a>!</div>
  		</div>
	</div>

<!-- Generic OpenCart 1.5 template -->

<?php } else { ?>

<!-- Generic OpenCart 2.0 template -->

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-<?php echo str_replace('_', '-', $extension); ?>" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<button onclick="$('#apply').attr('value', '1'); $('#form').submit();" form="form-<?php echo str_replace('_', '-', $extension); ?>" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-success"><i class="fa fa-check"></i></button>	
        		<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
    		</div>
      		<h1><?php echo $heading_title; ?></h1>
      		<ul class="breadcrumb">
        		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
        			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        		<?php } ?>
      		</ul>
    	</div>
  	</div>
	<div class="container-fluid">
		<?php if ($errors) { ?>
			<?php foreach ($errors as $error) { ?>
				<div class="alert alert-danger">
    				<i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
      				<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>
			<?php } ?>
		<?php } elseif ($success) { ?>
			<div class="alert alert-success">
    			<i class="fa fa-check-circle"></i> <?php echo $success; ?>
      			<button type="button" class="close" data-dismiss="alert">&times;</button>			
			</div>
		<?php } ?>    			
    	<div class="panel panel-default">
      		<div class="panel-heading">
        		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        		<div class="pull-right"><?php echo $version; ?></div>
      		</div>
      		<div class="panel-body">
        		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-<?php echo str_replace('_', '-', $extension); ?>" class="form-horizontal">
        			<input type="hidden" name="apply" id="apply" value="0">
      									      			
        			<?php foreach ($options as $key => $type) { ?>
        				<?php if ($type == 'title') { ?>
	          	  			<h2><?php echo ${$extension.'_'.$key}; ?></h2>
	          	  		<?php } else { ?>
          					<div class="form-group <?php echo $extension.'-'.str_replace('_', '-', $key); ?>">
            					<label class="col-sm-2 control-label" for="input-<?php echo str_replace('_', '-', $key); ?>">
            						<?php if (${'help_'.$key}) { ?>
            							<span data-toggle="tooltip" title="<?php echo ${'help_'.$key}; ?>">
            						<?php } ?>
            						<?php echo ${'entry_'.$key}; ?>
            						<?php if (${'help_'.$key}) { ?>
            							</span>
            						<?php } ?>
            					</label>
								<div class="col-sm-10">
									<?php if ($type == 'text') { ?>
										<span id="input-<?php echo str_replace('_', '-', $key); ?>" class="input-text">
											<?php echo ${$extension.'_'.$key}; ?>
										</span>
            						<?php } elseif (($type == 'input') || ($type == 'multi-input')) { ?>
            							<?php if ($type == 'multi-input') { ?>
              								<?php foreach ($languages as $language) { ?>
              									<div class="input-group">
              										<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                									<input type="text" name="<?php echo $extension.'_'.$key; ?>[<?php echo $language['language_id']; ?>]" value="<?php echo (isset(${$extension.'_'.$key}[$language['language_id']]) ? ${$extension.'_'.$key}[$language['language_id']] : ''); ?>" placeholder="<?php echo ${'entry_'.$key}; ?>" id="input-<?php echo str_replace('_', '-', $key); ?>" class="form-control" />
              									</div>
              									<?php if (isset($error_name[$language['language_id']])) { ?>
              										<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              									<?php } ?>
              								<?php } ?>
              							<?php } else {?>
            								<input type="text" name="<?php echo $extension.'_'.$key; ?>" value="<?php echo ${$extension.'_'.$key}; ?>" placeholder="<?php echo ${'entry_'.$key}; ?>" id="input-<?php echo str_replace('_', '-', $key); ?>" class="form-control" />
            							<?php } ?>
            						<?php } elseif ($type == 'textarea') { ?>
	          	  						<textarea name="<?php echo $extension; ?>_<?php echo $key; ?>" placeholder="<?php echo ${'entry_'.$key}; ?>" id="input-<?php echo str_replace('_', '-', $key); ?>" class="form-control"><?php echo ${$extension.'_'.$key}; ?></textarea>
            						<?php } elseif ($type == 'select') { ?>
              							<select name="<?php echo $extension.'_'.$key; ?>" id="input-<?php echo str_replace('_', '-', $key); ?>" class="form-control">
                							<?php foreach (${$key} as $item) { ?>
               									<option value="<?php echo $item[0]; ?>"<?php echo ($item[0] == ${$extension.'_'.$key} ? ' selected="selected"' : ''); ?>><?php echo $item[1]; ?></option>
                							<?php } ?>
              							</select>
              						<?php } elseif ($type == 'checkbox') { ?>
              							<div class="well well-sm" style="height: 100px; overflow: auto;">
              								<?php foreach (${$key} as $item) { ?>
                								<div class="checkbox">
                  									<label>
                   										<input type="checkbox" name="<?php echo $extension.'_'.$key; ?>[]" value="<?php echo $item[0]; ?>"<?php echo (in_array($item[0], ${$extension.'_'.$key}) ? ' checked="checked"' : ''); ?> /> <?php echo $item[1]; ?>
                  									</label>
                								</div>
                							<?php } ?>
                						</div>
                						<div class="checkbox-select">
											<a onclick="$(this).parent().parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all;?></a>
										</div>
                					<?php } elseif ($type == 'radio') { ?>
             							<label class="radio-inline">
                							<input type="radio" name="<?php echo $extension.'_'.$key; ?>" value="1"<?php echo (${$extension.'_'.$key} ? ' checked="checked"' : ''); ?> /><?php echo $text_yes; ?>
                						</label>
	                					<label class="radio-inline">
                							<input type="radio" name="<?php echo $extension.'_'.$key; ?>" value=""<?php echo (!${$extension.'_'.$key} ? ' checked="checked"' : ''); ?> /><?php echo $text_no; ?>
										</label>
              	  					<?php } ?>
								</div>
            				</div>
            			<?php } ?>
            		<?php } ?>
					
            	</form>
				<div class="copyright">Get more OpenCart extensions from The Krotek for lower price on <a href="http://thekrotek.com" title="Visit The Krotek site">The Krotek site</a>!</div>            		
          	</div>
      	</div>
    </div>

<!-- Generic OpenCart 2.0 template -->
					
<?php } ?>
	
</div>
	
<?php echo $footer; ?>