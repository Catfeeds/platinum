import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes:  [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      component: resolve => require(['@/components/login'],resolve),
      meta: {title:'铂金小程序管理后台 ',keyword:'',description:'铂金小程序管理后台',allowBack: false},
    },
    {
      path: '/',
      component: resolve => require(['@/components/index'],resolve),
      meta: {title:'铂金小程序管理后台 ',keyword:'',description:'铂金小程序管理后台 '},
      children:[
        {
          path:"/temp1",
          component:resolve => require(['@/Pages/temp1'],resolve),
          meta:{title:"铂金小程序管理后台 "}
        },
        {
          path:"/xiaoPiaoUpload",
          component:resolve => require(['@/Pages/home/xiaoPiaoUpload'],resolve),
          meta:{title:"铂金小程序管理后台-上传管理"}
        },
        {
          path:"/xiaoPiaoFanXian",
          component:resolve => require(['@/Pages/home/xiaoPiaoFanXian'],resolve),
          meta:{title:"铂金小程序管理后台-返现管理"}
        },
        {
          path:"/xiaoPiaoFanXianManageSettings",
          component:resolve => require(['@/Pages/home/xiaoPiaoFanXianManageSettings'],resolve),
          meta:{title:"铂金小程序管理后台-小票返现券管理配置"}
        },
        {
          path:"/homeFriendHelp",
          component:resolve => require(['@/Pages/home/homeFriendHelp'],resolve),
          meta:{title:"铂金小程序管理后台 - 好友助力管理"}
        },
        {
          path:"/homeUserInfo",
          component:resolve => require(['@/Pages/home/homeUserInfo'],resolve),
          meta:{title:"铂金小程序管理后台 - 个人信息管理 "}
        },
        {
          path:"/homeSign",
          component:resolve => require(['@/Pages/home/homeSign'],resolve),
          meta:{title:"铂金小程序管理后台 - 每日签到管理 "}
        },
        {
          path:"/actSign",
          component:resolve => require(['@/Pages/activity/actSign'],resolve),
          meta:{title:"铂金小程序管理后台 - 活动签到管理 "}
        },
        {
          path:"/shopItem",
          component:resolve => require(['@/Pages/shop/shopItem'],resolve),
          meta:{title:"铂金小程序管理后台 - 礼品管理 "}
        },
        {
          path:"/shopElect",
          component:resolve => require(['@/Pages/shop/shopElect'],resolve),
          meta:{title:"铂金小程序管理后台 - 电子券管理 "}
        },
        {
          path:"/actInterActiveManagement",
          component:resolve => require(['@/Pages/activity/actInterActiveManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - 线上互动管理 "}
        },
        {
          path:"/ARManageManagement",
          component:resolve => require(['@/Pages/activity/ARManageManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - AR返现管理 "}
        },
        {
          path:"/shopAdd",
          component:resolve => require(['@/Pages/shop/shopAdd'],resolve),
          meta:{title:"铂金小程序管理后台 - 礼品添加 "}
        },
        {
          path:"/electAdd",
          component:resolve => require(['@/Pages/shop/electAdd'],resolve),
          meta:{title:"铂金小程序管理后台 - 电子券添加 "}
        },
        {
          path:"/receivingAddressManagement",
          component:resolve => require(['@/Pages/vip/receivingAddressManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - 收货地址管理 "}
        },
        {
          path:"/vipPointsManagement",
          component:resolve => require(['@/Pages/vip/vipPointsManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - 会员积分管理"}
        },
        {
          path:"/vipPointsDetail",
          component:resolve => require(['@/Pages/vip/vipPointsDetail'],resolve),
          meta:{title:"铂金小程序管理后台 - 会员积分明细"}
        },
        {
          path:"/myCardManagemet",
          component:resolve => require(['@/Pages/vip/myCardManagemet'],resolve),
          meta:{title:"铂金小程序管理后台 - 我的卡包管理"}
        },
        {
          path:"/myGiftsMenagement",
          component:resolve => require(['@/Pages/vip/myGiftsMenagement'],resolve),
          meta:{title:"铂金小程序管理后台 - 我的礼品管理"}
        },
        {
          path:"/myGiftsDetails",
          component:resolve => require(['@/Pages/vip/myGiftsDetails'],resolve),
          meta:{title:"铂金小程序管理后台 - 我的礼品管理"}
        },
        {
          path:"/vipCashwithdrawal",
          component:resolve => require(['@/Pages/vip/vipCashwithdrawal'],resolve),
          meta:{title:"铂金小程序管理后台 - 会员提现管理"}
        },
        {
          path:"/vipEquityManagement",
          component:resolve => require(['@/Pages/equity/vipEquityManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - 会员权益管理"}
        },
        {
          path:"/vipChapterManagement",
          component:resolve => require(['@/Pages/equity/vipChapterManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - 会员章程管理"}
        },
        {
          path:"/FAQManagement",
          component:resolve => require(['@/Pages/equity/FAQManagement'],resolve),
          meta:{title:"铂金小程序管理后台 - FAQ管理"}
        },
        {
          path:"/monthData",
          component:resolve => require(['@/Pages/monthData/monthData'],resolve),
          meta:{title:"铂金小程序管理后台 - 月度数据管理"}
        },
      ]
    }
  ]
})
