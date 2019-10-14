<!--  -->
<template>
  <div class>
    <div class="main">
      <div class="content">
        <h2 class="title">月度数据管理</h2>
        <div class="tabTop flex flex-middle flex-between">
          <div class="leftBtn">
            <el-button type="primary" round class="exportBtn">导出完整列表</el-button>
          </div>
        </div>
        <div class="numBox">
          <el-row :gutter="20">
            <el-col :span="6">
              <div class="grid-content bg-purple">
                <div class="item_title">总会员数</div>
                <div class="member_box">
                  <div class="member_num">3000</div>
                  <img src="@/assets/images/login/icon1.jpg" class="member_icon" />
                  <div class="clear"></div>
                </div>
              </div>
            </el-col>
            <el-col :span="6">
              <div class="grid-content bg-purple">
                <div class="item_title">昨日新增会员数</div>
                <div class="member_box">
                  <div class="member_num">123</div>
                  <img src="@/assets/images/login/icon2.jpg" class="member_icon" />
                  <div class="clear"></div>
                </div>
              </div>
            </el-col>
            <el-col :span="6">
              <div class="grid-content bg-purple">
                <div class="item_title">昨日活跃会员数</div>
                <div class="member_box">
                  <div class="member_num">520</div>
                  <img src="@/assets/images/login/icon3.jpg" class="member_icon" />
                  <div class="clear"></div>
                </div>
              </div>
            </el-col>
            <el-col :span="6">
              <div class="grid-content bg-purple">
                <div class="item_title">礼品兑换数</div>
                <div class="member_box">
                  <div class="member_num">20</div>
                  <img src="@/assets/images/login/icon4.jpg" class="member_icon" />
                  <div class="clear"></div>
                </div>
              </div>
            </el-col>
          </el-row>
        </div>
        <div class="chartBox">
          <div class="iconBox">
            <div class="iconNum">
              <img src="@/assets/images/login/chart_icon1.jpg" class="icon" />
              <div class="num_Box">
                <div class="numBox_title">小票上传数</div>
                <div class="num">21</div>
              </div>
            </div>
            <div class="iconNum">
              <img src="@/assets/images/login/chart_icon2.jpg" class="icon" />
              <div class="num_Box">
                <div class="numBox_title">每日签到数</div>
                <div class="num">1000</div>
              </div>
            </div>
            <div class="iconNum">
              <img src="@/assets/images/login/chart_icon3.jpg" class="icon" />
              <div class="num_Box">
                <div class="numBox_title">互动参与数</div>
                <div class="num">1000</div>
              </div>
            </div>
          </div>
          <div class="chart">
            <div class="chartcontent">
              <div class="chart_title">每日活跃统计</div>
              <div class="block">
                <select name id>
                  <option value>最近10天</option>
                  <option value>最近一个月</option>
                  <option value>最近三个月</option>
                  <option value>最近六个月</option>
                  <option value>最近一年</option>
                </select>
              </div>
              <div class="txt"></div>
              <div class="block">
                <el-date-picker
                  v-model="value2"
                  type="date"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                ></el-date-picker>
              </div>
              <div class="txt">至</div>
              <div class="block">
                <el-date-picker
                  v-model="value1"
                  type="date"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                ></el-date-picker>
              </div>
            </div>
            <!-- <ve-line :data="chartData" :extend="extend"></ve-line> -->
            <ve-line
              :data="chartData"
              :colors="['#456bb4']"
              :legend-visible="false"
              :tooltip-visible="false"
              :extend="extend"
            ></ve-line>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';
