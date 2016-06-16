<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $link_back; ?>" data-toggle="tooltip" title="Back" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
		</div>
	</div>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-life-ring"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<p>Purchasing this great module brought you to become part of our family. In ONJECTION, our mantra is set to deliver great products with fanatically awesome customer service</p>
				<h2 >Support</h2>
				<p>ONJECTION team is taking support very seriously. No matter what issue or question you have we will address it. Most of the times we answer within couple of hours, as sometimes it can take a day. Please click the button below to Contact Us.</p>
				<div><a  href = "http://www.onjection.com/contact-us/" target="_blank" class = "btn btn-primary " >CONTACT US</a></div><br/>
				
				<h2 id = "show_install" >Installation Step:</h2>
				<div id = "install">
					<ol>
						<li>extract the zip file which you downloaded now.</li> 
						<li>Copy contents of the Size Chart  folder and paste to your opencart root directory.</li>
						<li>Go to admin->Modules and then install Size Chart Module in that then click edit.</li>
						<li>After installation edit the Size Chart.</li>
						<li>Now you can see all the template list(if exist).You can perform following operations:- </li>
						<li>Inserting Template:
							<ul>
								<li>♦ For inserting new template click on button named "InsertTemplate".</li>
								<li>♦ Fill the template name and content that describe your template.	</li>
								<li>♦ Now fill desired number of column(numeric only) and press 'proceed'.</li>
								<li>♦ First field in each column is for heading.Fill them with proper headings.</li>
								<li>♦ you can add rows by clicking button Add Row and delete a row by clicking button 'Remove'.</li>
								<li>♦ template will be saved or created when you click on save button.</li>
							</ul>
						</li>
						<li>Deleting Template:
							<ul>
								<li>♦ For deleting single template,click on delete icon (right side of each template).</li>
								<li>♦ For deleting template in bulk,just click the checkbox (left side of each template name) and click on red delete button on the top.</li>
							</ul>	
						</li>
						<li>All done now you can see your Size Chart in associated product description on store front,just by clicking the link SIZE CHART.</li>
						<li>Give all the permision from admin system >Users > Users  groups. if you need.</li>
					</ol>
				</div>
				
				<h2 >Onjection News:</h2><br />
				<div id="onj_news">
					<iframe src="http://shipway.in/newupdates/updates.php?extension=size_chart_2.0&oc_version=2.0" scrolling="no"  style="border:none;width:100%;min-height:200px" > </iframe><br />
					<div style = "float:left"><a href = "http://www.opencart.com/index.php?route=extension/extension&filter_username=vikasgarg40" class = "btn btn-primary" >MORE EXTENSIONS</a></div><br/>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>