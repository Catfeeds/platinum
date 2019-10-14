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
        ARmodal_show:''
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
    arBtn(){
        console.log(1111)
        this.setData({ARmodal_show:'ARmodal_show'})
    },
   


}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------