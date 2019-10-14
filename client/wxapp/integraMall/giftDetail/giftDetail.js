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
        getWay: {
            val: '',
            arr: ['物流', '到店领取'],
            id: 0,
        },
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
    giftExchange(){
        wx.navigateTo({url:'/integraMall/giftExchange/giftExchange'})
    },
    getWayChange(e) {
        this.setData({ 'getWay.id': e.detail.value, 'getWay.val': this.data.getWay.arr[e.detail.value] })
    },

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------