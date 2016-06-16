<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-size-chart" data-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="?route=module/size_chart&token=<?php echo $_GET['token']; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a>
				<a href="?route=module/size_chart/support&token=<?php echo $_GET['token']; ?>" data-toggle="tooltip" title="Support" class="btn btn-default" target="_blank">Support</a>
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
		<div id="lightbox" style="display: block;opacity: 0.4;position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 100;background-color: rgb(0, 0, 0);"></div>
		<div class="onj_popup" style="position: fixed; z-index: 110;left: 33%; top:20%;">
			<table style="border-spacing:inherit; border: 5px solid #555555;position: relative;top: 100px;background-color: #ffffff;">
				<tr>
					<td style="font-size:16px; font-weight:600;">ENTER NUMBER OF COLUMNS</td>
					<td><input class="form-control" type="text" name="txtColumn" style="width:50px;"/></td>
					<td><input class="form-control"  type="button" value="PROCEED" name="btnProceed" onclick="return getColumns();" style="padding:4px 14px; background-color: #00904B;border:thin solid #81D8D0;color: #ffffff;" /></td>
				 </tr>
			</table>
		 </div>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-size-chart" class="form-horizontal">
					<div class="form-group">
						<div class="col-sm-10" style = "width:100%">
							<table class="table table-bordered">
								<tr>
									<td width="200" align="right">Template Name :</td><td colspan = "2"><input class="form-control" type = "text" name="templatename"></td>
								</tr>
								<tr>
									<td width="200" align="right">Note :</td>
									<td colspan = "2"><textarea class="form-control" name="template_content"></textarea></td>
								</tr>
							</table>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="(Autocomplete)">Products</span></label>
								<div class="col-sm-10">
									  <input type="text" name="product" value="" placeholder="Products" id="input-product" class="form-control" />
									  <div id="size_chart-product" class="well well-sm" style="height: 150px; overflow: auto;"></div>
								</div>
							</div>
						   <!--- Category -->
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
								<div class="col-sm-10">
									<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
									<div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
									 </div>
								</div>
							</div>
						  <!--- Category Ends -->
						  <input type="hidden" name="size_chart_product" class="form-control" />
							<table id = 'tbl1' class="table  table-bordered"> 
									<tbody id="module-row"></tbody>
									<tfoot id = "last_row">
										<tr id="last-tr">
											<td align="center"><button type="button" onclick="addrows();" data-toggle="tooltip" title="Add Row" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>   
									</tfoot>
							</table>			
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
									<tr id="rowimage1">
										<td class='left'><a href="" id="thumb-image1" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" /></a><input type="hidden" name="size_chart_images[1][image]" value="<?php echo $thumbimage; ?>" id="input-image1" /></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[1][width]" value="600"></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[1][height]" value="400"></td>
										<td class='left'><input class="form-control" type = "text" name="size_chart_images[1][imagename]" value="Title 1"></td>
										<td align="center"><button type="button" onclick="removerowimage(1);" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
									</tr>
								</tbody>
								<tfoot id = "last_row_images">
										<tr id="last-tr_images">
										<td align="center" colspan=4></td>
										<td align="center" ><button type="button" onclick="addrowsimages();" data-toggle="tooltip" title="Add Row" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr> 
											<input type="hidden" id="imagecounter" name="imagecounter" value="2">
								</tfoot>
							</table>
					  <!-- Size Chart Ends -->
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
<script>
	var fields=0;
    var counter =3;
    function addrows(){
		var setvalue = parseInt(counter)+1;
		$('#counter').val(setvalue);
	    $row_string='<tr id = "row'+counter+'">';
	    for(i=0;i<fields;i++){
			$row_string +='<td class="left"><input class="form-control" type = "text" name = "data['+counter+']['+i+']"></td>';
		}
		$row_string +='<td align="center"><button type="button" onclick="removerow('+counter+');" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td></tr>';
		$("#module-row").append($row_string);
		counter++;
	}
	
	 
    function removerow(counter){
		$("#row"+counter).remove();
	}
	function getColumns(){
		if(validateColumn()){
			fields=$("input[name='txtColumn']").val();
			var content="<tr id='row1'>";
			for(i=0;i<fields;i++){
				content +="<td class='left'><input class='form-control' type = 'text' name = 'data[1]["+i+"]' placeholder='Heading "+(i+1)+"'></td>";
			}
			content +="<td align='center' style='font-size:14px; color:#777'>Action</td></tr><tr id='row2'>";
			for(i=0;i<fields;i++){
				content +="<td class='left'><input class='form-control' type = 'text' name = 'data[2]["+i+"]'></td>";
			}
			content +='<td align="center" style="border-top:1px solid #dddddd;"><button type="button" onclick="removerow(2);" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td></tr>';
			$("#module-row").append(content);
			$("#last-tr").prepend('<td colspan="'+fields+'"></td>');
			$("#lightbox").hide();
			$(".onj_popup").hide();
		}
	}
	function validateColumn(){
		if($("input[name='txtColumn']").val()==""){
			alert("Please enter Number of columns");
			return false;
		}
		else if(isNaN($("input[name='txtColumn']").val())){
			alert("Please enter a number");
			return false;
		}
		else if($("input[name='txtColumn']").val() > 10){
			alert("Columns cannot be more than 10 ");
			return false;
		}
		return true;
	}
</script>
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
//--></script>
<script>
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
function addrowsimages(){
		var imagecounter=$('#imagecounter').val();
		var thumb="<?php echo $thumb; ?>";
		var thumbimage="<?php echo $thumbimage; ?>";
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