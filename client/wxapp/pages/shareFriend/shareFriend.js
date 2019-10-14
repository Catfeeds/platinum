const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
//-------------------------------------------------------初始化-------------------------------------------------------
let $query, SessionKey, OpenID;
let shareObj = {};
Page({
    data: {
        userInfo: {},
        hasUserInfo: false,
        appData: app.data, //拿到全局的数据
        topFive:[{
            avtar:'/images/shareFriend/avtar1.png'
        },{
            avtar:'/images/shareFriend/avtar2.png'
        },{
            avtar:'/images/shareFriend/avtar1.png'
        },{
            avtar:'/images/shareFriend/avtar2.png'
        },{
            avtar:'/images/shareFriend/avtar3.png'
        }],
        list:[{
            avtar:'/images/shareFriend/avtar1.png',
            nickname:"昵称1",
            date:'2019-10-1'
        },{
            avtar:'/images/shareFriend/avtar2.png',
            nickname:"昵称2",
            date:'2019-10-12'
        },{
            avtar:'/images/shareFriend/avtar3.png',
            nickname:"昵称3",
            date:'2019-10-13'
        },{
            avtar:'/images/shareFriend/avtar1.png',
            nickname:"昵称1",
            date:'2019-10-4'
        }],
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        app.initApp();    
        await beats.member.getUserInfo();
        shareObj = {//重置分享
            // title: '~',
          path: 'pages/index/index?scene=share',
            // imageUrl: '/images/share.jpg'
        }
    },
    onShow: function() {
        // if (app.bgm){
        //     app.bgm.reShow();
        // }//edn if
    }, //监听页面显示
    onHide: function() {}, //监听页面隐藏
    onShareAppMessage: function() { //用户点击右上角分享
        return app.setShareData(shareObj);
    }

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------