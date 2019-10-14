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
        date: '2010-01-01', //起始时间
        // date2: '2018-01-24', //终止时间
        appData: app.data, //拿到全局的数据
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        var date = new Date() ;
        var today =[date.getFullYear()+"-" + (date.getMonth()+1) + "-" + date.getDate()];
        var prevDate =[date.getFullYear()+"-" + (date.getMonth()-2) + "-" + date.getDate()];
        console.log(today)
        console.log(prevDate)
        this.setData({prevDate:prevDate,today:today,date:prevDate,date2:today})
        
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

    // 收益占比时间段选择
    bindDateChange(e) {
        console.log(e.detail.value)
        this.setData({
            date: e.detail.value,
            radioCheckVal: 0,
        })
    },
    bindDateChange2(e) {
        this.setData({
            date2: e.detail.value,
            radioCheckVal: 0,
        })
    }

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------