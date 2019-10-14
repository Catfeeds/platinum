$(document).ready(function() {

    //-----------------------------------------定义和初始化变量----------------------------------------
    var loadBox = $('aside.loadBox');
    var articleBox = $('article');
    var windowScale = window.innerWidth / 750;
    var domain = 'https://platinumtest.beats-digital.com/api'
    var uid = getQueryString('uid');

    //----------------------------------------页面初始化----------------------------------------
    init();

    function init() {
        requestAnimationFrame(function() {
            //          loadBox.show();
            
            $.ajax({
                type: "GET",
                url: domain + '/ext/get_user',
                dataType: 'json',
                async: true,
                data:{id:uid,sign:'e73dca805f04766e77a560b7f7dd22b9',timestamp:'1566529093'},
                success: function(res) {
                    $('.box .name').html(res.data.name)
                    console.log(res)

                },
                error: function() {
                    alert("网络可能存在问题，请刷新试试！");
                }
            });

            // 积分变动
            add_integral();

            share_reset();
            // window.addEventListener("hashchange", funcRef, false);

        });
    } //edn func

    // function funcRef () {
    //     alert(11)
    // }

    // 积分变动
    function add_integral() {
        var data = {
            num:0,
            id:1,
            'event':502,
            timestamp:'1566529748',
            sign:'ce00bab4886f5d99a9bf5792778f337b',
        }
        $.ajax({
            type: "POST",
            url: domain + '/ext/add_integral',
            dataType: 'json',
            async: true,
            data:data,
            success: function(res) {
                console.log(res)
                $('.score span').html(res.data.data)
            },
            error: function() {
                alert("网络可能存在问题，请刷新试试！");
            }
        });
        console.log(data)
    }



    // 分享重置发送给小程序
    function share_reset() {
        var domain = 'http://t.sky.be-xx.com/wxapp/2019/PlatinumWxApp/client/html/';
        var source = '来源'
        var title = '分享标题';
        var shareImageUrl = domain + 'images/share.jpg'
        wx.miniProgram.postMessage({
            data: {
                path: domain + '?source=' + source,
                imageUrl: shareImageUrl,
                title: title
            }
        })
    }
    // 获取url参数
    function getQueryString(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) { return pair[1]; }
        }
        return (false);
    }

    //----------------------------------------页面监测代码----------------------------------------
    function monitor_handler() {
        //      imonitor.add({obj:$('a.btnTest'),action:'touchstart',category:'default',label:'测试按钮'});
    } //end func
}); //end ready