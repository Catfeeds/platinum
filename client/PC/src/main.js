// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import ElementUI from 'element-ui' //新添加
import 'element-ui/lib/theme-chalk/index.css' //新添加，避免后期打包样式不同，要放在import App 
import './assets/css/flex.css' //flex
import './assets/css/my.css' //重写 elmUI
import "./utils/rem"
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
import axios from 'axios'
import Vuex from 'vuex';
import store from "./store/store";
import router from './router'
import App from './App'
import {
  interfaceApi
} from "./utils/interfaceAPI";

import VCharts from 'v-charts'

Vue.use(Vuex)
Vue.use(VCharts)
//api 初始化
interfaceApi.init();

Vue.prototype.$axios = axios;
Vue.use(ElementUI)   //新添加
Vue.config.productionTip = false

// 在全局的router.beforeEach 函数里面获取allowBack的状态，同时更新vuex的allowBack的值
let allowBack = true // 给个默认值true
const whiteList = ['/login'];// 不重定向白名单
router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    document.title = to.meta.title
  }
  if (localStorage.getItem("userInfo")) { // 判断是否有token
    next()
  } else {
    if (whiteList.indexOf(to.path) !== -1) { // 在免登录白名单，直接进入
      next()
    } else {
      next('/login'); // 否则全部重定向到登录页
    }
  }
  if (to.meta.allowBack !== undefined) {
    allowBack = to.meta.allowBack
  }
  if (!allowBack) {
    history.pushState(null, null, location.href)
  }

  if(to.meta.allowBack == undefined){
    allowBack = true;
  }

  store.dispatch('updateAppSetting',allowBack)
});

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
