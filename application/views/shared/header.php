<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title; ?></title>

		<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>css/datepicker3.css" rel="stylesheet">

		<link href="<?php echo base_url(); ?>css/bootstrap-table.css" rel="stylesheet">


		<link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet">

		<!--Icons-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

		<script src="<?php echo base_url(); ?>js/lumino.glyphs.js"></script>

		<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>js/html5shiv.js"></script>
		<script src="<?php echo base_url(); ?>js/respond.min.js"></script>
		<![endif]-->

		

		<!-- JS Min
		================================================== -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>"><span>Digime </span>Admin</a>
					<ul class="user-menu">
						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-user"></i> User <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo site_url('logout'); ?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
								
			</div><!-- /.container-fluid -->
		</nav>
			
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			<ul class="nav menu">
				<li class="<?php echo ($current_nav=='nav1') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
				<li class="<?php echo ($current_nav=='nav2') ? 'active' : ''; ?>"><a href="<?php echo site_url('sms'); ?>"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> SMS Body</a></li>			
				<li class="<?php echo ($current_nav=='nav3') ? 'active' : ''; ?> parent ">
					<a data-toggle="collapse" href="#client-items">
						<span><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg></span> Client 
					</a>
					<ul class="children collapse <?php echo ($current_nav=='nav3') ? 'in' : ''; ?>" id="client-items">
						<li>
							<a class="" href="<?php echo site_url('client'); ?>">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> View All
							</a>
						</li>
						<li>
							<a class="" href="<?php echo site_url('client/add'); ?>">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Add New
							</a>
						</li>
					</ul>
				</li>
				<li class="<?php echo ($current_nav=='nav4') ? 'active' : ''; ?> parent ">
					<a data-toggle="collapse" href="#system-user-items">
						<span><i class="fa fa-user"></i></svg></span> System User 
					</a>
					<ul class="children collapse <?php echo ($current_nav=='nav4') ? 'in' : ''; ?>" id="system-user-items">
						<li>
							<a class="" href="<?php echo site_url('system-user'); ?>">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> View All
							</a>
						</li>
						<li>
							<a class="" href="<?php echo site_url('system-user/add-edit'); ?>">
								<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Add New
							</a>
						</li>
					</ul>
				</li>
				<li role="presentation" class="divider"></li>
				<li><a href="<?php echo site_url('logout'); ?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
			</ul>

		</div><!--/.sidebar-->
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">