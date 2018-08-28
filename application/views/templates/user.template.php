<?php
echo link_tag(css_url()."bootstrap.css");
echo link_tag(css_url()."bootstrap-datepicker.css");
echo link_tag(css_url()."AdminLTE.css");
echo link_tag(css_url()."skins/_all-skins.css");
echo link_tag(css_url()."toastr.css");
echo link_tag(css_url()."font-awesome.min.css");
echo link_tag(css_url()."ionicons.min.css");
echo link_tag(css_url()."jquery.dataTables.css");
echo link_tag(css_url()."dataTables.bootstrap.css");
echo link_tag(css_url()."modal-skins.css");
echo link_tag(css_url()."modal-tweaks.css");
echo link_tag(css_url() . "bootstrap-toggle.min.css");
?>

<html>
	<head>
		<title><?=title()?></title>
		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
  		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="<?=js_url().'jquery-3.1.1.min.js'?>"></script>
		<script src="<?=js_url().'bootstrap.js'?>"></script>
		<script src="<?=js_url().'bootstrap-datepicker.min.js'?>"></script>
		<script src="<?=js_url().'app.min.js'?>"></script>
		<script src="<?=js_url().'toastr.min.js'?>"></script>
		<script src="<?=js_url().'chart.js'?>"></script>
		<script src="<?=js_url().'jquery.dataTables.min.js'?>"></script>
		<script src="<?=js_url().'dataTables.bootstrap.min.js'?>"></script>
		<script src='<?=js_url()."bootstrap-toggle.min.js"?>'></script>
		
	</head>

	<body class="hold-transition sidebar-mini <?=$userInfo->theme_name?>">
		<div class="wrapper" style="overflow:hidden;">
			<header class="main-header">
				<a href="<?=base_url()?>admin/users" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<?php if(miniLogo() != NULL){ ?>
						<span class="logo-mini"><img src="<?=uploaded_images_url() . miniLogo()?>" style="width:50px; margin-top:5px;"></span>
					<?php } else {?>
						<span class="logo-mini">Logo</span>
					<?php } ?>
					<!-- logo for regular state and mobile devices -->
					<?php if(logo() != NULL){ ?>
						<span class="logo-lg"><img src="<?=uploaded_images_url() . logo()?>" style="width:130px; margin-top:3px;"></span>
					<?php } else {?>
						<span class="logo-lg"><?=title()?></span>
					<?php } ?>
				</a>
				
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li>
								<a href="<?=base_url()?>auth/logout" class=""><i class="fa fa-sign-out"></i> Sign out</a>
							</li>
							
							<!-- <li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="_assets/img/user2-160x160.jpg" class="user-image" alt="User Image">
									
									<span class="hidden-xs"><?=ucfirst($this->session->userdata('u_first_name')) . " " . ucfirst($this->session->userdata('u_last_name'));?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="_assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
										<p>
											<?=ucfirst($this->session->userdata('u_first_name')) . " " . ucfirst($this->session->userdata('u_last_name')) ;?>
											<small><i><?=strtoupper($this->session->userdata('u_role'));?></i></small>
										</p>
									</li>
									<li class="user-footer">
										<div class="pull-right">
											<a href="auth/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
										</div>
									</li>
								</ul>
							</li>-->
						</ul>
					</div>
				</nav>
			</header>
			
			<!-- Sidebar -->
			<?=$sidebar?>
			
			<div class="content-wrapper">
				<!-- Content Header -->
				<section class="content-header">
					<h1>
					<p><div id="activeMenu"><?=$active['menu']?></div></p>
					<small id="activeSubMenu"><?=$active['sub_menu'] ?? ''?></small><small><?=$active['sub_menu_breadcrumb'] ?? ''?></small>
					</h1>
				</section>
				
				<!-- Main content -->
				<section class="content" style="min-height: 100%">
					<?=$content;?>
				</section>
			</div>
			
			<!-- Footer -->
			<footer class="main-footer">
				<strong>Copyright &copy; 2017 <a href="#"><?=title()?></a>.</strong> All rights reserved.
				<div class="pull-right hidden-xs text-muted">
					<i>Version <?=_SYNTHIA_VERSION?></i>
				</div>
			</footer>
		</div>
		
		<!-- Loading SVG -->
		<img id="loadingSVG" src='<?=images_url()?>loading.svg' style='width:100px; position:absolute; top:50%; left:50%; z-index:9999; transform: translate(-50%, -50%); display:none;'>
	</body>
	
	<script>
		$(function(){
			<?=$this->session->flashdata("success_message") != null ? 'toastr.success("' . $this->session->flashdata("success_message") . '");' : null?>
			<?=$this->session->flashdata("error_message") != null ? 'toastr.error("' . $this->session->flashdata("error_message") . '");' : null?>
			<?=$this->session->flashdata("info_message") != null ? 'toastr.info("' . $this->session->flashdata("info_message") . '");' : null?>

			$("input[type=submit]").click(function(){
				$("body div").css({"-webkit-filter" : "grayscale(15%)",
							"-moz-filter" : "grayscale(15%)",
							"-o-filter" : "grayscale(15%)",
			    			"-ms-filter" : "grayscale(15%)",
			    			"filter" : "grayscale(15%)"});
				
				$("#loadingSVG").show();
			});
		});
	</script>
	
	<!-- IMAP Polling -->
	<script>
	setInterval(IMAPPoll, 60000)
		function IMAPPoll(){
			$.ajax({
				url: "<?=base_url()?>support/iMAPPoll",
				success: function(data){
					console.log(data);
				}
			});
		}
	</script>
	
</html>	
