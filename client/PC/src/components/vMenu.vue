<!--  -->
<template>
  <div class="menu scroll">
    <div class="menuAdmin" v-for="(item,index) in navList" :key="index">
      <div class="menuCaiDan" @click="navBtn(item,index)">
        <img :src="item.icon" alt class="menuIcon" />
        <span class="menuText" :class="{menuTextActive:item.menuSelectState}">{{item.parentName}}</span>
        <!-- <img v-if="!item.menuSelectState" src="../assets/images/menu/gray.png" alt class="rightIcon" />
        <img v-else src="../assets/images/menu/green.png" alt class="rightIcon" />-->
      </div>

      <div class="menuChildren" v-if="item.menuSelectState">
        <div class="menuChildrenContent">
          <div
            class="label"
            v-for="(childItem,index1) in item.childrenList"
            :key="index1"
            :class="{active:childItem.childrenMenuSelect}"
            @click="childrenMenuBtn(childItem,index1,index)"
          >
            <span class="labelText">{{childItem.name}}</span>
          </div>
        </div>
      </div>
    </div>
    <!-- logo -->
    <!-- <img src="../assets/images/menu/logo.png" alt="" class="logo"> -->
  </div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';
import bus from "@/common/bus.js";
import Router from "vue-router";
const originalPush = Router.prototype.push;
Router.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err);
};

import store from "@/store/store.js";

export default {
  //import引入的组件需要注入到对象中才能使用
  components: {},
  data() {
    //这里存放数据
    return {
      navList: [
        {
          id: 1,
          parentName: "首页功能管理",
          menuSelectState: false,
          icon: require("../assets/images/menu/i1.png"),
          childrenList: [
            {
              id: 1,
              name: "小票上传管理",
              childrenMenuSelect: true,
              routerPath: "/xiaoPiaoUpload"
            },
            {
              id: 2,
              name: "小票返现管理",
              childrenMenuSelect: false,
              routerPath: "/xiaoPiaoFanXian"
            },

            {
              id: 3,
              name: "小票返现券管理配置",
              childrenMenuSelect: false,
              routerPath: "/xiaoPiaoFanXianManageSettings"
            },
            {
              id: 4,
              name: "好友助力管理",
              childrenMenuSelect: false,
              routerPath: "/homeFriendHelp"
            },
            {
              id: 5,
              name: "个人信息管理",
              childrenMenuSelect: false,
              routerPath: "/homeUserInfo"
            },
            {
              id: 6,
              name: "每日签到管理",
              childrenMenuSelect: false,
              routerPath: "/homeSign"
            }
          ]
        },
        {
          id: 2,
          parentName: "首页活动管理",
          menuSelectState: false,
          icon: require("../assets/images/menu/i2.png"),
          childrenList: [
            {
              id: 1,
              name: "线上互动管理",
              childrenMenuSelect: false,
              routerPath: "/actInterActiveManagement"
            },
            {
              id: 2,
              name: "AR返现管理",
              childrenMenuSelect: false,
              routerPath: "/ARManageManagement"
            },
            {
              id: 3,
              name: "活动签到管理",
              childrenMenuSelect: false,
              routerPath: "/actSign"
            }
          ]
        },
        {
          id: 3,
          parentName: "积分商城管理",
          menuSelectState: false,
          icon: require("../assets/images/menu/i3.png"),
          childrenList: [
            {
              id: 1,
              name: "礼品管理",
              childrenMenuSelect: false,
              routerPath: "/shopItem"
            },
            {
              id: 2,
              name: "电子券管理",
              childrenMenuSelect: false,
              routerPath: "/shopElect"
            }
          ]
        },
        {
          id: 4,
          parentName: "会员管理",
          menuSelectState: false,
          icon: require("../assets/images/menu/i4.png"),
          childrenList: [
            {
              id: 1,
              name: "收货地址管理",
              childrenMenuSelect: false,
              routerPath: "/receivingAddressManagement"
            },
            {
              id: 2,
              name: "会员积分管理",
              childrenMenuSelect: false,
              routerPath: "/vipPointsManagement"
            },
            {
              id: 3,
              name: "我的卡包管理",
              childrenMenuSelect: false,
              routerPath: "/myCardManagemet"
            },
            {
              id: 4,
              name: "我的礼品管理",
              childrenMenuSelect: false,
              routerPath: "/myGiftsMenagement"
            },
            {
              id: 5,
              name: "会员提现管理",
              childrenMenuSelect: false,
              routerPath: "/vipCashwithdrawal"
            }
          ]
        },
        {
          id: 5,
          parentName: "权益管理",
          menuSelectState: false,
          icon: require("../assets/images/menu/i5.png"),
          childrenList: [
            {
              id: 1,
              name: "会员权益管理",
              childrenMenuSelect: false,
              routerPath: "/vipEquityManagement"
            },
            {
              id: 2,
              name: "会员章程管理",
              childrenMenuSelect: false,
              routerPath: "/vipChapterManagement"
            },
            {
              id: 3,
              name: "FAQ管理",
              childrenMenuSelect: false,
              routerPath: "/FAQManagement"
            }
          ]
        },
        {
          id: 6,
          parentName: "月度数据管理",
          menuSelectState: false,
          icon: require("../assets/images/menu/i6.png"),
          childrenList: [
            {
              id: 1,
              name: "数据管理",
              childrenMenuSelect: false,
              routerPath: "/monthData"
            }
          ]
        }
      ],
      loginDefault:""
    };
  },
  //监听属性 类似于data概念
  computed: {},
  //监控data中的数据变化
  watch: {},
  //方法集合
  methods: {
    navBtn(e, i) {
      var that = this;
      var menuSelectState = e.menuSelectState;
      var navList = that.navList;
      for (var k of navList) {
        k.menuSelectState = false;
        for (var j of k.childrenList) {
          j.childrenMenuSelect = false;
        }
      }
      that.navList[i].menuSelectState = true;
      that.navList[i].childrenList[0].childrenMenuSelect = true;
      var path = that.navList[i].childrenList[0].routerPath;
      that.$router.push(path);
      var routerState = {
        path: path,
        parIndex: i,
        children: 0
      };
      routerState = JSON.stringify(routerState);
      localStorage.setItem("routerState", routerState);
    },
    childrenMenuBtn(e, i, j) {
      var that = this;
      var parIndex = j;
      var path = e.routerPath;
      var childrenMenuSelect = e.childrenMenuSelect;
      var length = that.navList[parIndex].childrenList.length;
      for (var k = 0; k < length; k++) {
        that.navList[parIndex].childrenList[k].childrenMenuSelect = false;
      }
      that.navList[parIndex].childrenList[i].childrenMenuSelect = true;
      that.$router.push(path);
      var routerState = {
        path: path,
        parIndex: parIndex,
        children: i
      };
      routerState = JSON.stringify(routerState);
      localStorage.setItem("routerState", routerState);
    },
    //默认显示会员中中心管理----品牌商品管理
    defaultBrandGoodsManager() {
      var that = this;
      var navList = that.navList;
      that.navList[0].menuSelectState = true;
      that.$router.push(this.loginDefault);
    },

    // 默认显示
    defaultPage() {
      var that = this;
      var routerState = JSON.parse(localStorage.getItem("routerState"));
      if (routerState == null) {
        that.defaultBrandGoodsManager();
      } else {
        var navList = that.navList;
        for (var i of navList) {
          for (var j of i.childrenList) {
            j.childrenMenuSelect = false;
          }
        }
        var path = routerState.path;
        var parIndex = routerState.parIndex;
        var children = routerState.children;
        that.navList[parIndex].menuSelectState = true;
        that.navList[parIndex].childrenList[children].childrenMenuSelect = true;
      }

      

    },

    //接收设置页面传递过来的值---显示设置页面
    getSetting() {
      var that = this;
      bus.$on("routerPath", msg => {
        var navList = that.navList;
        for (var k of navList) {
          k.menuSelectState = false;
          for (var j of k.childrenList) {
            j.childrenMenuSelect = false;
          }
        }
        that.navList[0].menuSelectState = true;
        that.navList[0].childrenList[0].childrenMenuSelect = true;
      });

      // var routerState = {
      //     "path": msg,
      //     "parIndex": 0,
      //     "children": 0
      // }
      // routerState = JSON.stringify(routerState)
      // localStorage.setItem("routerState", routerState);
      // this.$router.push(msg);
    }
  },
  //生命周期 - 创建完成（可以访问当前this实例）
  created() {
    // this.defaultBrandGoodsManager();
    this.defaultPage();
     this.loginDefault = this.$store.state.loginDefault;

  },
  //生命周期 - 挂载完成（可以访问DOM元素）
  mounted() {
    this.getSetting();
  },
  beforeCreate() {}, //生命周期 - 创建之前
  beforeMount() {}, //生命周期 - 挂载之前
  beforeUpdate() {}, //生命周期 - 更新之前
  updated() {}, //生命周期 - 更新之后
  beforeDestroy() {}, //生命周期 - 销毁之前
  destroyed() {}, //生命周期 - 销毁完成
  activated() {} //如果页面有keep-alive缓存功能，这个函数会触发
};
</script>

