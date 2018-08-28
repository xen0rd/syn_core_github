<?php
echo link_tag(css_url()."bootstrap.css");
echo link_tag(css_url()."bootstrap-datepicker.css");
echo link_tag(css_url()."toastr.css");
echo link_tag(css_url()."file_input.css");
echo link_tag(css_url()."bootstrap-multidropdown.css");
echo link_tag(css_url()."jquery.dataTables.css");
echo link_tag(css_url()."dataTables.bootstrap.css");
echo link_tag(css_url()."client-login.css");
echo link_tag(css_url()."font-awesome.min.css");
echo link_tag(css_url()."breadcrumbs.css");
?>
<html>
	<head>
		<script src="<?=js_url().'jquery-3.1.1.min.js'?>"></script>
		<script src="<?=js_url().'bootstrap.js'?>"></script>
		<script src="<?=js_url().'bootstrap-datepicker.min.js'?>"></script>
		<script src="<?=js_url().'toastr.min.js'?>"></script>
		<script src="<?=js_url().'jquery.dataTables.min.js'?>"></script>
		<script src="<?=js_url().'dataTables.bootstrap.min.js'?>"></script>
		<style>
			body{
				padding:20px;
				background: -webkit-radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
				background: -o-radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
				background: -moz-radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
				background: radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
			}
			.container {
			    min-height: 100%;
			    height: auto !important;
			    height: 100%;
			    margin: 0 auto -50px;
			}
			.footer, .push {
			    height: 20px;
			}
			.navbar{
				webkit-box-shadow: 0 8px 6px -6px #999;
			    -moz-box-shadow: 0 8px 6px -6px #999;
			    box-shadow: 0 8px 6px -6px #999;
		    }
			
			/*Background*/
			.vertical-center {
				min-height: 100%;
				min-height: 100vh;
				display: flex;
				align-items: center;
			}
			.c{
				position:absolute;
			   	background: #e1e8ff; 
			   	-moz-border-radius: 80px; 
			   	-webkit-border-radius: 80px; 
			   	border-radius: 80px;
			   	opacity: 0.8;
    			filter: alpha(opacity=80);
    			z-index:-999;
		   	}
			#c1{
			   	width: 80px;
			   	height: 80px;
				top:35%;
				right:50%;
			}
			#c2{
			   	width: 140px;
			   	height: 140px;
				top:23%;
				right:61%;
			}
			#c3{
				width: 120px;
			   	height: 120px;
				top:48%;
				right:60%;
			}
			#c4{
				width: 100px;
			   	height: 100px;
				top:35%;
				right:35%;
			}
			#c5{
				width: 80px;
			   	height: 80px;
				top:50%;
				right:30%;
			}
			#c6{
				width: 60px;
			   	height: 60px;
				top:63%;
				right:45%;
			}
			#c7{
				width: 60px;
			   	height: 60px;
				top:63%;
				right:45%;
			}
		</style>
                
                <!-- Start of Zendesk Widget script -->
                <script>/*<![CDATA[*/window.zE||(function(e,t,s){var n=window.zE=window.zEmbed=function(){n._.push(arguments)}, a=n.s=e.createElement(t),r=e.getElementsByTagName(t)[0];n.set=function(e){ n.set._.push(e)},n._=[],n.set._=[],a.async=true,a.setAttribute("charset","utf-8"), a.src="https://static.zdassets.com/ekr/asset_composer.js?key="+s, n.t=+new Date,a.type="text/javascript",r.parentNode.insertBefore(a,r)})(document,"script","1d456ad0-e1cf-4eb9-9efb-5b7d090cd04e");/*]]>*/</script>
                <!-- End of Zendesk Widget script -->
	</head>
	<body>
		<!-- Background -->
		<div class="c" id="c1"></div>
		<div class="c" id="c2"></div>
		<div class="c" id="c3"></div>
		<div class="c" id="c4"></div>
		<div class="c" id="c5"></div>
		<div class="c" id="c6"></div>
		<div class="c" id="c7"></div>	
		
		
		<nav class="navbar navbar-default" style="background-color: #fff;">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
						<a class="navbar-brand" href="<?=base_url()?>">
						<?php if(logo() != NULL){ ?>
								<img src="<?=uploaded_images_url() . logo()?>" style="width:110px; margin-top:-7px;">
							<?php } else {?>
								<h2 class="text-primary" style="margin-top:-7px;"><?=title()?></h2>
							<?php } ?>
						</a>
				</div>
				
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<!-- <li class="active"><a href="#">Products <span class="sr-only"></span></a></li>
						<li><a href="#">Orders</a></li>
						<li><a href="#">Downloads</a></li> -->
						<li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                                                <li><a href="<?=base_url()?>downloadable">Downloadable</a></li>
                                                                <li><a href="<?=base_url()?>virtual">Virtual</a></li>
                                                                <?php if($this->auth->isClientLoggedIn()){?>
                                                                    <li class="divider"></li>
                                                                    <li><a href="<?=base_url()?>purchased_products">Purchased Products</a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="<?=base_url()?>purchase_history">Purchase History</a></li>
                                                                <?php } ?>
							</ul>
                                                </li>
                                                <?php if($this->auth->isClientLoggedIn()){?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Support <span class="caret"></span></a>
							<ul class="dropdown-menu multi-level">
								<li class="dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tickets</a>
									<ul class="dropdown-menu">
										<li><a href="<?=base_url()?>create_ticket">Submit a ticket</a></li>
                                                                                <li><a href="<?=base_url()?>submitted_tickets">View submitted ticket(s)</a></li>
									</ul>
								</li>
							</ul>
						</li>
                                                <?php } ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if($this->auth->isClientLoggedIn()){?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><?=ucfirst($this->session->userdata('c_first_name'));?> <?=ucfirst($this->session->userdata('c_last_name'));?></b>&nbsp;<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="<?=base_url()?>profile_settings"><i class="fa fa-user fa-fw text-primary"></i>&nbsp;Profile Settings</a></li>
									<li><a href="<?=base_url()?>account_settings"><i class="fa fa-gear fa-fw text-primary"></i>&nbsp;Account Settings</a></li>
									<li><a href="<?=base_url()?>pchange"><i class="fa fa-lock fa-fw text-primary"></i>&nbsp;Change Password</a></li>
									<li class="divider"></li>
									<li><a href="<?=base_url()?>auth/logout/client"><i class="fa fa-sign-out fa-fw text-primary"></i>&nbsp;Logout</a></li>
								</ul>
							</li>
						<?php } else {?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
								<ul id="login-dp" class="dropdown-menu">
									<li>
										<div class="row">
											<div class="col-md-12">
												<form class="form" role="form" method="POST" action="<?=base_url()?>auth/login" autocomplete="off" id="login-nav">
													<div class="form-group">
														<label class="sr-only" for="username">Username</label>
														<input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
													</div>
													<div class="form-group">
														<label class="sr-only" for="password">Password</label>
														<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
														<div class="help-block text-right">
															<a href="<?=base_url() . "forgotpassword"?>">Forgot Password?</a>
														</div>
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-primary btn-block">Sign in</button>
													</div>
												</form>
											</div>
											<div class="bottom text-center">
												Don't have an account?<br><a href="<?=base_url() . "client/register"?>"><b>Register here</b></a>
											</div>
										</div>
									</li>
								</ul>
							</li>
						<?php } ?>
					</ul>
				
				</div>
			</div>
		</nav>
                
		<?=$content;?>
		
		<div class="push"></div>
		<div class="footer">
		    <div class="container align-center" style="text-align: right;">
				<p class="text-muted"><i>Copyright &#169; 2017. All Rights Reserved.<br></i>
				</p>
			</div>
		</div>
	</body>
	<script>
		$(function(){
			<?=$this->session->flashdata("success_message") != null ? 'toastr.success("' . $this->session->flashdata("success_message") . '");' : null?>
			<?=$this->session->flashdata("error_message") != null ? 'toastr.error("' . $this->session->flashdata("error_message") . '");' : null?>
			<?=$this->session->flashdata("info_message") != null ? 'toastr.info("' . $this->session->flashdata("info_message") . '");' : null?>

			$("input[type=submit]").click(function(){
				$("#loadingSVG").show();
			});
		});
	</script>
</html>
