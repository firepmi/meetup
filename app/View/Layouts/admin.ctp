<?php if(empty($title)){$title='Error';} ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?php //echo HTTP_ROOT.'img/favicon.ico'?>" type="image/x-icon"/>
        <title>MeetUp</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<?php	/************** Stylesheets *************/
		echo $this->Html->css(
			array(
				'bootstrap.min.css',
				'plugins.css',
				'main.css',
				'themes.css'
				)
		);
	?>
	<?php echo $this->Html->script('vendor/modernizr.min.js'); ?>
	<?php
		/************** Javascript Files *************/
		echo $this->Html->script(
			array(
				'vendor/jquery.min.js',
				'vendor/bootstrap.min.js',
				'plugins.js',
				'app.js',
				'pages/login.js'
				) 
			);
	?>	
    </head>    
    
	
	<body class="skin-blue">        
	<?php
			if($this->params['action'] != 'admin_login')
				{
					 echo $this->element('adminElements/admin_header'); ?>
				  <div class="wrapper row-offcanvas row-offcanvas-left" style="min-height: 315px;">	
			    <?php	echo $this->element('adminElements/admin_sidebar'); 
			 }
		?>
	 <?php echo $this->fetch('content'); ?>
		</div>	
	</body>	        
</html>		    
<script type="text/javascript">
$(document).ready(function(){
  $('.alert-success').delay(20000).fadeOut(20000);
})
</script>
