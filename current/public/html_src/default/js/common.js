$(function(){
	$(".toggle .tag").on("click mouseenter",function(e){
		e.stopPropagation();
		$(this).parents(".toggle").find(".toggle_down").fadeIn();
	});
	$(".toggle").on("mouseleave",function(e){
		e.stopPropagation();
		$(this).find(".toggle_down").hide();
	});
	$(".t_d_txt").click(function(e){
		e.stopPropagation();
		var txt = $(this).html();
		$(this).parents(".toggle").find(".tag_txt").html(txt);
	})
	$(document).click(function(){
		$(".toggle").find(".toggle_down").hide();
	});
	
	$(".menu_box li").hover(function(){
		$(this).find(".menu_sub").show();
	},function(){
		$(this).find(".menu_sub").hide();
	})
})
