<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Tecson Flowers Ordering</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="<?=css_dir('bootstrap.css')?>" rel="stylesheet">
		<style type="text/css">
			body {
			padding-top: 60px;
			padding-bottom: 40px;
			}
		</style>
		<link href="<?=css_dir('bootstrap-responsive.css')?>" rel="stylesheet">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js')?>"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="../assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	</head>
	<body>
	    <div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          <a class="brand" href="#">Tecson Flowers</a>
	          <div class="nav-collapse">
	            <ul class="nav">
	            </ul>
	          </div><!--/.nav-collapse -->	          
	        </div>
	      </div>
	    </div>

	    <div class="container">
			<form method="post" class="well form-inline">					
				<?php $group = ''; if (isset($error)) $group = ' error';?>
				<div class="control-group <?=$group?>">
				  	<input type="text" class="input-small" name="username" placeholder="Username">
				  	<input type="password" class="input-small" name="password" placeholder="Password">
				  	<button type="submit" class="btn">Sign in</button>
				  	<?php if (isset($error)):?>
				  	<span class="help-inline"><?=$error?></span>
				  	<?php endif;?>
			  	</div>
			</form>	
		</div>

	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="<?=js_dir('jquery.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-transition.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-alert.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-modal.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-dropdown.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-scrollspy.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-tab.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-tooltip.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-popover.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-button.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-collapse.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-carousel.js')?>"></script>
	    <script src="<?=js_dir('bootstrap-typeahead.js')?>"></script>		
	</body>	
</html>