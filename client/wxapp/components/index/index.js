const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
Component({
    /**
     * 组件的属性列表
     */
    properties: {
        userInfo: Object,
        appData: Object 
    },

    /**
     * 组件的初始数据
     */
    data: {

    },
    /**
     * 组件定义生命周期方法
     */
    lifetimes: {

    },
    /**
     * 组件所在页面的生命周期
     */
    pageLifetimes: {

    },
    /**
     * 组件的方法列表
     */
    methods: {
        updateData() {
            this.initData();
        },

        async initData(){
            console.log('index updateData')
        },
        signIn(){
            wx.navigateTo({url:'/pages/signIn/signIn'})
        },
        videoInterction(){
             wx.navigateTo({url:'/pages/webview/webview'})
        },
        ticketUpload(){
            // 是否历史记录
            if(false){
                wx.navigateTo({url:'/pages/ticketEdit/ticketEdit'})
             }else{
                wx.navigateTo({url:'/pages/ticketUpload/ticketUpload'})
             }
        },
        myPointer(){
            wx.navigateTo({url:'/member/myPointer/myPointer'})
        },
        myCard(){
            wx.navigateTo({url:'/member/myCard/myCard'})
        },
        personal(){
            wx.navigateTo({url:'/pages/personal/personal'})
        },
        shareFriend(){
             wx.navigateTo({url:'/pages/shareFriend/shareFriend'})
        },
        activitySign(){
            wx.navigateTo({url:'/pages/activitySign/activitySign'})
        },
        

    }
})