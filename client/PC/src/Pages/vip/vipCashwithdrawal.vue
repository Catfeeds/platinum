<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">会员提现管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                        <el-button type="primary" round class="baseBtn" v-if="sendState == 3" @click="sendAll()">发送</el-button>
                        <el-select v-model="value" placeholder="请选择状态" clearable class="stateSelect" @change="tiXianState">
                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                        </el-select>
                        <el-input v-model="mobile" type="tel" clearable placeholder="请输入手机号码" prefix-icon="el-icon-search" class="searchInput" @change="searchMobile"></el-input>

                    </div>
                    <div class="rightBtn">
                        <!-- <el-input v-model="input" placeholder="请输入用户" prefix-icon="el-icon-search" class="searchInput"></el-input> -->
                        <!-- <el-button type="primary" round class="baseBtn">搜索</el-button> -->
                    </div>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column label="ID" width="60">
                            <template slot-scope="scope">
                                {{(scope.$index + 1) + (pagination - 1) * 6}}
                            </template>
                        </el-table-column>
                        <el-table-column prop="user.member_nickname" label="会员昵称" width="200"></el-table-column>
                        <el-table-column prop="user.name" label="微信昵称" width="140"></el-table-column>
                        <el-table-column prop="" label="头像">
                            <template slot-scope="scope">
                                <img :src="scope.row.user.avatarurl" alt="">
                            </template>
                        </el-table-column>
                        <el-table-column prop="user.mobile" label="会员手机号"></el-table-column>
                        <el-table-column prop="created_at" label="获取时间"></el-table-column>
                        <el-table-column prop="money" label="获取金额"></el-table-column>
                        <el-table-column prop="state" label="状态"></el-table-column>
                        <el-table-column prop="apply_time" label="提现时间"></el-table-column>
                        <el-table-column prop="account_time" label="到账时间"></el-table-column>

                        <el-table-column prop="" label="编辑" width="180">
                            <template slot-scope="scope">
                                <div class="scopeLink flex flex-middle flex-center" v-if="scope.row.state == '提现审核中'">
                                    <el-button size="mini" @click="handlePass(scope.row, scope.row.id)">通过</el-button>
                                    <el-button size="mini" @click="handleOver(scope.row, scope.row.id)">驳回</el-button>
                                </div>

                                <div class="scopeLink flex flex-middle flex-center" v-if="scope.row.state == '发放中(审核成功)'">
                                    <el-button size="mini" @click="send(scope.row, scope.row.id)">发放</el-button>
                                </div>

                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
        </div>
        <!-- 分页 -->
        <el-pagination background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>
</div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';
import {
    interfaceApi
} from "@/utils/interfaceAPI";
var loading;
export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            input: "",
            activeName: "first",
            options: [{
                    value: "1",
                    label: "待提现"
                },
                {
                    value: "2",
                    label: "提现审核中"
                },
                {
                    value: "3",
                    label: "已提现待发放"
                },
                {
                    value: "4",
                    label: "审核失败"
                },
                {
                    value: "5",
                    label: "已提现到账"
                },
                {
                    value: "6",
                    label: "小票审核中"
                },
                {
                    value: "7",
                    label: "小票审核失败"
                }
            ],
            value: "",
            tableData: [],
            total: 0,
            pagination: 1,
            mobile: "",
            pageSize:interfaceApi.pageSize,
            sendState:""
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {

        // 通过审核
        handlePass(row, id) {
            this.$confirm('此操作将通过审核, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.userwithdrawal_up(id, 3);
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消审核'
                });
            });
        },

        // 驳回
        handleOver(row, id) {
            this.$confirm('此操作将驳回审核, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.userwithdrawal_up(id, 2);
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消驳回'
                });
            });
        },

        // 发送金额
        send(row, id) {
            this.$confirm('此操作将发放金额, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.withdrawal_grant(id)
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消发放'
                });
            });
        },

        sendAll() {
            this.$confirm('此操作将发放全部金额, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
               this.withdrawal_grant();
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消发放'
                });
            });
        },
        // 提现审核
        userwithdrawal_up(id, state) {
            var data = {};
            data.id = id;
            data.state = state;
            interfaceApi.userwithdrawal_up(data, res => {
                console.log(res, "==userwithdrawal_up==");
                if (res.code == 200) {
                    this.$message({
                        type: 'success',
                        message: '审核通过!'
                    });
                    this.userwithdrawal_list();
                } else {
                    this.$message.error(res.msg);
                }
            });
        },

        // 返现券直接发放
        withdrawal_grant(id) {
            var data = {};
            data.id = id;
            interfaceApi.withdrawal_grant(data, (res) => {
                console.log(res, "===withdrawal_grant==")
                if (res.code == 200) {
                    this.$message({
                        type: 'success',
                        message: '发放成功!'
                    });
                    this.userwithdrawal_list();
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        userwithdrawal_list(page = 1, paginate = interfaceApi.pageSize, state = "", u_id = "", mobile = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.state = state;
            data.u_id = u_id;
            data.mobile = mobile;
            interfaceApi.userwithdrawal_list(data, res => {
                console.log(res, "==userwithdrawal_list==");
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            });
        },

        tiXianState(e) {
            this.sendState = e;
            this.userwithdrawal_list(1, interfaceApi.pageSize, e);
        },

        searchBtn(e) {
            this.userwithdrawal_list(1, interfaceApi.pageSize, "", e);
        },
        currentChange(e) {
            this.pagination = e;
            this.userwithdrawal_list(e)
        },

        // 搜索手机号码
        searchMobile(e) {
            this.userwithdrawal_list(1, interfaceApi.pageSize, "", "", e);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.userwithdrawal_list();
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
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 50px;
        margin: 0;
        line-height: 50px;
        color: #666666;
        background: #f5f6fa;
    }

    .content {
        width: 1510px;
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
            margin-left: 20px;
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
            margin-top: 50px;
            padding: 20px;

            .searchInput {
                width: 200px;
            }
        }
    }
}

.rightBtn .baseBtn {
    margin-left: 20px;
}
</style>
