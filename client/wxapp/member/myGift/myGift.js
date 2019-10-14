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
            id:'1',
        },{
            id:'2',
        }],
        list2:[{
            id:'1',
        },{
            id:'2',
        },{
            id:'3',
        }],
        list3:[{
            id:'1',
        },{
            id:'2',
        },{
            id:'3',
        },{
            id:'4',
        }],
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        this.loadlist2 = true;
        this.loadlist3 = true;

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
            }else if(id==2){
                if(this.loadlist2){
                    this.loadlist2 = false;
                    // load电子券数据
                }
                this.setData({showClass:'showClass2'})
            }else if(id==3){
                if(this.loadlist3){
                    this.loadlist3 = false;
                    // load电子券数据
                }
                this.setData({showClass:'showClass3'})
            }

        },

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------