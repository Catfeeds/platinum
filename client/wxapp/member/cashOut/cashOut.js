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
        showClass:'showClass1',
        list1:[{
            num:'88',
            isSuc:false
        },{
            num:'58',
            isSuc:false
        }],
        list2:[{
            num:'58',
            isSuc:false
        },{
            num:'58',
            isSuc:true
        }],
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        this.loadCoupon = true;

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
    tabChange(e){
            let { id } = e.currentTarget.dataset
            if(id==1){
                this.setData({showClass:'showClass1'})
            }else{
                if(this.loadCoupon){
                    this.loadCoupon = false;
                    // load电子券数据
                }
                this.setData({showClass:'showClass2'})
            }
        },

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------