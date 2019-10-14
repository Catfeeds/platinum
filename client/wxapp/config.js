/**
 * 公共数据可以存储在这个js里,每个页面引入下,就可以拿到了
 */
var date = new Date() ;
var today =[date.getFullYear()+"-" + (date.getMonth()+1) + "-" + date.getDate()];
module.exports = {
  webUrl: 'http://t.sky.be-xx.com/wxapp/2019/PlatinumWxApp/client/webimg/',
  domain: "https://pt-memberminapp.preciousplatinum.com.cn/", //测试
  today:today,
  token:wx.getStorageSync('token') || '',
  shareData: {
    title: '铂金小程序',
    path: '/pages/index/index',
    imageUrl: '/images/share.jpg'
  }
};