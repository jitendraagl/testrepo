<?php   echo $header; ?><?php echo $column_left; ?>
	<div id="content">
		<div class="page-header">
			<div class="container-fluid">
				<div class="pull-right">
					<button type="submit" form="form-size" data-toggle="tooltip" title="Update" class="btn btn-primary"><i class="fa fa-save"></i></button>
					<a href="?route=module/size_chart&token=<?php echo $_GET['token']; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
			<?php if (isset($error_warning) && $error_warning != '') { ?>
				<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>
			<?php } ?>
			<?php if (isset($success)) { ?>
				<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i>Edit Template</h3>
				 </div>
				<div class="panel-body">
					<form action="<?php echo $update_action;?>" method="post" enctype="multipart/form-data" id="form-size" class="form-horizontal">
						<div class="form-group">
							<div class="col-sm-10" style = "width:100%">
								<table id = 'tbl1' class="table table-bordered">
									<tr>
										<td width="200" align="right">Template Name :</td>
										<td>
											<input class="form-control" type = "text" name="templatename" value="<?php echo $size_chart['templatename'];?>" />
											<input class="form-control" type="hidden" value="<?php echo $size_chart['template_id'];?>" name="template_id" />
										</td>
									</tr>
									<tr>
										<td width="200" align="right">Note :</td>
										<td><textarea class="form-control" name="template_content" ><?php echo $size_chart['content'];?></textarea></td>
									</tr>
								</table>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-product" style="text-align:right"><span data-toggle="tooltip" title="(Autocomplete)">Products</span></label>
									<div class="col-sm-10">
										<input type="text" name="product" value="" placeholder="Products" id="input-product" class="form-control" />
										<div id="size_chart-product" class="well well-sm" style="height: 150px; overflow: auto;">
											<?php foreach ($products as $product) { ?>
												<div id="size_chart-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
													<input type="hidden" value="<?php echo $product['product_id']; ?>" />
												</div>
											<?php } ?>
										</div>
										<input type="hidden" name="size_chart_product" value="<?php echo $size_chart_product; ?>" class="form-control" />
									</div>
								</div>
								 <!----------- Category ---------------->
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
										<div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
											<?php foreach ($product_categories as $product_category) { ?>
												<div id="product-category<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
													<input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								  <!----------- Category Ends ---------------->
								  	<div class="form-group">  
									<table id = 'tbl1' class="table table-bordered">	
										<tbody id="module-row">
											<tr id = "row1">
												<?php for($i=0;$i<count($fields);$i++){?>
												 <td class="left"><input class="form-control" type="text" name="data[1][<?php echo $i; ?>]" value="<?php echo $fields[$i]; ?>" placeholder="Heading<?php echo $i+1; ?>"></td>
												<?php	}
												?>	
													<td align='center' style='font-size:14px; color:#777'>Action</td>	
											</tr>
											<?php $i=2; foreach($template_data as $values) { $j=0;?>
												<tr id="row<?php echo $i;?>" >
												<?php foreach($values as $val) { ?>
													<td class="left"><input class="form-control" type="text" value="<?php echo $val; ?>" name="data[<?php echo $i; ?>][<?php echo $j; ?>]" /></td>
													<?php $j++; } ?>
													<td align="center"><button type = "button" data-toggle = "tooltip" onclick = "removerow('<?php echo $i; ?>');" data-toggle = "tooltip" title = "remove" class = "btn btn-danger" ><i class = 'fa fa-minus-circle'></i></button></td></tr>
													<?php	$i++; } ?>
											<tr id="last-tr">
													<td colspan="<?php echo count($fields);?>"><input type = "hidden" id = "counter" value = "<?php echo $i;?>"></td>
													<td align="center"><button type="button" onclick="addrows();" data-toggle="tooltip" title="Add Row" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
											</tr>   
										</tbody>
									</table>
								</div>
							<table id = 'tab_images' class="table  table-bordered"> 
								<thead>
										<tr>
											<th class='left'>Images</th>
											<th class='left'>Width</th>
											<th class='left'>Height</th>
											<th class='left'>Title</th>
											<th align='center'>Action</th>
										</tr>
									</thead>
								<tbody id="module-row_images">
									<?php if(count($size_chart_images)){?>
									<?php foreach($size_chart_images as $key => $value){ ?>
									<tr id="rowimage<?php echo $key;?>">
										<td class='left'><a href="" id="thumb-image<?php echo $key;?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $value['image']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="size_chart_images[<?php echo $key;?>][image]" value="<?php echo $value['imagesrc'];?>" id="input-image<?php echo $key;?>" /></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[<?php echo $key;?>][width]" value="<?php echo $value['width']; ?>"></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[<?php echo $key;?>][height]" value="<?php echo $value['height']; ?>"></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[<?php echo $key;?>][imagename]" value="<?php echo $value['imagename']; ?>"></td>
										<td align="center"><button type="button" onclick="removerowimage(<?php echo $key;?>);" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>	
									</tr>
									<?php } ?>
									<input type="hidden" id="imagecounter" name="imagecounter" value="<?php print_r(count($size_chart_images)+1);?>">
									<?php } else{ ?>
									<tr id="rowimage1">
										<td class='left'><a href="" id="thumb-image1" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title=""  /></a><input type="hidden" name="size_chart_images[1][image]" value="<?php echo $thumbimage; ?>" id="input-image1" /></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[1][width]" value="600"></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[1][height]" value="400"></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[1][imagename]" value="Title 1"></td>
										<td align="center"><button type="button" onclick="removerowimage(1);" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
										<input type="hidden" id="imagecounter" name="imagecounter" value="4">
									</tr>
									<?php } ?>
								</tbody>
								<tfoot id = "last_row_images">
										<tr id="last-tr_images">
										<td align="center" colspan=4></td>
										<td align="center" ><button type="button" onclick="addrowsimages();" data-toggle="tooltip" title="Add Row" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr> 
										
								</tfoot>
							</table>
								
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<style>
.onj_popup table td{padding:20px 5px}
</style>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $_GET['token']; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('#size_chart-product' + item['value']).remove();
		
		$('#size_chart-product').append('<div id="size_chart-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" value="' + item['value'] + '" /></div>');	
	
		data = $.map($('#size_chart-product input'), function(element) {
			return $(element).attr('value');
		});
						
		$('input[name=\'size_chart_product\']').attr('value', data.join());	
	}	
});

