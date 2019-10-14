var API = {
    DOMAIN: "",               //正式
    DEBUG: true,

    

    _send: function(method, data, success){
        //有自己的openid并且data里面不带openid才赋值
        // if (API.OpenID && !data.hasOwnProperty('OpenID'))data.OpenID = API.OpenID;

        $.ajax({
            url: "https://" +  API.DOMAIN + "BountychallengesApi.ashx?method=" + method,
            type:"POST",
            data: data,
            dataType: 'json',
            //async: true,
            success: function(res) {
                if (API.DEBUG){
                    console.log(method + "——success");
                    console.log(res);
                }
                
                if(res && res.errcode != 0){
                    if (success) success(res);
                }else{
                    if (success) success(res);
                }
                
            },
            error: function(res) {
                if (API.DEBUG) {
                    console.log(method + "——fail");
                    console.log(res);
                }
                
                if (success) success(null);
            }
        });

    },
    /**
     * 登录
     * @params Function success 回调函数 如果回调为null说明服务器报错了或者errcod非0
     */
    Login: function(account, psw, success){
        setTimeout(function(){
            success({
                code: 200,
                data: {}
            });
        }, 500);
    },
    /**
     * 核销code
     * @param {*} code 
     * @param {*} success 
     */
    Code: function(code, success){
        setTimeout(function(){
            success({
                code: 200,
                data: {}
            });
        }, 500);
    },

    /**
     * 获取可以核销的列表
     * @param {Number} mobile 手机号码
     * @param {*} success 
     */
    GetTicketList: function(mobile, success){
        setTimeout(function(){
            var len = imath.randomRange(1,10);
            var arr = [];
            for(var i = 0; i < len; i++){
                arr.push(i);
            }
            success({
                code: 200,
                data: arr
            });
        }, 500);
    },

    /**
     * 小票初审
     * 
     */
    ToTicket:function(id, type, success){

    }


}
