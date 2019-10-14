$(document).ready(function(){
	
	//-----------------------------------------定义和初始化变量----------------------------------------
	var loadBox=$('aside.loadBox');
	var articleBox=$('article');
	var windowScale=window.innerWidth/750;
	
	var loginUI = $('.loginUI');
	var homeUI = $('.homeUI');
	var sucUI = $('.sucUI');
	
	//----------------------------------------页面初始化----------------------------------------
	icom.init(init);//初始化
	icom.screenScrollUnable();//如果是一屏高度项目且在ios下，阻止屏幕默认滑动行为

	/**
	 * 微博授权拿用户信息
	 */
	// icom.weiboSign(function(weiboUserInfo){
	// 	console.log(weiboUserInfo)
	// 	$('article').html('<img src="'+weiboUserInfo.avatar+'"><div>'+weiboUserInfo.nickname+'<div>')
	// });

	/**
	 * android 页面键盘遮挡输入框BUG
	 * @param {scrollbox:div,type:'transform',space:50}
	 * scrollbox：滚动容器
	 * type：scroll|transform 滚动类型
	 * space：键盘弹出时键盘顶部与输入框之间的间距
	 */
	// icom.androidKeyboard({ scrollbox: $('#aaa'), type: 'scroll', space: 100 });
	
	/**
	 * 短信验证码倒计时方法， 在btn click方法中调用
	 */
	// icom.countdown($('#btn'), 60, '#s秒后重新获取');
	
	function init(){
		requestAnimationFrame(function(){
			loadBox.show();
			// icom.fadeIn(articleBox);
			load_handler();
		});
	}//edn func
	

	//----------------------------------------加载页面图片----------------------------------------
	function load_handler(){
		var loader = new PxLoader();
		loader.addImage('images/common/turn_phone.png');
		
		loader.addImage('images/home/bg.jpg');
		loader.addImage('images/home/btn.png');
		loader.addImage('images/home/icon.png');
		loader.addImage('images/home/logo.png');
		loader.addImage('images/home/suc.jpg');
		loader.addImage('images/home/suc_icon.png');
		loader.addImage('images/home/tip_box.png');
		loader.addImage('images/home/close.png');
		
		//实际加载进度
//		loader.addProgressListener(function(e) {
//			var per=Math.round(e.completedCount/e.totalCount*50);
//			loadPer.html(per+'%');
//		});
		
		loader.addCompletionListener(function() {
			init_handler();
//			load_timer(50);//模拟加载进度
			loader=null;
		});
		loader.start();	
	}//end func
	
	//模拟加载进度
	function load_timer(per){
		per=per||0;
		per+=imath.randomRange(1,3);
		per=per>100?100:per;
		loadPer.html(per+'%');
		if(per==100) setTimeout(init_handler,200);
		else setTimeout(load_timer,33,per);
	}//edn func
	
	//----------------------------------------页面逻辑代码----------------------------------------
	function init_handler(){
		console.log('init handler');
		icom.fadeOut(loadBox,500);
		articleBox.show();
		initUI();
		monitor_handler();		
	}//end func

	function initUI(){

		var loginAccount = loginUI.find('.account');
		var loginPassword = loginUI.find('.password');
		var loginBtn = loginUI.find('.btnLogin');

		var homeUI = $('.homeUI');
		var homeBtnCode = homeUI.find('.btnCode');

		var sucUI = $('.sucUI');
		var sucBtn = sucUI.find('.btnBack');


		//登陆
		loginBtn.on('click', function(){
			var account = loginAccount.val(); 
			var password = loginPassword.val();
			if(account == ""){
				tipMsg('请输入账号');
			}else if(password == ""){
				tipMsg('请输入密码');
			}else{
				toLogin(account, password);
			}
		})
		//唤起扫码
		homeBtnCode.on('click', function(){
			if(os.weixin){
				wx.scanQRCode({
					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					scanType: ["qrCode"], // 可以指定扫二维码还是一维码，默认二者都有
					success: function (res) {
						toCode(res.resultStr);
					}
				});
			}else{
				toCode('abc');
			}
		})
		//核销页返回
		sucBtn.on('click', function(){
			icom.fadeOut(sucUI);
		})
	}

	function toLogin(account, password){
		loadBox.show();
		API.Login(account, password, function(res){
			loadBox.hide();
			icom.fadeIn(homeUI);
		});
	}
	function toCode(code){
		loadBox.show();
		API.Code(code, function(res){
			loadBox.hide();
			icom.fadeIn(sucUI);
		});
	}


	function tipMsg(word, callback){
		var tipUI = $('.tipUI');
		tipUI.find('.info p').html(word);
		tipUI.find('.close').one('click', function(){
			icom.fadeOut(tipUI);
			if(callback)callback();
		})

		icom.fadeIn(tipUI);
	}

	
	//----------------------------------------页面监测代码----------------------------------------
	function monitor_handler(){
//		imonitor.add({obj:$('a.btnTest'),action:'touchstart',category:'default',label:'测试按钮'});
	}//end func
});//end ready
