<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">我的礼品管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                        <el-cascader v-model="value" :options="options" :props="{ expandTrigger: 'hover' }" @change="handleChange" class="searchInput"></el-cascader>
                        <el-input v-model="mobile" type="tel" clearable placeholder="请输入手机号码" prefix-icon="el-icon-search" class="searchInput" @change="searchMobile"></el-input>
                    </div>
                    <div class="rightBtn">
                    </div>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column label="ID">
                            <template slot-scope="scope">
                                {{(scope.$index + 1) + (pagination - 1) * 6}}
                            </template>
                        </el-table-column>
                        <el-table-column prop="user.name" label="微信昵称"></el-table-column>
                        <el-table-column prop="" label="头像">
                            <template slot-scope="scope">
                                <img :src="scope.row.user.avatarurl" alt="" style="width:50px;height:50px;" v-if="scope.row.user!=null">
                            </template>
                        </el-table-column>
                        <el-table-column prop="useraddr.name" label="兑换人"></el-table-column>
                        <el-table-column prop="order_no" label="订单号"></el-table-column>
                        <el-table-column prop="e_order" label="快递单号"></el-table-column>
                        <el-table-column prop="created_at" label="兑换时间"></el-table-column>
                        <el-table-column prop="gift.name" label="兑换物品"></el-table-column>
                        <el-table-column prop="useraddr.name" label="收货姓名"></el-table-column>
                        <el-table-column prop="useraddr.mobile" label="收货手机"></el-table-column>
                        <el-table-column prop="" label="收货地区">
                            <template slot-scope="scope">
                                <div v-if="scope.row.useraddr!=null">{{scope.row.useraddr.provinced.name}}-{{scope.row.useraddr.cityd.name}}-{{scope.row.useraddr.aread.name}}</div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="useraddr.addr" label="收货地址"></el-table-column>
                        <el-table-column prop="state" label="状态">
                            <template slot-scope="scope">
                                <div v-if="scope.row.state == 1">待发货</div>
                                <div v-if="scope.row.state == 2">已发货</div>
                                <div v-if="scope.row.state == 3">已收货</div>
                            </template>
                        </el-table-column>

                        <el-table-column prop="" label="领取方式">
                            <template slot-scope="scope">
                                <div v-if="scope.row.type == 1">物流</div>
                                <div v-if="scope.row.type == 2">到店</div>
                            </template>
                        </el-table-column>

                        <el-table-column label="查看详情">
                            <template slot-scope="scope">
                                <div class="scopeLink flex flex-middle flex-center" style="cursor: pointer;">
                                    <el-button size="mini" @click="handleSeePhoto(scope.$index, scope.row)">查看</el-button>
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
import {
    interfaceApi
} from "@/utils/interfaceAPI";
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';

var data = {
    page: 1,
    paginate: 6,
    order_no: "", //快递单号
    g_id: "", //礼品id
    u_id: "", //用户id
    time: "", //兑换时间
    state: "", //状态 1待发货(待领取) 2已发货 3已收货(已领取)
    type: "" //领取方式 1物流 2到店
}; //调取接口数据
var search_txt = "";

export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            mobile: "",
            activeName: "first",
            options: [{
                value: 'state',
                label: '状态',
                children: [{
                    value: '1',
                    label: '待发货(待领取)'
                }, {
                    value: '2',
                    label: '已发送'
                }, {
                    value: '3',
                    label: '已收货(已领取)'
                }, ]
            }, {
                value: 'type',
                label: '领取方式',
                children: [{
                    value: '1',
                    label: '物流'
                }, {
                    value: '2',
                    label: '到店'
                }]
            }],
            value: "",
            tableData: [],
            input: "",
            total: 0,
            pagination: 1,
            pageSize: interfaceApi.pageSize
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        // 礼品管理列表
        present_admin() {
            //   var data = {};
            //   data.page = 1;
            //   data.paginate = 6;
            //   data.order_no = ""; //快递单号
            //   data.g_id = ""; //礼品id
            //   data.u_id = ""; //用户id
            //   data.time = ""; //兑换时间
            //   data.state = ""; //状态 1待发货(待领取) 2已发货 3已收货(已领取)
            //   data.type = ""; //领取方式 1物流 2到店
            interfaceApi.giftorder_list(data, res => {
                console.log(res, "==giftorder_list==");
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                    this.tableData.forEach(item => {
                        item.created_at = item.created_at.split(" ")[0];
                    });
                }
            });
        },

        handleClick(tab, event) {
            console.log(tab, event);
        },

        handleSeePhoto(index, row) {
            console.log(index, row);
            this.$router.push({
                path: "/myGiftsDetails",
                query: {
                    id: row.id,
                    type: row.type
                }
            });
        },

        // 搜索
        searchBtn() {
            data = {
                page: 1,
                paginate: interfaceApi.pageSize,
                order_no: "", //快递单号
                g_id: this.input, //礼品id
                u_id: "", //用户id
                time: "", //兑换时间
                state: "", //状态 1待发货(待领取) 2已发货 3已收货(已领取)
                type: "" //领取方式 1物流 2到店
            };
            this.present_admin(data);
            this.input = "";
        },

        //下一页
        currentChange(e) {
            console.log(search_txt, "==search_txt==");
            this.pagination = e;
            data = {
                page: e,
                paginate: interfaceApi.pageSize,
                order_no: "", //快递单号
                g_id: "", //礼品id
                u_id: "", //用户id
                time: "", //兑换时间
                state: "", //状态 1待发货(待领取) 2已发货 3已收货(已领取)
                type: "" //领取方式 1物流 2到店
            };
            this.present_admin(data);
        },

        // 筛选
        handleChange(e) {
            console.log(e)
            if (e[0] == "state") {
                data = {
                    page: 1,
                    paginate: interfaceApi.pageSize,
                    order_no: "", //快递单号
                    g_id: "", //礼品id
                    u_id: "", //用户id
                    time: "", //兑换时间
                    state: e[1], //状态 1待发货(待领取) 2已发货 3已收货(已领取)
                    type: "" //领取方式 1物流 2到店
                };
                this.present_admin(data);
            } else if (e[0] == "type") {
                data = {
                    page: 1,
                    paginate: interfaceApi.pageSize,
                    order_no: "", //快递单号
                    g_id: "", //礼品id
                    u_id: "", //用户id
                    time: "", //兑换时间
                    state: "", //状态 1待发货(待领取) 2已发货 3已收货(已领取)
                    type: e[1] //领取方式 1物流 2到店
                };
                this.present_admin(data);
            }
        },

        // 搜索手机号
        searchMobile(e) {
            console.log(e, "==e==")
            data = {
                page: 1,
                paginate: interfaceApi.pageSize,
                order_no: "", //快递单号
                g_id: "", //礼品id
                u_id: "", //用户id
                time: "", //兑换时间
                state: "", //状态 1待发货(待领取) 2已发货 3已收货(已领取)
                type: "", //领取方式 1物流 2到店
                mobile: e
            };
            this.present_admin(data);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.present_admin();
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
            margin-top: 50px;
            padding: 20px;

            .searchInput {
                width: 200px;
            }
        }
    }
}

// .rightBtn .baseBtn {
//     margin-left: 30px;
// }

.searchInput {
    margin-left: 20px;
}
</style>
