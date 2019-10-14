const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
//-------------------------------------------------------初始化-------------------------------------------------------
let $query, SessionKey, OpenID;

Page({
    data: {
        userInfo: {},
        hasUserInfo: false,
        appData: app.data, //拿到全局的数据
        showCoupon:'showCoupon1',
        showGiftClass:'showGiftClass1',
        showCouponClass:'showCouponClass1',

    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        app.initApp();    
        await beats.member.getUserInfo();
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
    couponDetail(e){
        wx.navigateTo({url:'/member/couponDetail/couponDetail'})
    },
    // 头部切换
    conponChage(e){
        let {id} = e.currentTarget.dataset
        this.setData({showCoupon:id==1?'showCoupon1':'showCoupon2'})
    },

    tabChange1(e){
        let {id} = e.currentTarget.dataset;
        if(id==1){
            this.setData({showGiftClass:'showGiftClass1'})
        }else if(id==2){
            this.setData({showGiftClass:'showGiftClass2'})
        }else if(id==3){
            this.setData({showGiftClass:'showGiftClass3'})
        }
    },

    tabChange2(e){
        let {id} = e.currentTarget.dataset;
        if(id==1){
            this.setData({showCouponClass:'showCouponClass1'})
        }else if(id==2){
            this.setData({showCouponClass:'showCouponClass2'})
        }else if(id==3){
            this.setData({showCouponClass:'showCouponClass3'})
        }
    },



}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------