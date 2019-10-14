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
        date: '购买时间',
        upPic: '/images/ticketEdit/pic.jpg',
        amount: '',
        reason: '',
        brand: {
            val: '购买品牌',
            arr: ['品牌1', '品牌2', '品牌3'],
            id: 0,
        },
        category: {
            val: '购买品类',
            arr: ['品类1', '品类2', '品类3'],
            id: 0,
        },

    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        this.setData({ today: config.today })
        console.log(config.today)
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
    bindDateChange: function(e) {
        this.setData({ date: e.detail.value })
    },
    categoryChange(e) {
        this.setData({ 'category.id': e.detail.value, 'category.val': this.data.category.arr[e.detail.value] })
    },
    brandChange(e) {
        this.setData({ 'brand.id': e.detail.value, 'brand.val': this.data.brand.arr[e.detail.value] })
    },
    amount(e) {
        this.setData({ amount: e.detail.value })
    },
    reason(e) {
        this.setData({ reason: e.detail.value })
    },
    
    btnUpload() {

        let { date, amount, category, brand ,reason,upPic} = this.data
        console.log(date)
        console.log(amount)
        if (date == '购买时间') {
            this.setData({ 'alert.txt': '请你选择购买时间' })
        } else if (amount == '') {
            this.setData({ 'alert.txt': '请您输入购买金额' })
        } else if (category.val == '购买品类') {
            this.setData({ 'alert.txt': '请您选择购买品类' })
        } else if (brand.val == '购买品牌') {
            this.setData({ 'alert.txt': '请您选择购买品牌' })
        }  else if (reason == '') {
            this.setData({ 'alert.txt': '请您输入购买理由' })
        } else if (upPic == '/images/ticketEdit/pic.jpg') {
            this.setData({ 'alert.txt': '请您上传小票' })
        } else {
            this.setData({ modal_show: 'modal_show' })
        }
    },
    ar() {
        wx.navigateTo({ url: '/pages/ARReturn/ARReturn' })
    },
    upImg() {
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


}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------