import { interfaceApi } from "@/utils/interfaceAPI";
var loading;
export default {
  //import引入的组件需要注入到对象中才能使用
  components: {},
  data() {
    //这里存放数据
    this.extend = {
      series: {
        smooth: false
      },
      borderColor: "#000"
    };
    return {
      isUseIndex: "",
      is_shelf_index: "",
      isSort: "",
      options: [
        {
          value: 1,
          label: "是"
        },
        {
          value: 0,
          label: "否"
        }
      ],
      optionsProducts: [
        {
          value: 1,
          label: "上架"
        },
        {
          value: 0,
          label: "下架"
        }
      ],
      optionsSort: [
        {
          value: 1,
          label: 1
        },
        {
          value: 2,
          label: 2
        },
        {
          value: 3,
          label: 3
        }
      ],
      dialogTableVisible: false,
      dialogFormVisible: false,
      form: {},
      formLabelWidth: "150px",
      tableData: [],
      coverImageUrl: "",
      coverImageUrlState: true,
      bannerImageUrl: "",
      bannerImageUrlState: true,
      img_upload: interfaceApi.img_upload,
      file_upload: interfaceApi.file_upload,
      total: 0,
      chartData: {
        columns: ["日期", "访问用户"],

        rows: [
          {
            日期: "2019/11/01",
            访问用户: 1393
          },
          {
            日期: "2019/11/05",
            访问用户: 3530
          },
          {
            日期: "2019/11/10",
            访问用户: 2923
          },
          {
            日期: "2019/11/15",
            访问用户: 1723
          },
          {
            日期: "2019/11/20",
            访问用户: 3792
          },
          {
            日期: "2019/11/25",
            访问用户: 4593
          },
          {
            日期: "2019/11/30",
            访问用户: 4593
          }
        ]
      },
      value1: "",
      value2: ""
    };
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

<style lang="less" scoped>
.main {
  position: absolute;
  top: 88px;
  left: 340px;
  right: 0;
  bottom: 0;
  background: #f5f6fa;
  overflow: auto;
  padding: 0 0 18px 0;

  .title {
    text-align: center;
    display: block;
    font-size: 25px;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 50px;
    margin: 0;
    line-height: 50px;
    color: #666666;
  }

  .exportBtn {
    background-color: #233f68;
    color: #fff;
  }

  // 09/25新增---stare
  .numBox {
    margin-top: 20px;

    .el-row {
      margin-bottom: 20px;

      &:last-child {
        margin-bottom: 0;
      }

      .el-col {
        border-radius: 4px;
      }

      .bg-purple-dark {
        background: #99a9bf;
      }

      .bg-purple {
        background: #fff;

        .item_title {
          color: #233f68;
          text-align: left;
          padding: 20px 20px 0 20px;
          font-size: 15px;
        }

        .item_title:after {
          content: "";
          display: block;
          width: 100%;
          height: 1px;
          background-color: #ccc;
          margin-top: 13px;
        }

        .member_box {
          margin-top: 10px;
          text-align: left;
          padding: 26px 20px;

          .member_num {
            font-size: 25px;
            color: #5e7bc7;
            // display: inline-block;
            float: left;
            vertical-align: bottom;
          }

          .member_icon {
            // display: inline-block;
            float: right;
            width: 59px;
            height: 47px;
            background-color: #ccc;
          }

          .clear {
            clear: both;
          }
        }
      }

      .bg-purple-light {
        background: #e5e9f2;
      }

      .grid-content {
        border-radius: 4px;
        min-height: 36px;
      }

      .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
      }
    }
  }

  .chartBox {
    display: block;
    text-align: left;
    font-size: 0;
    margin-top: 20px;

    .iconBox {
      display: inline-block;
      text-align: center;
      width: 24%;
      overflow: hidden;
      vertical-align: top;

      .iconNum {
        background-color: #fff;
        margin-bottom: 20px;
        padding: 42px 0;
        box-shadow: 0 0 5px #ccc;
        display: flex;
        align-items: center;
        justify-content: space-around;

        .icon {
          display: inline-block;
          vertical-align: top;
        }

        .num_Box {
          display: inline-block;

          .numBox_title {
            font-size: 15px;
            display: inline-block;
            color: #5e7bc7;
            font-weight: bold;
            letter-spacing: 4px;
          }

          .num {
            font-size: 21px;
            color: #5e7bc7;
          }
        }
      }

      .iconNum:last-child {
        margin-bottom: 0;
      }
    }

    .chart {
      display: inline-block;
      width: 74.5%;
      background-color: #fff;
      margin-left: 20px;
      // height: 510px;
      box-shadow: 0 0 10px #ccc;
      padding: 0 0 0 90px;

      .ve-line {
        margin-top: -22px;
      }

      .chartcontent {
        margin-top: 20px;

        .chart_title {
          font-size: 22px;
          color: #222f40;
          text-align: center;
          margin-bottom: 20px;
        }

        .block {
          //   text-align: center;
          display: inline-block;
          vertical-align: top;

          .el-date-editor .el-range-separator {
            width: auto;
          }

          select {
            height: 1.25rem;
            line-height: 1.25rem;
            width: 217px;
          }
        }

        .block:nth-of-type(1) {
          margin-left: 10px;
        }

        .txt {
          font-size: 15px;
          display: inline-block;
          margin-top: 10px;
          width: 60px;
          text-align: center;
        }
      }
    }
  }

  // 09/25新增---end
  .manageView {
    width: 121px;
    height: 50px;
  }

  .content {
    width: auto;
    height: auto;
    margin: 20px 40px;
    // background: #fff;
    display: flex;
    flex-direction: column;
    overflow-y: auto;

    .funList {
      width: calc(100% - 72px);
      height: 44px;
      margin: 38px 36px 0;
      display: flex;
      align-items: center;

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
      }

      .sortOne {
        margin-left: 130px;
      }

      .sortTwo {
        margin-left: 50px;
      }

      .sort {
        font-size: 17px;
        font-weight: bold;
        display: flex;
        align-items: center;

        .timer {
          width: auto;
          height: auto;
          margin-left: 15px;
        }

        .search {
          margin-left: 50px;
        }
      }
    }

    .form {
      width: calc(100% - 72px);
      height: auto;
      margin-top: 36px;
      margin-left: 36px;

      .imgShow {
        width: auto;
        height: 50px;
      }

      .imgShow > img {
        height: 100%;
        object-fit: contain;
      }
    }
  }
}
</style><style scoped>
.el-form-item__content {
  display: flex;
}

