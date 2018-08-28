$(function(){	
	$(".cart-button").click(function(){
		$(".cart-button").hide();
		$("#cart-content").show(function(){
			$(this).animate({"width" : "800px", "height" : "500px"}, function(){
				
			});
		});
	});
	
	$("#cart-close").click(function(){
		$("#cart-content").animate({"width" : "0px", "height" : "0px"}).hide();
		$(".cart-button").show();
	});

	$(".itemQuantity").change(function(){
		$(this).next().attr("disabled", false);
		var href = $(this).next().attr("href");
		var newHref = href.substr(0, href.lastIndexOf("/") + 1);
		$(this).next().attr("href",  newHref + $(this).val());
	});
	
});