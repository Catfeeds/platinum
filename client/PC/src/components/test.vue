<template>
  <div>
    {{jizhuUser}}
    <!-- <v-store></v-store> -->
  </div>
</template>


<script>
import { interfaceApi } from "../utils/interfaceAPI";
import bus from "@/common/bus.js";
import store from "@/store/store.js";

import vStore from "@/store/store";

export default {
  //import引入的组件需要注入到对象中才能使用
  components: {
    vStore
  },
  data() {
    //这里存放数据
    return {
      jizhuUser: 121212
    };
  },
  //生命周期 - 创建完成（可以访问当前this实例）
  created() {
    this.tets();
  },
  methods: {
    tets() {
      interfaceApi.receipt_list(data, res => {
        console.log(res, "=res==");
        if (res.code == 200) {
          this.$message({
            message: "登录成功",
            type: "success"
          });

          let routerPath = true;
          bus.$emit("routerPath", routerPath);
          this.$router.push(this.loginDefault);
        } else {
          this.$message.error("登录失败");
        }
      });
    }
  }
};
</script>