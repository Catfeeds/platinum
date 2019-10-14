const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
const areaList = require('../../common/js/area.js');

//-------------------------------------------------------初始化-------------------------------------------------------
let $query, SessionKey, OpenID;

Page({
    data: {
        userInfo: {},
        hasUserInfo: false,
        person:{
            name:'',
            sex:'性别',
            birthday:"生日",
            addInfo:{
                sheng: {code:"1",name:"省"},
                shi:  {code:"1",name:"市"},
                qu:  {code:"110000",name:"区"},
            },
            add:'',
            email:'',
            marriage:'婚姻状况',
            commemorationDay:"纪念日",

        },
        show:false,
        sexArr: [ '男', '女'],
        marriageArr: [ '未婚', '已婚'],
        appData: app.data, //拿到全局的数据
    }, //页面的初始数据
    async onLoad(option) {
        $query = option;
        console.log('getQueryString', option);
        this.setData({today:config.today,areaList:areaList.default,})
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
    sexChange: function(e) {
        this.setData({ ['person.sex']: this.data.sexArr[e.detail.value] })
    },
    marriageChange: function(e) {
        this.setData({ ['person.marriage']: this.data.marriageArr[e.detail.value] })
    },
    birthdayChange: function(e) {
        console.log(e.detail.value)
        this.setData({ ['person.birthday']: e.detail.value })
    },
    commemorationDayChange: function(e) {
        console.log(e.detail.value)
        this.setData({ ['person.commemorationDay']: e.detail.value })
    },
    nameChange(e){
        this.setData({ ['person.name']: e.detail.value })
    },
    emailChange(e){
        this.setData({ ['person.email']: e.detail.value })
    },
    addChange(e){
        this.setData({ ['person.add']: e.detail.value })
    },
    
    choosecity(e){
        this.setData({show:true});
    },
    onCityClose() {
        this.setData({ show: false });
    },
    CitySure(e){
        let info = this.data.person.addInfo
        info.sheng=e.detail.values[0];
        info.shi=e.detail.values[1];
        info.qu=e.detail.values[2];
        this.setData({ 'person.addInfo': info,show: false });
        console.log(e.detail.values)
    },
    CityCancel(e){
        this.setData({ show: false });
    },
    CityChange(e){
         // console.log(e)
    },
    //完善资料
    comSub(){

        let { name, sex, birthday, addInfo ,add,email,marriage,commemorationDay} = this.data.person
        if (name == '') {
            this.setData({ 'alert.txt': '请您输入姓名' })
        } else if (sex == '性别') {
            this.setData({ 'alert.txt': '请您选择性别' })
        } else if (birthday == '生日') {
            this.setData({ 'alert.txt': '请您选择生日' })
        } else if (addInfo.sheng.name == '省') {
            this.setData({ 'alert.txt': '请您选择省市区' })
        } else if (add == '') {
            this.setData({ 'alert.txt': '请您输入详细地址' })
        } else if (email == '') {
            this.setData({ 'alert.txt': '请您输入邮箱' })
        } else if (marriage == '婚姻状况') {
            this.setData({ 'alert.txt': '请您选择婚姻状况' })
        } else if (commemorationDay == '纪念日') {
            this.setData({ 'alert.txt': '请您选择纪念日' })
        } else {
            this.setData({ modal_show: 'modal_show' })
        }
    },

}) //end page

//-------------------------------------------------------业务逻辑-------------------------------------------------------