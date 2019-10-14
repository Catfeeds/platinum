<!--  -->
<template>
  <div class>
    <div class="main">
      <h2 class="title">菜单 - 菜单描述</h2>
      <div class="content">
        <div class="add">保存</div>
        <div class="form"></div>
      </div>
    </div>
  </div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';

export default {
  //import引入的组件需要注入到对象中才能使用
  components: {},
  data() {
    //这里存放数据
    return {};
  },
  //监听属性 类似于data概念
  computed: {},
  //监控data中的数据变化
  watch: {},
  //方法集合
  methods: {},
  //生命周期 - 创建完成（可以访问当前this实例）
  created() {},
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
<style lang='less' scoped>
.main {
  position: absolute;
  top: 88px;
  left: 360px;
  right: 0;
  bottom: 0;
  background: #f5f6fa;
  overflow: auto;
  padding: 0 0 18px 0;
  .title {
    text-align: left;
    display: block;
    margin-top: 60px;
    margin-left: 100px;
    font-size: 30px;
  }
  .content {
    width: 1510px;
    height: 92%;
    margin-left: 40px;
    background: #fff;
    overflow: hidden;
    display: flex;
    flex-direction: column;

    .add {
      width: 224px;
      height: 45px;
      font-size: 16px;
      text-align: center;
      line-height: 45px;
      background: #3cb9b7;
      border-radius: 10px;
      color: #fff;
      letter-spacing: 4px;
      margin-top: 46px;
      margin-left: 46px;
    }

    .form {
      width: 1250px;
      height: auto;
      margin-top: 36px;
      margin-left: 46px;
    }
  }
}
</style>