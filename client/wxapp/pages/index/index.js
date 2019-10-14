const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
//-------------------------------------------------------初始化-------------------------------------------------------
let SessionKey, OpenID, $query;


Page({
    data: {
        userInfo: {},
        hasUserInfo: false,
        showPhonebtn: true,
        bgmBtn: false,
        bgmPlay: false,
        active:'',
        showPhonePanel: false,
        appData: app.data //拿到全局的数据
    }, //页面的初始数据
    async onLoad(option) {
        // icom.OS();
        $query = option;
        console.log('getQueryString', option);
        app.initApp();
        if (option.redirectUrl) {
            let url = icom.combineUrl(option.redirectUrl, option);
            this.setData({
                redirectUrl: url
            })
        }
        await beats.member.signIn();
        this.setData({
            serverUserInfo: beats.member.serverUserInfo
        });
        
        /**
         * redirectUrl,如果从开屏页跳到其他页面需要参数时,调用icom.combineUrl()方法
         * 传入要跳转的页面和后面所带的参数
         * 如{id:55,ss:555}
         */
        
    },

    async getAuth(e) {
        let { auth, url } = e.currentTarget.dataset;
        console.log("auth:" + auth);
        console.log("url:" + url);
        if(beats.member.serverUserInfo){
            //证明已经注册并且获取过手机号码了，
        }
        if(this.data.active=='active'){
            if (!e.detail.encryptedData) {
                let content
                if (auth == 'getUserInfo') {
                    content = '该小程序需要获取您的昵称和头像,请您允许该小程序访问您的个人信息。'

                    //如果用户拒绝了授权就去获取手机号码
                    this.setData({ showPhonebtn: false })
                    return;
                } else if (auth == 'getPhoneNumber') {
                    content = '该小程序需要获取您的手机号,请您允许该小程序访问您的手机号。'
                }
                wx.showModal({
                    title: '提示',
                    content: content,
                    showCancel: false
                })
            } else {
                if (auth == 'getUserInfo') {
                    // this.setData({ showPhonebtn: false })
                    let res = await beats.member.getUserInfo(e.detail);
                    console.log(res)
                    // token 为空 未获取手机号码
                    if(res.data.token==''){
                         this.setData({ showPhonebtn: false })
                     }else{
                        this.gotoNextPage();
                     }
                } else if (auth == 'getPhoneNumber') {
                    let res = await beats.member.getPhoneNumber(e.detail);
                    this.gotoNextPage();
                }
            }
        }else{
             wx.showToast({
                title: '请同意收取个人信息',
                icon: 'none'
            })
        }
        
    },
    onShow: function() {
        // if (app.bgm){
        //     app.bgm.reShow();
        // }//edn if
    }, //监听页面显示
    onHide: function() {}, //监听页面隐藏
    onShareAppMessage: function() { //用户点击右上角分享
        return app.setShareData();
    },
    gotoNextPage() {
        let redirectUrl
        // 是否领取过卡券
        if(false){
              redirectUrl = this.data.redirectUrl || icom.combineUrl('/pages/home/home', $query);
        }else{
              redirectUrl =  icom.combineUrl('/pages/giftCertificates/giftCertificates', $query);
        }
       
        wx.redirectTo({ url: decodeURIComponent(redirectUrl) })
    },
    agree(){
        if(this.data.active==''){
            this.setData({active:'active'})
        }else{
            this.setData({active:''})
        }
    },
}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------