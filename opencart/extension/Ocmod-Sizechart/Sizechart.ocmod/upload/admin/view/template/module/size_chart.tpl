<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	 <div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="submit" form="form-size" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="?route=module/size_chart/insert&token=<?php echo $_GET['token']; ?>" data-toggle="tooltip" title="Add Size Chart" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a>
			<button type="submit" form="form-delete" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
			<a href="?route=module/size_chart/support&token=<?php echo $_GET['token']; ?>" data-toggle="tooltip" title="Support" class="btn btn-default" target="_blank"><i class="fa fa-life-ring fa-lg"></i></a></div>
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
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-size" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
					<div class="col-sm-10">
						<select name="size_chart_status" id="input-status" class="form-control">
							<?php if ($size_chart_status) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</form>
			<form action="?route=module/size_chart/delete_size_chart&token=<?php echo $_GET['token'];?>" method="post" enctype="multipart/form-data" id="form-delete" class="form-horizontal">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
								<td>Template</td>
								<td class="text-right">Action</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($charts as $chart){ ?>
								<tr align = "center">
									 <td style="text-align: center;">                
										<input type="checkbox" name="selected[]" value="<?php echo $chart['template_id'];?>" >
									</td>  
									<td class="text-left"><?php echo $chart['templatename']; ?></td>			
									<td class="text-right">
										<a  href = "?route=module/size_chart/edit_size_chart&token=<?php echo $_GET['token']?>&size_chart_id=<?php echo $chart['template_id'];?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
										<a  href = "?route=module/size_chart/delete_size_chart&token=<?php echo $_GET['token']?>&size_chart_id=<?php echo $chart['template_id'];?>" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
			<div class="row">
				<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
				<div class="col-sm-6 text-right"><?php echo $results; ?></div>
			</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>