$('#size_chart-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();

	data = $.map($('#size_chart-product input'), function(element) {
		return $(element).attr('value');
	});
					
	$('input[name=\'size_chart_product\']').attr('value', data.join());	
});
// Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $_GET['token']; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category\']').val('');
		
		$('#product-category' + item['value']).remove();
		
		$('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');	
	}
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
<script>
		var fields=<?php echo count($fields);?>;
		function addrows(){
			var counter = $('#counter').val();
			var setvalue = parseInt(counter)+1;
			$('#counter').val(setvalue);
			$row_string = '<tr id = "row'+counter+'">';
			for(i=0;i<fields;i++)
			{
				$row_string +='<td class="left"><input class="form-control" type = "text" name = "data['+counter+']['+i+']"></td>';
			}
			$row_string +='<td align="center"><button type="button" onclick = "removerow('+counter+');" data-toggle="tooltip" title = "Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td></tr>';
			$('#last-tr').before($row_string);
		}
		function removerow(counter){
			$("#row"+counter).remove();
		}
</script>
<script>
function addrowsimages(){
		var imagecounter=$('#imagecounter').val();
		var thumb="<?php echo $thumb;?>";
		var thumbimage="<?php echo $thumbimage;?>";
		var placeholder='';
	    $row_string='<tr id = "rowimage'+imagecounter+'">';
		$row_string +='<td class="left"><a href="" id="thumb-image'+imagecounter+'" data-toggle="image" class="img-thumbnail"><img src="'+thumb+'" alt="" title="" data-placeholder="'+placeholder+'" /></a><input type="hidden" name="size_chart_images['+imagecounter+'][image]" value="'+thumbimage+'" id="input-image'+imagecounter+'" /></td>';	
		$row_string +='<td class="left"><input class="form-control" type = "text" name="size_chart_images['+imagecounter+'][width]" value="600"></td>';	
		$row_string +='<td class="left"><input class="form-control" type = "text" name="size_chart_images['+imagecounter+'][height]" value="400"></td>';	
		$row_string +='<td class="left"><input class="form-control" type = "text" name="size_chart_images['+imagecounter+'][imagename]" value="Title '+imagecounter+'"></td>';	
		$row_string +='<td align="center"><button type="button" onclick="removerowimage('+imagecounter+');" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td></tr>';
		$("#module-row_images").append($row_string);
		imagecounter++;
		$('#imagecounter').val(imagecounter);		
	}
	 function removerowimage(counter){
		$("#rowimage"+counter).remove();
	}
</script>
<?php echo $footer; ?>