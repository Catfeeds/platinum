const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
//-------------------------------------------------------初始化-------------------------------------------------------
let  $query, SessionKey, OpenID;
let titArr = ['铂金小程序','积分商城' , '会员卡']

Page({
    data: {
        userInfo: {},
        hasUserInfo: false,
        showIndex: 0,
        title:"铂金小程序",
        appData: app.data //拿到全局的数据
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        app.initApp();
        await beats.member.getUserInfo();
        // 获取用户信息可以去掉
        if(option.shopId){
            console.log(option.shopId);
            this.setData({modal_show:'modal_show'})
        }
        if(option.showIndex){
            this.setData({showIndex:option.showIndex,title:titArr[option.showIndex]})
        }
        let data = await API.userinfo();
        console.log(data)
    },
    onReady: function() {}, //监听页面初次渲染完成
    onShow: function() {
        // if (app.bgm){
        //     app.bgm.reShow();
        // }//edn if
    }, //监听页面显示
    onHide: function() {}, //监听页面隐藏
    onShareAppMessage: function() { //用户点击右上角分享
        return app.setShareData();
    },
    myCard(){
        this.setData({modal_show:''})
        wx.navigateTo({url:'/member/myCard/myCard'})
    },

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------