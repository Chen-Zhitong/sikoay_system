$(window).ready(function(){
	$(".classhome-right-nav ul li a").each(function(){
		$(this).bind("click",function(){
			if($(this).hasClass("classhome-nav-click")){
				$(this).removeClass("classhome-nav-click");
				$(this).children("span").removeClass("glyphicon-menu-up");
				$(this).children("span").addClass("glyphicon-menu-down");
				$(this).parent().children(".classhome-right-hide").css("display","none");
			}else{
				$(".classhome-right-nav ul li a").removeClass("classhome-nav-click");
				$(".classhome-right-nav ul li").children(".classhome-right-hide").css("display","none");
				$(this).addClass("classhome-nav-click");
				$(".classhome-right-nav ul li a").children("span").removeClass("glyphicon-menu-up");
				$(this).children("span").addClass("glyphicon-menu-up");
				$(this).parent().children(".classhome-right-hide").css("display","block");
			}
		})
	})
	$(".classvideo-detail-left-lists li a").each(function(){
		$(this).bind("click",function(){
			$(this).parent().children("ul").slideToggle();
			if ($(this).children("span").hasClass("glyphicon-menu-right")) {
				$(this).children("span").removeClass("glyphicon-menu-right");
				$(this).children("span").addClass("glyphicon-menu-down")
			}else{
				$(this).children("span").removeClass("glyphicon-menu-down");
				$(this).children("span").addClass("glyphicon-menu-right")
			}
		})
	})
	$(".classplay-head-vip>img").bind("click",function(){
		$(".classplay-vip-option").toggle();
	})
	$("#classvideo-list").bind("click",function(){
		$(".classvideo-note").css("display","none");
		$(".classvideo-ask").css("display","none");
		$(".classvideo-list").toggle();
	})
	$("#classvideo-note").bind("click",function(){
		$(".classvideo-ask").css("display","none");
		$(".classvideo-list").css("display","none");
		$(".classvideo-note").toggle();
	})
	$(".cancle").click(function(){
		$(this).parent("div").fadeOut();
		$(".practice-analyze").fadeOut();
	})
	$("#classvideo-ask").bind("click",function(){
		$(".classvideo-list").css("display","none");
		$(".classvideo-note").css("display","none");
		$(".classvideo-ask").toggle();
	})
	$("#classvideo-write").bind("click",function(){
		$(".classvideo-list").css("display","none");
		$(".classvideo-note").css("display","none");
		$(".classvideo-ask").css("display","none");
		$(".classplay-bottom-left>ul li a").eq(2).click();
		$(document).scrollTop(580);
	})
	$(".invite-code").click(function(){
		var x = $(this).children("input").prop("checked");
		if (x==true) {
			$(".input-invite-code").fadeIn();
		}else{
			$(".input-invite-code").fadeOut();
		}
	})
	$(".datacenter-practice-list li").children("div").each(function(){
		$(this).mouseenter(function(){
			$(this).children(".practice-list-word").stop().animate({top:"54px"});
		})
		$(this).mouseleave(function(){
			$(this).children(".practice-list-word").stop().animate({top:"125px"});
		})
	})
	$(".datacenter-practice-right-bottom ul li").children("div").each(function(){
		$(this).mouseenter(function(){
			$(this).children(".practice-list-word").stop().animate({top:"54px"});
		})
		$(this).mouseleave(function(){
			$(this).children(".practice-list-word").stop().animate({top:"100px"});
		})
	})
	function showanalyze(){
		$(".practice-analyze").fadeIn();
		$(".classvideo-note").fadeIn();
	}
/*	function practice(){
		var a = $(".autonext").prop("checked");
		var x = $("#true-answer").html();
		if (a==true) {
			if (true) {}
		}else{
			$()
		}
	}*/
	$(".menu_txt").click(function(){
			$(".menu_box").slideToggle();
		})
	$(".payment ul li label").click(function(event){
		event.stopPropagation();
	})
	$(".pay-choose").bind("click",function(){
		choosethese(this);
		$(".buy-all").children("input").prop("checked",false);
		cost();
		total();
		return false;
		
	})
	$(".payment ul li ul li label").click(function(){
		if ($(this).children("input").prop("checked")==true) {
			$(this).parent().parent().parent().parent().children("a").children("label").children("input").prop("checked",false);
			$(".buy-all").children("input").prop("checked",false);
		}
		cost();
		total();
	})
	$(".buy-all").bind('click',function(){
		if ($(this).children("input").prop("checked")==false) {
			$(".payment ul li label").children("input").prop('checked',false);
			$(".pay-cost").children("span").html("￥0.00");
		}else{
			$(".payment ul li label").children("input").prop('checked',true);
			
			var buyall = $(this).children(".payment-price").html();
			$(".pay-cost").children("span").html(buyall);
		}
		cost();
		
	})
	$("#maizhengtao").click(function () {
	    var a = $(this).data("jiage");
	    layer.confirm('整套优惠价格：￥'+a, {
	        btn: ['立即整套购买', '取消'] 
	    }, function () {
	        $("#order-form").submit();
	    }, function () {
	        
	    });
		
    })
	$(".openhuifu").click(function(){
		$(this).parent().parent().children(".group-detail-list-hide").slideToggle();
	})
	$(".gruop-list-answer-this").each(function(){
		$(this).click(function(){
			var x = $(this).parent().children("div").children("a").html();
			$(this).parent().parent().parent().children(".group-detail-list-answer").find("textarea").val("回复 "+x+" :");
		})
	})
	$("#sortbys").click(function(){
		if ($(this).children("a").eq(0).hasClass("active")) {
			$(this).children("a").eq(0).children("img").attr("src","/template/default/img/group-icon3.png");
		}else{
			$(this).children("a").eq(0).children("img").attr("src","/template/default/img/group-icon3-not.png");
		}
		if ($(this).children("a").eq(1).hasClass("active")) {
			$(this).children("a").eq(1).children("img").attr("src","/template/default/img/group-icon4-on.png");
		}else{
			$(this).children("a").eq(1).children("img").attr("src","/template/default/img/group-icon4.png");
		}
		if ($(this).children("a").eq(2).hasClass("active")) {
			$(this).children("a").eq(2).children("img").attr("src","/template/default/img/group-icon6-on.png");
		}else{
			$(this).children("a").eq(2).children("img").attr("src","/template/default/img/group-icon6.png");
		}
	})
	$("#sortbys").children("a").eq(0).mouseenter(function(){
		$(this).children("img").attr("src","/template/default/img/group-icon3.png");
	})
	$("#sortbys").children("a").eq(0).mouseleave(function(){
		if ($(this).hasClass("active")) {
			$(this).children("img").attr("src","/template/default/img/group-icon3.png");
		}else{
			$(this).children("img").attr("src","/template/default/img/group-icon3-not.png");
		}	
	})
	$("#sortbys").children("a").eq(1).mouseenter(function(){
		$(this).children("img").attr("src","/template/default/img/group-icon4-on.png");
	})
	$("#sortbys").children("a").eq(1).mouseleave(function(){
		if ($(this).hasClass("active")) {
			$(this).children("img").attr("src","/template/default/img/group-icon4-on.png");
		}else{
			$(this).children("img").attr("src","/template/default/img/group-icon4.png");
		}	
	})
	$("#sortbys").children("a").eq(2).mouseenter(function(){
		$(this).children("img").attr("src","/template/default/img/group-icon6-on.png");
	})
	$("#sortbys").children("a").eq(2).mouseleave(function(){
		if ($(this).hasClass("active")) {
			$(this).children("img").attr("src","/template/default/img/group-icon6-on.png");
		}else{
			$(this).children("img").attr("src","/template/default/img/group-icon6.png");
		}	
	})
})
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
function choosethese(e){
	var x = $(e).children("input").prop("checked");
	if (x==true) {
		$(e).children("input").prop("checked",false);
		$(e).parent("a").parent("li").children("ul").children("li").children("a").children("label").children("input").prop("checked",false);
	}else{
		$(e).parent("a").parent("li").children("ul").children("li").children("a").children("label").children("input").prop("checked",true);
		$(e).children("input").prop("checked",true);
	}
}
function cost(){
	var cost = 0;
	var price = new Array();
	var num = $(".classvideo-detail-left-lists").children("li").length;
	var i;
	var j;
	for(j=0;j<num;j++){
		var cost = 0;
		var staffnum = $(".classvideo-detail-left-lists").children("li").eq(j).children("ul").children("li").length;
		for(i=0;i<staffnum;i++){
			var x = $(".classvideo-detail-left-lists").children("li").eq(j).children("ul").children("li").eq(i).find(".pay-single").children("input").prop("checked");
			if (x==false) {
				continue;
			}
			price[i] = $(".classvideo-detail-left-lists").children("li").eq(j).children("ul").children("li").eq(i).find(".pay-single").children(".payment-price").children("b").html();
			cost = cost+parseFloat(price[i]);
		}
		$(".classvideo-detail-left-lists").children("li").eq(j).data("cost",cost);
	}
}
function total(){
	var num = $(".classvideo-detail-left-lists").children("li").length;
	var total = 0;
	var i;
	var cost = new Array();
	for(i=0;i<num;i++){
		cost[i] = $(".classvideo-detail-left-lists").children("li").eq(i).data("cost");
		total = total+parseFloat(cost[i]);
	}
	$(".pay-cost").children("span").html("￥"+total.toFixed(2));
}
function bofangqi(shipindizhi) {
    var flashvars = {
        f: shipindizhi,
        
        c: 0,
        p: 1,
        b: 1,
        h: 4,
    };
    var params = { bgcolor: '#000', allowFullScreen: true, allowScriptAccess: 'always', wmode: 'transparent' };
    CKobject.embedSWF('/template/default/ckplayer/ckplayer.swf', 'classvideo', 'ckplayer_a1', '100%', '100%', flashvars, params);
}
function bofangqi2(shipindizhi) {
    var flashvars = {
        f: shipindizhi,
        c: 0,
        p: 1,
        b: 1,
        h: 4,
  
    };
    var video = [shipindizhi+'->video/mp4']
    var support = ['all'];
    var params = { bgcolor: '#000', allowFullScreen: true, allowScriptAccess: 'always', wmode: 'transparent' };
    CKobject.embed('/template/default/ckplayer/ckplayer.swf', 'classvideo', 'ckplayer_a1', '100%', '100%', true, flashvars, video);
}
function video_Load(yonghuming, id, jiage, shipindizhi,kechengid)
{
    if (parseFloat(jiage) > 0) {
        if (yonghuming == "") {
            //如果用户没有登录
            CKobject.getObjectById('ckplayer_a1').videoPause();//暂停播放
            layer.confirm('您还没有登录！请登录', {
				btn: ['立即登录','返回'] //按钮
			}, function(){
				window.location.href="/single.aspx?m=login";
			}, function(){
				history.go(-1)
			});
            //end
        }
        else {
            //如果用户登录了
            $.ajax({
                type: 'get',
                url: '/video_Load.aspx?id=' + id,
                success: function (data) {

                    if (data == "") {
                        //没有购买
                        CKobject.getObjectById('ckplayer_a1').videoPause();//暂停播放
                        layer.confirm('您还没有购买！请购买', {
						  btn: ['立即购买','返回'] //按钮
						}, function(){
						  window.location.href="/single.aspx?m=cart&laiyuanbianhao="+kechengid;
						}, function(){
						  history.go(-1)
						});
                        
                        //end
                    }
                    else {
                        //已购买
                        //bofangqi(shipindizhi);
                        //end
                    }
                }
            })
            //end
        }
    }
    else {
        //免费的
        //bofangqi(shipindizhi);
        //end
    }
    
}
//打开课程页面提醒
function video_alert(yonghuming, id, jiage, kechengid) {
    if (parseFloat(jiage) > 0) {
        if (yonghuming == "") {
            //如果用户没有登录

            layer.confirm('本视频为收费视频，可免费观看5分钟', {
                btn: ['立即登录', '关闭'] //按钮
            }, function () {
                window.location.href = "/single.aspx?m=login";
            }, function () {
                
            });
            //end
        } else {
            $.ajax({
                type: 'get',
                url: '/video_Load.aspx?id=' + id,
                success: function (data) {

                    if (data == "") {
                        //没有购买
                        
                        layer.confirm('本视频为收费视频，可免费观看5分钟', {
                            btn: ['立即购买', '关闭'] //按钮
                        }, function () {
                            window.location.href = "/single.aspx?m=cart&laiyuanbianhao=" + kechengid;
                        }, function () {
                            
                        });

                        //end
                    }
                    else {
                        //已购买
                        //bofangqi(shipindizhi);
                        //end
                    }
                }
            })
        }
       
    }
    
}
//打开课程页面提醒end
function video_Load_(yonghuming, id, jiage, kechengid) {
    if (parseFloat(jiage) > 0) {
        if (yonghuming == "") {
            //如果用户没有登录
            $("#buyanniu").html("<a href=\"/single.aspx?m=cart&laiyuanbianhao=" + kechengid + "\" class=\"buy\">购买课程</a>            <a href='/single.aspx?m=kecheng_shipin&id=" + kechengid + "&shipin=" + id + "' class=\"tring\">试听</a>");
            //end
        }
        else {
            //如果用户登录了
            $.ajax({
                type: 'get',
                url: '/video_Load.aspx?id=' + id,
                success: function (data) {

                    if (data == "") {
                        //没有购买
                        $("#buyanniu").html("<a href=\"/single.aspx?m=cart&laiyuanbianhao=" + kechengid + "\" class=\"buy\">购买课程</a>            <a href='/single.aspx?m=kecheng_shipin&id=" + kechengid + "&shipin=" + id + "' class=\"tring\">试听</a>");
                        //end
                    }
                    else {
                        //已购买
                        $("#buyanniu").html("<a href='/single.aspx?m=kecheng_shipin&id=" + kechengid + "&shipin=" + id + "' class=\"buy\">学习</a>");
                        //end
                    }
                }
            })
            //end
        }
    }
    else {
        //免费的
        $("#buyanniu").html("<a href='/single.aspx?m=kecheng_shipin&id=" + kechengid + "&shipin=" + id + "' class=\"buy\">免费学习</a>");
        //end
    }

}
function order_Load(yonghuming, id, type) {
   
    if (yonghuming == "") {
        //如果用户没有登录
        layer.confirm('您还没有登录！请登录', {
				btn: ['立即登录','返回'] //按钮
			}, function(){
				window.location.href="/single.aspx?m=login&tipurl=http://new.huayujy.com/default.aspx";
			}, function(){
				history.go(-1)
			});
        $("#neirong").html("<a href=\"/single.aspx?m=login&tipurl=http://new.huayujy.com/default.aspx\" class=\"btn_login\"><em class=\"icon-user\"></em> 用户登录</a>");
        //end
    }
    else {
        //如果用户登录了
        $.ajax({
            type: 'get',
            url: '/order_Load.aspx?type=' + type + '&id=' + id,
            success: function (data) {
              
                if (data == "") {
                    //没有购买
                  	
                    if (type == "kepuzhishi") {
                        $("#neirong").html("<div class=\"center\">					<p style=\"color: #1dbca6;\">该内容为收费内容，购买即可浏览！</p>					<br />\
				     <a href=\"/Single.aspx?m=goumai&id=" + id + "&t=zhishi_order\" class=\"btn_buy\" style=\"margin-top:5px\">立即购买</a>				</div>");
                        layer.confirm('该内容为收费内容，购买即可浏览！', {
						  btn: ['立即购买','返回'] //按钮
						}, function(){
						  window.location.href="/Single.aspx?m=goumai&id=" + id + "&t=zhishi_order";
						}, function(){
						  history.go(-1)
						});
                    }
                    if (type == "wendang") {
                     
                        $("#neirong").html("<div class=\"center\">					<p style=\"color: #1dbca6;\">该内容为收费内容，购买即可浏览！</p>					<br />\
				     <a href=\"/Single.aspx?m=goumai&id=" + id + "&t=wd_order\" class=\"btn_buy\" style=\"margin-top:5px\">立即购买</a>				</div>");
                        layer.confirm('该内容为收费内容，购买即可浏览！', {
						  btn: ['立即购买','返回'] //按钮
						}, function(){
						  window.location.href="/Single.aspx?m=goumai&id=" + id + "&t=wd_order";
						}, function(){
						  history.go(-1)
						});
                    }
                    //end
                }
                else {
                    //已购买
                    if (type == "kepuzhishi")
                    {
                        $("#neirong").html(data);
                    }
                    if (type == "wendang") {
                        $("#neirong").html("<iframe src='/template/default/pdf/web/viewer.html?file="+data+"' width=\"100%\" height=\"600\"></iframe>");
                    }
                    //end
                }
                return data;
            }
        })
        //end
    }
}