<style lang="less" scoped>
.menu {
  width: 340px;
  position: absolute;
  top: 88px;
  left: 0;
  bottom: 0;
  z-index: 1;
  overflow-y: auto;
  overflow-x: hidden;

  .menuAdmin:nth-of-type(1) {
    margin-top: 17px;
  }

  .menuAdmin {
    width: 100%;
    height: auto;
    display: flex;
    flex-direction: column;

    .menuCaiDan {
      width: 100%;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      position: relative;
      cursor: pointer;

      .menuIcon {
        width: 32px;
        height: 32px;
        margin-right: 38px;
        margin-left: 46px;
      }

      .menuText {
        width: auto;
        display: block;
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 2px;
      }

      .menuTextActive {
        color: #000;
      }

      .rightIcon {
        width: 14px;
        height: 14px;
        position: absolute;
        right: 30px;
        top: 0;
        bottom: 0;
        margin: auto;
      }
    }

    .menuChildren {
      width: 100%;
      height: auto;
      background: #ededed;

      .menuChildrenContent {
        width: 100%;
        height: auto;
        float: right;

        .active {
          background: #233f68;

          .labelText {
            color: #fff;
          }
        }

        .label {
          width: 100%;
          height: 80px;
          line-height: 80px;
          color: #000;
          text-align: left;
          cursor: pointer;

          .labelText {
            letter-spacing: 4px;
            font-size: 15px;
            text-align: center;
            padding-left: 118px;
          }
        }
      }
    }
  }

  .logo {
    width: 114px;
    height: 66px;
    margin-top: 198px;
  }
}
</style>
