const app = getApp();
const { API, beats, icom, config } = app;
Page({
    data: {
        url: ''
    },

    onLoad(options) {
        // TODO 需要改成 prod url
        let url = 'http://t.sky.be-xx.com/wxapp/2019/PlatinumWxApp/client/html/index.html?token='+config.token+'&v='+Math.random();
        if (options.url) {
            url = decodeURIComponent(options.url)
        }
        // url += /\?/.test(url) ? '&' : '?';
        // const { mai, launchOptions } = getApp()
        // const params = { ...launchOptions.query, accessToken: mai.member.auth.accessToken }
        // delete params.redirectUrl
        // const queryString = Object.keys(params)
        //   .map(key => `${key}=${encodeURIComponent(params[key])}`)
        //   .join('&')
        // url += `${queryString}&_t=${new Date().valueOf()}`
        this.setData({ url })
        console.info('打开连接: ', url)
    },

    onShareAppMessage(options) {
        console.log(this.shareData)
        console.log(options)
        const url = this.shareData? this.shareData.path :options.webViewUrl
        const sharePath = `/pages/index/index?redirectUrl=${encodeURIComponent('/pages/webview/webview?url=' + encodeURIComponent(url))}`
        const title = this.shareData? this.shareData.title : config.shareData.title
        const imageUrl = this.shareData? this.shareData.imageUrl : config.shareData.imageUrl
        const result = { path: sharePath, title, imageUrl }
        console.warn(result)
        return result
    },

    bindmessage(e) {
        this.shareData = e.detail.data[e.detail.data.length - 1]
    }
})