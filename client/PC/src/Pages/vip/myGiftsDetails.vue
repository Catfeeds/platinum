<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">快递信息编辑</h2>
            <div class="contentOne contentSave">
                <el-button type="primary" round class="baseBtn saveBtn" v-if="clickState" @click="save()">保存</el-button>
                <el-button type="primary" round class="baseBtn saveBtn" v-else>保存</el-button>
                <el-button type="primary" round class="baseBtn saveBtn" @click="back()">返回</el-button>
            </div>
            <div class="contentPanel">
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column prop="id" label="ID" width="80"></el-table-column>
                        <el-table-column prop="user.member_nickname" label="兑换人"></el-table-column>
                        <el-table-column prop="order_no" label="订单号"></el-table-column>
                        <el-table-column prop="e_order" label="快递单号"></el-table-column>
                        <el-table-column prop="created_at" label="兑换时间"></el-table-column>
                        <el-table-column prop="gift.name" label="兑换物品"></el-table-column>
                        <el-table-column prop="useraddr.name" label="收货姓名"></el-table-column>
                        <el-table-column prop="useraddr.mobile" label="收货手机"></el-table-column>
                        <el-table-column prop="useraddr.aread.name" label="收货地区"></el-table-column>
                        <el-table-column prop="useraddr.addr" label="收货地址"></el-table-column>
                        <el-table-column prop="express.name" label="快递公司"></el-table-column>
                        <el-table-column prop="state" label="状态">
                            <template slot-scope="scope">
                                <div v-if="scope.row.state == 1">待发货</div>
                                <div v-if="scope.row.state == 2">已发货</div>
                                <div v-if="scope.row.state == 3">已收货</div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="" label="操作">
                            <template slot-scope="scope">
                                <div class="scopeLink flex flex-middle flex-center" style="cursor: pointer;" v-if="scope.row.state == 2">
                                    <el-button size="mini" @click="handleSeePhoto(scope.$index, scope.row.id)">查看</el-button>
                                </div>
                                <div class="flex flex-middle flex-center" style="cursor: pointer;" v-else>
                                    <div style="color:#ccc;">查看</div>
                                </div>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
            <div class="contentSearch" v-if="type == 1">
                <div class="contentOne">
                    <div class="infoName">选择快递公司</div>
                    <el-select v-model="value" placeholder="请选择" style="width:20%;" @change="changeWuliCompany">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                </div>
                <div class="contentOne">
                    <div class="infoName">输入快递单号</div>
                    <div class="inputOrder">
                        <el-input v-model="inputOrder" placeholder="请输入内容"></el-input>
                    </div>
                    <!-- <div class="lookBtn" @click="lookOrder()">
                        <el-button round>查询单号</el-button>
                    </div> -->
                </div>

            </div>
        </div>
    </div>

    <!-- 物流信息 -->
    <el-dialog title="物流信息" :visible.sync="dialogVisible" width="60%">
        <div class="wuliuInfo">
            <div class="jutiInfo" v-for="(item,index) in wuliuInfo" :key="index">
                <div class="info">{{item.time}}</div>
                <div class="context">{{item.context}}</div>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
        </span>
    </el-dialog>
</div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';
import {
    interfaceApi
} from "@/utils/interfaceAPI";

// var data = {
//   id: ""
// };

export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            inputOrder: "",
            activeName: "first",
            options: [],
            value: "",
            tableData: [],
            dialogVisible: false,
            wuliuInfo: [],
            clickState: true,
            type:""
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        handleSeePhoto(index, row) {
            this.dialogVisible = true;
            this.giftorder_express(row);
        },
        giftorder_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.giftorder_deta(data, res => {
                console.log(res, "==giftorder_deta==");
                if (res.code == 200) {
                    this.tableData.push(res.data)
                }
            });
        },

        // 快递list
        express() {
            var data = {};
            interfaceApi.express(data, (res) => {
                console.log(res, "==res==")
                if (res.code == 200) {
                    var arr = [];
                    for (var i of res.data.data) {
                        var obj = {};
                        obj.value = i.id;
                        obj.label = i.name;
                        arr.push(obj);
                    }

                    this.options = arr;
                }
            })
        },

        // 礼品订单物流信息刷新
        giftorder_express(id) {
            var data = {};
            data.id = id;
            interfaceApi.giftorder_express(data, (res) => {
                console.log(res, "==giftorder_express==")
                if (res.code == 200) {
                    this.wuliuInfo = res.data.data;
                    console.log(this.wuliuInfo)
                }
            })
        },

        // 查询订单号
        lookOrder() {
            // this.giftorder_express(this.inputOrder);
            // console.log(this.tableData)
        },

        save() {
            var id = this.tableData[0].id;
            var e_id = this.value;
            var e_order = this.inputOrder;
            this.clickState = false;
            this.giftorder_up(id, e_id, e_order);
        },

        changeWuliCompany(e) {
            console.log(e, "==e===")
            this.value = e;
        },

        // 发货
        giftorder_up(id, e_id, e_order) {
            var data = {};
            data.id = id;
            data.e_id = e_id;
            data.e_order = e_order;
            interfaceApi.giftorder_up(data, (res) => {
                console.log(res, "==giftorder_up==")
                if (res.code == 200) {
                    this.$message({
                        message: '发货成功',
                        type: 'success'
                    });
                    setTimeout(() => {
                        this.clickState = true;
                    }, 300)

                    this.giftorder_deta(id)
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        // 返回
        back(){
            this.$router.push({
                path:"/myGiftsMenagement"
            })
        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        console.log(this.$route.query, "===id==");
        this.type = this.$route.query.type;
        this.express();
        var id = this.$route.query.id;
        this.giftorder_deta(id)
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
        width: 100%;
        height: 50px;
        margin: 0 auto;
        line-height: 50px;
        color: #666666;
        background: #f5f6fa;
    }

    .content {
        width: 1510px;
        height: auto;
        margin-left: 40px;
        margin-top: 40px;
        background: #fff;
        display: flex;
        flex-direction: column;
        position: relative;

        .tabTop {
            padding: 20px 0;
        }

        .stateSelect {
            width: 200px;
            margin-left: 30px;
        }

        .searchInput {
            width: 200px;
            margin-left: 20px;
        }

        .scopeLink>div {
            border-bottom: 1px solid #666666;
        }

        .el-table .cell img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .contentPanel {
            padding: 20px;

            .searchInput {
                width: 200px;
            }
        }

        .contentSearch {
            width: 100%;
            height: 400px;
            margin: 54px 20px 0;
            display: flex;
            flex-direction: column;
        }
    }
}

.inputOrder {
    width: 300px;
}

.rightBtn .baseBtn {
    margin-left: 20px;
}

.wuliuInfo {
    width: 100%;
    display: flex;
    flex-direction: column;

    .jutiInfo {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;

        .info {
            width: 30%;
            text-align: left;
        }

        .context {
            text-align: right;
        }
    }
}

.contentOne {
    width: 100%;
    display: flex;
    align-items: center;
    margin-bottom: 20px;

    .infoName {
        white-space: nowrap;
        margin-right: 20px;
        font-size: 19px;
        color: #666;
    }

    .saveBtn {
        margin-left: 30px;
    }

    .lookBtn {
        width: 150px;
    }
}

.contentSave {
    margin-top: 18px;
}
</style>
