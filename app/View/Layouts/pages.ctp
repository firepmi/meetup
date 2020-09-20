<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php  echo $title;?></title>

        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
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
		<?php
		/************** Javascript Files *************/
		echo $this->Html->script(
			array(
				'vendor/modernizr.min.js',
				'vendor/jquery.min.js',
				'vendor/bootstrap.min.js',
				'plugins.js',
				'app.js',
				'pages/readyComingSoon.js'
				) 
			);
	?>	
        <!-- Load and execute javascript code used only in this page -->
        
        <script>$(function(){ ComingSoon.init(); });</script>
    </head>
	<body>
	<?php echo $this->fetch('content'); ?>
	</body>
	</html>