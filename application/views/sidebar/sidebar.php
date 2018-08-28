<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel" style="min-height: 50px;">
			<div class="info" style="padding-left: 0px;">
				<?=$this->session->userdata('u_role') == 'admin' ? '<i class="fa fa-circle text-danger"></i>' : '<i class="fa fa-circle text-primary"></i>' ?> &nbsp;
				<b><?=ucfirst($this->session->userdata('u_first_name')) . " " . ucfirst($this->session->userdata('u_last_name'));?></b>
				&nbsp;
				<center><small style="line-height:20px;"><i><?=ucfirst($this->session->userdata('u_role'));?></i></small></center>
			</div>
		</div>
		
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header"><i class="fa fa-circle"></i>&nbsp; CONTROL PANEL</li>
			<?php if($this->session->userdata('u_role') == "admin"){?>
			<li active-menu="Users">
				<a href="<?=base_url()?>admin/users">
				<i class="fa fa-user-circle-o"></i> <span>Users</span></a>
			</li>
			<li active-menu="Clients">
				<a href="<?=base_url()?>admin/clients">
				<i class="fa fa-users"></i> <span>Clients</span></a>
			</li>
			<li active-menu="Departments">
				<a href="<?=base_url()?>admin/departments">
				<i class="fa fa-sitemap"></i> <span>Departments</span></a>
			</li>
			<?php } ?>
			<li active-menu="Support" class="treeview">
				<a href="#"><i class="fa fa-ticket"></i><span>Support</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-left"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li active-submenu="Tickets"><a href="<?=base_url()?>support/tickets">Tickets</a></li>
					<?php if($this->session->userdata('u_role') == "admin"){?>
					<li active-submenu="Ticket Priority Levels"><a href="<?=base_url()?>support/priorities">Ticket Priorities</a></li>
					<!-- <li active-submenu="IMAP Configuration"><a href="<?=base_url()?>support/imap">IMAP Configuration</a></li>-->
					<?php } ?>
				</ul>
			</li>
			<?php if($this->session->userdata('u_role') == "admin"){?>
			<li active-menu="Products">
				<a href="<?=base_url()?>admin/products">
				<i class="fa fa-archive"></i> <span>Products</span></a>
			</li>
			<li active-menu="Orders">
				<a href="<?=base_url()?>admin/orders">
				<i class="fa fa-shopping-cart"></i> <span>Orders</span></a>
			</li>
			<li active-menu="Configuration" class="treeview">
				<a href="#"><i class="fa fa-gears"></i><span>Configuration</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-down pull-left"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li active-submenu="Email Settings"><a href="<?=base_url()?>admin/configuration/smtp">Email Settings</a></li>
					<li active-submenu="Application Settings"><a href="<?=base_url()?>admin/configuration/settings">Application Settings</a></li>
					<li active-submenu="Payment Methods"><a href="<?=base_url()?>admin/configuration/payment_methods">Payment Methods</a></li>
				</ul>
			</li>
			<?php } ?>
			
			<li class="header"><i class="fa fa-circle"></i>&nbsp; ACCOUNT CONFIGURATION</li>
			<?php if($this->session->userdata('u_role') == "admin"){?>
			<li active-menu="Create New Account">
				<a href="<?=base_url()?>user/register">
				<i class="fa fa-user-plus"></i> <span>Create New Account</span></a>
			</li>
			<?php } ?>
			
			<li active-menu="Profile Settings">
				<a href="<?=base_url()?>admin/profile_settings">
				<i class="fa fa-user"></i> <span>My Profile Settings</span></a>
			</li>
			<li active-menu="Account Settings">
				<a href="<?=base_url()?>admin/account_settings">
				<i class="fa fa-id-card"></i> <span>My Account Setings</span></a>
			</li>
			<li active-menu="Change Password">
				<a href="<?=base_url()?>admin/pchange">
				<i class="fa fa-lock"></i> <span>Change Password</span></a>
			</li>
			
			<?php if($this->session->userdata('u_role') == "admin"){?>
			<li class="header"><i class="fa fa-circle"></i>&nbsp; LOGS</li>
			<li active-menu="Activities">
				<a href="<?=base_url() . "activity/getActivities"?>">
				<i class="fa fa-newspaper-o"></i> <span>Activities</span></a>
			</li>
			<?php } ?>
			<!-- <li id="">
				<a href="#">
				<i class="fa fa-spinner"></i> <span>Updates</span></a>
			</li> -->
			
			<li class="header"><i class="fa fa-circle"></i>&nbsp; THEMES</li>
			<div class="list-unstyled clearfix">
				<?=form_open("admin/change_skin", array("id" => "skin_form"));?>
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="3" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #3c8dbc;"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #357ca5;""></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #0e0e0e;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted">Blue</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="1" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
						<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
							<span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
							<span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
						</div>
						<div>
							<span style="display:block; width: 20%; float: left; height: 20px; background: #0e0e0e;"></span>
							<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
						</div>
						</a>
						<p class="text-center no-margin text-muted">White</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="7" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #605ca8;"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #545096;"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #0e0e0e;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted">Purple</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="5" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background:#00a65a"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background:#008749"></span></div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #0e0e0e;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted">Green</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="9" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #dd4b39"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #d73925"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #0e0e0e;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted">Red</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="11" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #f39c12"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #e08e0b"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #0e0e0e;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted">Yellow</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="4" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #3c8dbc"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #3c8dbc"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #fff;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted" style="font-size: 12px">Blue Light</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="2" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
								<span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #fff;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted" style="font-size: 12px">White Light</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="8" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
								<span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #fff;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted" style="font-size: 12px">Purple Light</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="6" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
								<span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #fff;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted" style="font-size: 12px">Green Light</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="10" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
								<span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #fff;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted" style="font-size: 12px">Red Light</p>
					</li>
					
					<li style="float:left; width: 33.33333%; padding: 5px;">
						<a href="javascript:void(0);" data-skin-id="12" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="switch-skin clearfix full-opacity-hover">
							<div>
								<span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
								<span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
							</div>
							<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #fff;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #fff;"></span>
							</div>
						</a>
						<p class="text-center no-margin text-muted" style="font-size: 12px;">Yellow Light</p>
					</li>
					<input type="hidden" name="skin_id">
				<?=form_close();?>
			</div>
		</ul>
	</section>
</aside>
<script>
	$(function(){
		$(".sidebar-menu > li").removeClass('active');
		$(".sidebar-menu > li[active-menu='" + $('#activeMenu').text() + "']").addClass('active');
		$(".sidebar-menu > .active > .treeview-menu > li").removeClass('active');
		$(".sidebar-menu > .active > .treeview-menu > li[active-submenu='" + $('#activeSubMenu').text() + "']").addClass('active');
		
		$("a.switch-skin").click(function(){
			var skinId = $(this).attr("data-skin-id");
			$("input[name='skin_id']").val(skinId);
			$("#skin_form").submit();
		});
		
	});
</script>