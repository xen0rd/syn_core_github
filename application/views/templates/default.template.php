<?php
echo link_tag(css_url()."bootstrap.css");
echo link_tag(css_url()."bootstrap-datepicker.css");
echo link_tag(css_url()."toastr.css");
echo link_tag(css_url()."admin-login.css");
?>
<html>
	<head>
		<meta charset="utf-8">
		<script src="<?=js_url().'jquery-3.1.1.min.js'?>"></script>
		<script src="<?=js_url().'bootstrap.js'?>"></script>
		<script src="<?=js_url().'bootstrap-datepicker.min.js'?>"></script>
		<script src="<?=js_url().'toastr.min.js'?>"></script>
		<style>
			body{
			  background: -webkit-radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
			  background: -o-radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
			  background: -moz-radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
			  background: radial-gradient(#e1e8ff, #cbd6fc, #bfceff);
			}
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
	</head>
	<body>
		<div class="c" id="c1"></div>
		<div class="c" id="c2"></div>
		<div class="c" id="c3"></div>
		<div class="c" id="c4"></div>
		<div class="c" id="c5"></div>
		<div class="c" id="c6"></div>
		<div class="c" id="c7"></div>
		<?=$content;?>
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