.use {
  background: #3cb9b7;
  color: #fff;
  padding: 4px 36px;
  font-size: 13px;
  border-radius: 4px;
}

.noUse {
  background: #fff;
  color: #3cb9b7;
  padding: 4px 36px;
  font-size: 13px;
  border-radius: 4px;
}

.alert .el-select {
  width: 385px;
}

.alert .el-form-item__content {
  display: flex;
}

.el-input__inner::-webkit-input-placeholder {
  text-align: center;
}

.el-table th > .cell {
  text-align: center;
  width: 100%;
}

.el-table td,
.el-table th.is-leaf {
  border-right: 1px solid #fff;
}

.el-table__body-wrapper .el-table th,
.el-table__body-wrapper .el-table tr {
  background: #ededed;
}

.el-table .success-row {
  background: #ededed;
}

.success-row .cell {
  color: #000;
}

.alert .el-input {
  display: block !important;
}

.el-button--primary {
  border: #3cb8b6;
  background: #3cb8b6;
}

.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}

.avatar-uploader .el-upload > img {
  width: 180px;
  height: 180px;
  object-fit: contain;
}

.avatar-uploader .el-upload > video {
  width: 180px;
  height: 180px;
}

.avatar-uploader .el-upload {
  display: flex;
  align-items: center;
}

.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}

.avatar {
  width: 178px;
  height: 178px;
  display: block;
}

.avatar-uploader {
  display: flex;
  justify-content: end;
}

.block >>> input {
  border-radius: 0;
}
</style>
