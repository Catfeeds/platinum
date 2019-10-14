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
        address:{
            name:'ELSA',
            tel:'18500000000',
            add:'广东省中山市中山路888号甲单元A栋101室',
        },
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        app.initApp();    
        await beats.member.getUserInfo();
        // 如果没有地址
        this.setData({noAdd:'noAdd'})

        this.setData({
            giftInfo:{
                price:2500,
                num:1,
                total:2500
            }
        })


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
    addnumber(e) {
        let { id } = e.currentTarget.dataset
        if (id == 1 && this.data.giftInfo.num != 1) {
            this.setData({
                'giftInfo.num': --this.data.giftInfo.num,
                'giftInfo.total':this.data.giftInfo.num*this.data.giftInfo.price
            })
        } else if (id == 2) {
            this.setData({
                'giftInfo.num': ++this.data.giftInfo.num,
                'giftInfo.total':this.data.giftInfo.num*this.data.giftInfo.price
            })
        }
    },
    immediateExchange(){
        if(this.data.noAdd=='noAdd'){
            this.setData({ 'alert.txt': '您的地址有误！' })
        }
    },

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------