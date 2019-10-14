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
        upPic:'',
        nickname:''
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);

        app.initApp();    
        await beats.member.getUserInfo();
        this.setData({upPic:this.data.userInfo.avatarUrl})

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
    upImg() {
        console.log(111111)
        wx.chooseImage({
            success:(res) =>{
                this.setData({
                    upPic: res.tempFilePaths
                })
                // wx.uploadFile({
                //   url: app.data.domain+'Api/AnmuxiApi.ashx?method=UploadFileImg',
                //   filePath: tempFilePaths[0],
                //   name: 'file',
                //   header: {
                //     'content-type': 'application/x-www-form-urlencoded' // 默认值
                //   },
                //   formData: {
                //     'user': 'test'
                //   },
                //   success(res) {
                //     mta.Event.stat("upload_id", {});
                //     mtj.trackEvent('upload_id');
                //     console.log(JSON.parse(res.data).result, "==data==")
                //     that.setData({
                //       pringtimg: JSON.parse(res.data).result
                //     })
                //   }
                // })
            }
        })
    },
    personal(){
         wx.navigateTo({url:'/pages/personal/personal'})
    },
    nickname(e){
        this.setData({ nickname: e.detail.value })
    },

    accountSetSave(){
        let { nickname} = this.data
        if (nickname == '') {
            this.setData({ 'alert.txt': '请你输入昵称' })
        } else {
            // 返回
        }
    },
    

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------