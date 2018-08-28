<style>
#login{
	width:40%;
	margin:auto; 
	border: 1px solid #dedede; 
	padding:20px 20px 30px 20px; 
	border-radius:5px;
	box-shadow: 5px 5px 15px 0px;
}
</style>
<div class="container vertical-center">
	<div class="row" id="login">
		<div class="col-md-12">
			<div class="form-group">
				<?php if(logo() != NULL){ ?>
					<img src="<?=uploaded_images_url() . logo()?>" style="width:130px; margin-top:3px;">
				<?php } else {?>
					<h2 class="text-primary"><?=title()?></h2>
				<?php } ?>
			</div>
			<form class="form" role="form" method="POST" action="<?=base_url()?>auth/login/admin" autocomplete="off" id="login-nav">
				<div class="form-group">
					<label class="sr-only" for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
				</div>
				<div class="form-group">
					<label class="sr-only" for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
					<div class="help-block text-right">
						<a href="<?=base_url() . "forgotpassword"?>">Forgot Password?</a>
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-block">Sign in</button>
				</div>
			</form>
		</div>
	</div>
</div>
