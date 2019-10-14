import Vue from 'vue'
import Vuex from "vuex"
Vue.use(Vuex)
const store = new Vuex.Store({
    state:{
        loginDefault:"/xiaoPiaoUpload",//登录跳转默认路径,
        allowBack:false
    },

    mutations:{
        updateAppSetting(state,allowBack){
            state.allowBack = allowBack;
        }
    },

    actions:{
        updateAppSetting(context,allowBack){
            context.commit("updateAppSetting",allowBack)
        }
    }
})

export default store