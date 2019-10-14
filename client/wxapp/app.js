const config = require('config.js');
import icom from 'common/js/base/com.js';
import Init from 'common/js/base/init.js';
import API from 'common/js/API.js';
let idArr = ['#index', '#member', '#integralMall']
let titArr = ['铂金小程序','积分商城' , '会员卡']
let Scene = ""; //来源
let SceneValue = ""; //场景值
App({
    onLaunch: function(options) {
        this.launchoptions = options;
        console.log(options)
        this.API = new API(); // new 一下API.js, 这样每个页面都可以拿到
        this.icom = icom;
        this.config = config;
        // this.bgm = bgm;
        Scene = options.query.scene ? options.query.scene : "defualt";
        SceneValue = options.scene ? options.scene : "defualt";
        this.beats = new Init({ Scene: Scene, SceneValue: SceneValue, API: this.API }); //new 一下init.js,这样每个页面都可以拿到
        this.API.setbeats(this.beats);
        wx.getSystemInfo({
            success: (res) => {
                this.data.navigationPadding = res.statusBarHeight + 'px' //状态栏高度
                this.data.navigationHeight = (icom.OS().ios ? 44 : 48) + 'px'
                this.data.articleHeight = 'calc( 100%' + ' - ' + (parseInt(this.data.navigationHeight) + parseInt(this.data.navigationPadding)) + 'px)';
            }
        })

        //播放背景音乐
        // this.bgm = require('common/js/base/bgm.js');
        // this.bgm.on({ src: 'http://t.sky.be-xx.com/wxapp/wxapp_frame/sound/bgm.mp3'});
    },

    initApp: function() {
        let pages = getCurrentPages();
        let page = pages[pages.length - 1];
        page.footclick = this.footclick;
        page.toIntegraMall = this.toIntegraMall;
        page.toMember = this.toMember;

        page.back = this.back;
        page.home = this.home;
        page.modalHide = this.modalHide;
        page.alertHide = this.alertHide;



        // if (this.bgm.playing) {
        //   page.setData({ bgmPlay: "bgmPlay"})
        // } else {
        //   page.setData({ bgmPlay: "bgmStop"})
        // }
    },
    footclick(e) {
        wx.showModal({
            title: '提示',
            content: '敬请期待'
        })
        return;
        let { index } = e.currentTarget.dataset;
        this.toIndex(index);
    },
    toIntegraMall(){
        this.toIndex(1);
    },
    toMember(){
        this.toIndex(2);
    },
    /**
     * 全局参数
     * */
    data: {
        articleHeight: '',
        navigationHeight: '',
        navigationPadding: '',
        webUrl:config.webUrl
    },
    //初始化 end
    setShareData: function(options) {
        let defaults = {
            title: config.shareData.title,
            path: config.shareData.path,
            imageUrl: config.shareData.imageUrl,
        };
        let opts = {};
        Object.assign(opts, defaults, options);
        opts.path = icom.combineUrl(opts.path, { OpenID: config.OpenID, SessionKey: config.SessionKey });
        console.log(opts);
        return {
            title: opts.title,
            path: opts.path,
            imageUrl: opts.imageUrl
        };
    },
    // 返回首页并切换到几个
    toIndex(index) {
        let len = getCurrentPages().length;
        if (len > 1) {
            wx.navigateBack({
                delta: len - 1,
                complete: () => {
                    let pages = getCurrentPages();
                    let page = pages[pages.length - 1];
                    page.setData({ showIndex: index, title: titArr[index] })
                    page.selectComponent(idArr[index]).updateData();
                }
            })
        } else {
            let pages = getCurrentPages();
            let page = pages[pages.length - 1];
            let curp = pages[pages.length - 1].route;
            if (curp == 'pages/home/home') {
                page.setData({ showIndex: index, title: titArr[index] })
            } else {
                wx.redirectTo({ url: '/pages/home/home?showIndex='+index});
            }

        }
    },
    home() {
        this.toIndex(0);
    },

    back() {
        wx.navigateBack();
    },
    modalHide(){
        let pages = getCurrentPages();
        let page = pages[pages.length - 1];
        page.setData({modal_show:''})
    },
    alertHide(){
        let pages = getCurrentPages();
        let page = pages[pages.length - 1];
        if( page.data.alert.fn) page.data.alert.fn();
        page.setData({'alert.txt':'','alert.fn':''})
    },

    bgmClick: function() { //背景音乐按钮点击事件
        bgm.click();
    },
    onShow: function() {
        // if (this.bgm.stopByAppHide && this.bgm.playing){
        //     this.bgm.stopByAppHide = false;
        //     this.bgm.play();
        // }//edn if
    },

    onHide: function() {
        // this.bgm.stopByAppHide=true;
    },
})