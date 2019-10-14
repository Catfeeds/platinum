import icom from '../base/com.js';
import regeneratorRuntime from '../plugs/regeneratorRuntime';
import promisify from '../plugs/promisify.js';
import config from '../../../config.js';



class Inits {
    constructor(obj) {
        this.Scene = obj.Scene;
        this.SceneValue = obj.SceneValue;
        this.API = obj.API;
        this.serverUserInfo = null;

    }

    /**
     * 初始化 拿code
     */
    async signIn(detail) {
        const login = promisify(wx.login);
        let { code } = await login();
        this.code = code;
        this.detail = detail;
        console.log('signIn');
        await this.getServerUserInfo();
        // await this.getUserInfo()
        //发送给服务器
        // await this.send()
        //获取用户头像和昵称
        

    }

    /**
     * 获取头像昵称信息
     */
    async send() {

        const wxResuest = promisify(wx.request);
        let { data } = await wxResuest({
            url: config.domain + 'api/home/login',
            data: {
                code: this.code,
                Scene: this.Scene,
                SceneValue: this.SceneValue,
            }
        })
        icom.storage("token", data.result.token);
        icom.storage("OpenID", data.result.OpenID);
        icom.storage("Scene", data.result.Scene);
        this.token = data.result.token;
        this.OpenID = data.result.OpenID;
        this.Scene = data.result.Scene;
        config.OpenID = data.result.OpenID;
        config.token = data.result.token;
        config.Scene = data.result.Scene;
    }

    /**
     * 发送给服务器code去换 openid token啥的
     */
    //获取小程序用户信息
    async getUserInfo(detail) {
        let pages = getCurrentPages();
        let page = pages[pages.length - 1];
        if (detail) {
            page.setData({
                hasUserInfo: true,
                userInfo: detail.userInfo
            });
            this.userInfo = detail.userInfo;
            let loginData = await this.userlogin()
            if(loginData.data.token!=''){
                config.token = loginData.data.token;
                icom.storage("token", loginData.data.token);
            }
            return loginData
            // return detail.userInfo;
        } else {
            const getUserInfo = promisify(wx.getUserInfo);
            const { userInfo } = await getUserInfo();
            this.userInfo = userInfo;
            if (this.userInfo) {
                page.setData({
                    hasUserInfo: true,
                    userInfo: this.userInfo
                });
                // return this.userInfo;
            } //edn if
        }
    }

    async getServerUserInfo(){
        let login = promisify(wx.login);
        let { code } = await login();
        let loginData = await this.API.userLoginNew(code);
        config.token = loginData.data.token;
        //去服务器获取用户数据
        let userData = await this.API.userinfo();
        if (userData.code == 200){
            this.serverUserInfo = userData.data;
        }
        console.log('getServerUserInfo:' + code);
    }

    async toLogin(){
        let login3 = promisify(wx.login);
        let code3  = await login3();
        this.code = code3.code;
        let loginData = await this.userlogin()
        if(loginData.data.token!=''){
            config.token = loginData.data.token;
            icom.storage("token", loginData.data.token);
        }
    }


    async userlogin(){
        let loginData = await this.API.userlogin({
            code:this.code,
            name:this.userInfo.nickName,
            avatarUrl:this.userInfo.avatarUrl,
            country:this.userInfo.country,
            province:this.userInfo.province,
            city:this.userInfo.city,
            mobile:this.userInfo.mobile,
        });
        return loginData
    }

    async getPhoneNumber(detail) {
        //获取小程序用户信息
        let pages = getCurrentPages();
        let page = pages[pages.length - 1];
        let login = promisify(wx.login);
        let code = await login();
        this.code = code.code;
        let phoneData = await this.API.decryptData({
            encryptedData: detail.encryptedData,
            iv: detail.iv,
            code: this.code,
        })
        console.log('phoneData', phoneData);
        // this.userInfo.mobile  = phoneData.data.mobile
        // let login2 = promisify(wx.login);
        // let code2 = await login2();
        // this.code = code2.code;
        // let loginData = await this.userlogin()
        config.token = phoneData.data.token
        return phoneData;
    }


}
/**
 * Init
 */
class Init {
    constructor(obj) {
        this.member = new Inits(obj);
    }
}
module.exports = Init;