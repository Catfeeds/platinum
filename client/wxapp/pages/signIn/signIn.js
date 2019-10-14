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
        selected: [{
            date: '2019-8-31'
        }, {
            date: '2019-9-02'
        }, {
            date: '2019-9-01'
        }, {
            date: '2019-9-04'
        }],
        signTxt:"签到"
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
    /**
     * 获取选择日期
     */
    packup(e) {
        var dd = this.selectComponent('#calendarbox').packup(e)
        console.log(dd)
        this.setData({signClass:"hadSign", signTxt:'已签到',modal_show:"modal_show"})

    },
   

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------