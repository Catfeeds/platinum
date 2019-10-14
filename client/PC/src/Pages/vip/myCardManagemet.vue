<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">卡包管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <!-- <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                    <el-select v-model="value" placeholder="请选择" clearable class="stateSelect">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
            <el-input v-model="input" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput"></el-input>-->
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                        <!-- <el-select v-model="value" placeholder="请选择" clearable class="stateSelect">
                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                        </el-select> -->
                        <el-select v-model="value" placeholder="请选择核销状态" clearable class="stateSelect" @change="heXiaoState">
                            <el-option v-for="item in optionsHeXiaoState" :key="item.value" :label="item.label" :value="item.value"></el-option>
                        </el-select>
                        <el-date-picker v-model="duiHuanTime" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" @change="changeTime">
                        </el-date-picker>

                    </div>
                    <div class="rightBtn">
                        <!-- <el-button type="primary" round class="baseBtn">搜索</el-button> -->
                    </div>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column label="ID" width="80">
                            <template slot-scope="scope">
                                {{(scope.$index + 1) + (pagination - 1) * 6}}
                            </template>
                        </el-table-column>
                        <el-table-column prop="v_type" label="电子券类别">
                            <template slot-scope="scope">
                                <div v-if="scope.row.v_type == 1">电子券</div>
                                <div v-if="scope.row.v_type == 2">优惠券</div>
                                <div v-if="scope.row.v_type == 3">礼品券</div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="voucher.full_name" label="电子券全称"></el-table-column>
                        <el-table-column prop="user.name" label="微信昵称" width="80"></el-table-column>
                        <el-table-column prop="" label="头像" width="80">
                             <template slot-scope="scope">
                                <img :src="scope.row.user.avatarurl" alt="" style="width:50px;height:50px;" v-if="scope.row.user!=null">
                            </template>
                        </el-table-column>
                        <el-table-column prop="user.mobile" label="兑换人"></el-table-column>
                        <el-table-column prop="created_at" label="兑换时间"></el-table-column>
                        <el-table-column prop="created_at" label="失效时间"></el-table-column>
                        <el-table-column prop="" label="核销二维码">
                            <template slot-scope="scope">
                                <div class="scopeLink flex flex-middle flex-center">
                                    <!-- <div @click="handleSeePhoto(scope.$index, scope.row.id)" v-if="scope.row.state == '待核销'">点击查看</div> -->
                                    <!-- <div @click="handleSeePhoto(scope.$index, scope.row)" v-else></div> -->
                                    <el-button size="mini" @click="handleSeePhoto(scope.$index, scope.row.id)" v-if="scope.row.state == '待核销'">点击查看</el-button>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="state" label="状态"></el-table-column>
                    </el-table>
                </div>
            </div>
        </div>
        <!-- 分页 -->
        <el-pagination background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>
    <el-dialog title="核销二维码" :visible.sync="dialogVisible" width="30%" >
        <img :src="heXiaoImg" alt="" class="heXiaoImg">
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
var loading;
export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            activeName: "first",
            options: [{
                    value: "选项1",
                    label: "电子券类别"
                },
                {
                    value: "选项2",
                    label: "电子券全称"
                },
                {
                    value: "选项3",
                    label: "兑换人"
                },
                {
                    value: "选项4",
                    label: "兑换时间"
                },
                {
                    value: "选项5",
                    label: "使用时间"
                },
                {
                    value: "选项6",
                    label: "核销二维码"
                },
                {
                    value: "选项7",
                    label: "状态"
                }
            ],
            optionsHeXiaoState: [{
                    value: "1",
                    label: "待核销"
                },
                {
                    value: "2",
                    label: "已核销"
                },
                {
                    value: "3",
                    label: "已失效"
                }
            ],
            value: "",
            tableData: [],
            total: 0,
            pagination: 1,
            dialogVisible: false,
            heXiaoImg: "",
            duiHuanTime: [],
            pageSize:interfaceApi.pageSize
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        handleClick(tab, event) {
            console.log(tab, event);
        },

        handleSeePhoto(index, row) {
            console.log(index, row);
            this.dialogVisible = true;
            this.voucher_qrcode(row)
        },

        // 核销二维码查看
        voucher_qrcode(id) {
            var data = {};
            data.id = id;
            interfaceApi.voucher_qrcode(data, (res) => {
                console.log(res, "==voucher_qrcode==")
                if (res.code == 200) {
                    this.heXiaoImg = res.data.path
                }
            })
        },

        //    电子券订单详情
        voucherorder_list(
            page = 1,
            paginate = interfaceApi.pageSize,
            u_id = "",
            v_id = "",
            state = "",
            time = "",
            s_id = ""
        ) {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.u_id = u_id;
            data.v_id = v_id;
            data.state = state;
            data.time = time;
            data.s_id = s_id;
            interfaceApi.voucherorder_list(data, res => {
                console.log(res, "==voucherorder_list==");
                if (res.code === 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                    var tableData = [];
                    for (var i of res.data.data) {
                        if (i.state == 1) {
                            i.state = "待核销"
                        } else if (i.state == 2) {
                            i.state = '已核销'
                        } else {
                            i.state = '已失效'
                        }
                        tableData.push(i)
                    }
                    this.tableData = tableData;
                }
            });
        },

        currentChange(e) {
            this.pagination = e;
            this.voucherorder_list(e);
        },

        heXiaoState(e) {
            console.log(e, "==e===")
            this.voucherorder_list(1, interfaceApi.pageSize, "", "", e);
        },

        //兑换时间
        changeTime(e) {
            this.voucherorder_list(1, interfaceApi.pageSize, "", "", "", e);
        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.voucherorder_list();
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

.heXiaoImg {
    width: 200px;
    height: 200px;
    object-fit: contain;
}

.rightBtn .baseBtn {
    margin-left: 20px;
}
</style>
