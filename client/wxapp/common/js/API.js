/**
 * 全页面的请求接口都统一放在API.js里
 * 一般的接口请求都需要token,所以这里会统一写好传给后端
 * 前端可以传其他需要的参数
 *  统一的接口域名请求在config.js里,前端可以自己配置
 */
const app = getApp();
import regeneratorRuntime from 'plugs/regeneratorRuntime';
import promisify from 'plugs/promisify.js';
import icom from 'base/com.js';
import config from '../../config.js';


class API {
    constructor() {
        this.DOMAIN = config.domain;
        this.DEBUG = true;
        this.wxResuest = promisify(wx.request);
    }
    /**
     * 初始化
     */
    async _send(method, data, type) {
        //data里面不带token才赋值
        // if (!this.token && !data.hasOwnProperty('token')) data.token = config.token;

        // console.log('================send');
        // console.log(method);
        // console.log(data);
        // console.log(type);
        // console.log('================send');
        let res = await this.wxResuest({
            // 测式 testapi/public/index.php/api/home/
            // 正式 api/public/index.php/api/home/
            url: this.DOMAIN + "testapi/public/index.php/api/home/" + method,
            data: data,
            method: type || 'GET',
            header: {
                'content-type': 'application/json', // 默认值
                'Authorization': config.token
            },
            dataType: "json"
        });
        if (res.data.code != 200) {
            // token失效
            if (res.data.code == 201) {
                icom.storage('token','');
                await this.beats.member.toLogin();
                // 重新请求
                return this._send (method,data,type);
                
            }else{
                wx.showToast({ title: res.data.data, icon: "none" })
                return res.data;
            }
        }else{
            return res.data;
        }
       
    }



    setbeats (beats) {
        this.beats = beats;
    }

    /**
     * 接口示意
     * @params Function success 回调函数 如果回调为null说明服务器报错了或者errcod非0
     * testApi 为接口的名称,两个保持一致即可
     */
    // 获取用户手机号
    async decryptData(data) {
        return this._send('decryptData', data, 'POST');
    }
    //废弃
    async userlogin(data) {
        return this._send('login', data, 'POST');
    }

    async userLoginNew(code){
        return this._send('code_logo', {
            code: code 
        }, 'POST');
    }

    async userinfo(data) {
        return this._send('userinfo', data, 'GET');
    }


}



module.exports = API;