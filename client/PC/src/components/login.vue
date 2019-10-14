<!--  -->
<template>
  <div class="login">
    <div class="header">
      <div class="title">
        <img src="../assets/images/menu/logo.png" alt />
      </div>
    </div>
    <div class="loginMain">
      <div class="loginArea">
        <div class="loginText"></div>
        <div class="username">
          <div class="usernameText">账号</div>
          <div class="usernameInput">
            <!-- <input type="text"placeholder="请输入账号" ref="username" /> -->
            <input type="text" v-model="username" placeholder="请输入账号" />
            <img src="../assets/images/login/user.png" alt />
          </div>
        </div>
        <div class="username">
          <div class="usernameText">密码</div>
          <div class="usernameInput">
            <!-- <input type="password" placeholder="请输入密码" ref="password" /> -->
            <input type="password" v-model="password" placeholder="请输入密码" />
            <img src="../assets/images/login/password.png" alt />
          </div>
        </div>
        <div class="menu">
          <div class="submit" @click="login()">登录</div>
          <div class="rememberUserName">
            <el-switch v-model="jizhuUser" active-text="记住账号" inactive-text @change="switchSelect"></el-switch>
          </div>
          <!-- <div class="forget">忘记密码?</div> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';
import { interfaceApi } from "../utils/interfaceAPI";

import bus from "@/common/bus.js";

import store from "@/store/store.js";

export default {
  //import引入的组件需要注入到对象中才能使用
  components: {},
  data() {
    //这里存放数据
    return {
      jizhuUser: true,
      username: "",
      password: "",
      loginDefault: ""
    };
  },
  //监听属性 类似于data概念
  computed: {},
  //监控data中的数据变化
  watch: {},
  //方法集合
  methods: {
    // 登录
    login() {
      var username = this.username;
      var password = this.password;
      var data = {};
      data.username = username;
      data.password = password;
      interfaceApi.sign(data, res => {
        console.log(res, "=res==");
        if (res.code == 200) {
          this.$message({
            message: "登录成功",
            type: "success"
          });

          let routerPath = true;
          bus.$emit("routerPath", routerPath);
          localStorage.setItem("userInfo","true")
          this.$router.push(this.loginDefault);
        } else {
          this.$message.error("登录失败");
        }
      });
    },

    switchSelect(e) {
      var userInfo = {};
      if (e) {
        userInfo.username = this.username;
        userInfo.password = this.password;
        localStorage.setItem("userInfo", JSON.stringify(userInfo));
      } else {
        localStorage.removeItem("userInfo");
      }
    }
  },
  //生命周期 - 创建完成（可以访问当前this实例）
  created() {
    this.loginDefault = this.$store.state.loginDefault;
     localStorage.removeItem("routerState")
  },
  //生命周期 - 挂载完成（可以访问DOM元素）
  mounted() {},
  beforeCreate() {}, //生命周期 - 创建之前
  beforeMount() {}, //生命周期 - 挂载之前
  beforeUpdate() {}, //生命周期 - 更新之前
  updated() {}, //生命周期 - 更新之后
  beforeDestroy() {}, //生命周期 - 销毁之前
  destroyed() {}, //生命周期 - 销毁完成
  activated() {} //如果页面有keep-alive缓存功能，这个函数会触发
};
</script>

<style scoped>
.login{
  background-image: url(../assets/images/login/bg.jpg);
  width: 100%;
  height: 100%;
  background-size: 100% 100%;
}



.header {
  width: 100%;
  height: 88px;
  background: #233f68;
  display: flex;
  justify-content: space-between;
  display: none;
}

.header .title {
  width: 294px;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.header .title img {
  width: 100%;
  margin-left: 45px;
}

.loginMain {
  width: 657px;
  height: 850px;
  background-color: rgba(46, 93, 142, .9);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  border-radius: 10px;
  box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.5);
}

.loginMain .loginArea {
  /* width: 580px; */
  /* height: 500px; */
  /* margin-top: 80px;
  margin-left: 190px; */
  /* overflow: hidden; */
  /* margin: 0 auto; */
}

.loginMain .loginArea .loginText {
  background-image: url(../assets/images/login/logo.png);
  width: 83px;
  height: 100px;
  margin: 105px auto 94px;
  background-size: 100% 100%;
}

.username {
  width: 100%;
  height: auto;
  text-align: left;
  margin-bottom: 30px;
  margin-left: 90px;
}

.username .usernameText {
  font-size: 20px;
  color: #fff;
  display: inline-block;
}

.username .usernameInput {
  height: 50px;
  background: transparent;
  align-items: center;
  justify-content: space-between;
  display: inline-block;
  border: #90a9c3 2px solid;
  width: 335px;
  margin-left: 34px;
}

.username .usernameInput > input {
  width: 100%;
  height: 50px;
  background: transparent;
  outline: none;
  border: none;
  padding: 10px 20px;
  color: #fff !important;
}




.username .usernameInput > img {
  width: 32px;
  height: 32px;
  display: none;
}

.rememberUserName{
  display: none;
}

.menu {
  width: 100%;
  height: auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 253px;
  cursor: pointer;
}

.submit {
  width: 255px;
  height: 50px;
  background: #233f68;
  line-height: 50px;
  color: #fff;
  border-radius: 50px;
  letter-spacing: 4px;
  margin: 0 auto;
  font-size: 20px;
  letter-spacing: 10px;
}

.forget {
  font-size: 14px;
  color: #3cb8b6;
}

input:-webkit-autofill,
textarea:-webkit-autofill,
select:-webkit-autofill {
  -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
  background-color: transparent;
  background-image: none;
  transition: background-color 50000s ease-in-out 0s;
}

input {
  background-color: transparent;
  color: #fff;
}

::-webkit-input-placeholder { /* WebKit browsers */
 color: #fff;
}
input:-internal-autofill-selected{
  
  color: #fff !important;
}
</style>
