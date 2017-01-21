$(function() {
	//垃圾箱图片颜色更换
	$(".mydt").each(function() {
		$(this).find(".delete").hover(function() {
			$(this).find("img").attr("src", "/template/default/img/tc65.png");
		}, function() {
			$(this).find("img").attr("src", "/template/default/img/tc64.png");
		})
	})

	//回复框弹出
	$(".reply1").click(function() {
		$(this).parents(".conments").addClass("on").siblings().removeClass("on");
	})
	$(".reply1").click(function() {
		$(this).parents(".conments1").addClass("on").siblings().removeClass("on");
	})
	$(".reply1").click(function() {
		$(this).parents(".conments2").addClass("on").siblings().removeClass("on");
	})
	
	/*//改变点击按钮时的字
	$(".tz-btn").click(function() {
		$(this).val("正在发布");
		$(this).attr("disabled","disabled");
	})*/
	
	//点击出现弹框
	$(".jih-btn").click(function() {
		$(".duih-box").show();
	})
	$(".add-btn").click(function() {
		$(".addpic").show();
	})
	$(".addsec").click(function() {
		$(".crtsec").show();
	})
	//点击隐藏弹出框
	$(".jihuo-btn").click(function() {
		$(".duih-box").hide();
	})
	$(".add-title img").click(function() {
		$(".addpic").hide();
	})
	$(".add-title img").click(function() {
		$(".crtsec").hide();
		$(".crtsec2").hide();
		$(".crtsec3").hide();
	})
})

//全选复选框
function checkAll(c) {
	//获取所有的复选框
	var arr = document.getElementsByName('check');
	if(c) { //是否全选
		//遍历所有的复选框
		for(var i = 0; i < arr.length; i++) {
			arr[i].checked = true; //选中
		}
	} else { //否则，全不选
		//遍历所有的复选框
		for(var i = 0; i < arr.length; i++) {
			arr[i].checked = false; //不选中
		}
	}
}