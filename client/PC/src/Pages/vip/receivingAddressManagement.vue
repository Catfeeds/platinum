<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">收货地址管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <!-- <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                    <el-select v-model="value" placeholder="请选择" clearable class="stateSelect">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-input v-model="input" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput"></el-input> -->
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                        <el-input v-model="searchInput" placeholder="请输入手机号" prefix-icon="el-icon-search" class="searchInput" clearable @change="searchMobile"></el-input>
                    </div>
                    <div class="rightBtn">
                        <!-- <el-select v-model="value" placeholder="请选择" clearable class="stateSelect">
                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                        </el-select> -->
                    </div>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column label="ID" width="60">
                            <template slot-scope="scope">
                                {{(scope.$index + 1) + (pagination - 1) * 6}}
                            </template>
                        </el-table-column>
                        <el-table-column prop="user.member_nickname" label="会员昵称" width="130"></el-table-column>
                        <el-table-column prop="name" label="微信昵称"></el-table-column>
                        <el-table-column prop="" label="头像">
                             <template slot-scope="scope">
                                <img :src="scope.row.user.avatarurl" alt="" style="width:50px;height:50px;" v-if="scope.row.user!=null">
                            </template>
                        </el-table-column>
                        <el-table-column prop="name" label="收货姓名"></el-table-column>
                        <el-table-column prop="mobile" label="收货手机"></el-table-column>
                        <el-table-column prop="" label="收货地区">
                             <template slot-scope="scope">
                                    {{scope.row.provinced.name}}-{{scope.row.cityd.name}}-{{scope.row.aread.name}}
                                </template>
                        </el-table-column>
                        <el-table-column prop="addr" label="收货地址"></el-table-column>
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
            activeName: "first",
            options: [{
                    value: "选项1",
                    label: "会员昵称"
                },
                {
                    value: "选项2",
                    label: "收货姓名"
                },
                {
                    value: "选项3",
                    label: "收货手机"
                },
                {
                    value: "选项4",
                    label: "收货地区"
                },
                {
                    value: "选项5",
                    label: "收货地址"
                }
            ],
            value: "",
            tableData: [],
            total: 0,
            searchInput: "",
            pagination: 1,
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
        },

        // 用户收货地址list
        member_addr_list(page = 1, paginate =interfaceApi.pageSize, u_id = "", name = "", province = "", city = "", area = "",mobile="") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.u_id = u_id;
            data.name = name;
            data.province = province;
            data.city = city;
            data.area = area;
            data.mobile = mobile;
            interfaceApi.member_addr_list(data, (res) => {
                console.log(res, "==res===")
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            })
        },
        currentChange(e) {
            console.log(e)
            this.pagination = e;
            this.member_addr_list(e);
        },

        // 搜索
        searchBtn() {
            var searchInput = this.searchInput;
            this.member_addr_list(1, interfaceApi.pageSize, "", searchInput);

        },

        // 请输入手机号
        searchMobile(e){
            console.log(e)
               this.member_addr_list(1,interfaceApi.pageSize,"","","","","",e);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.member_addr_list();
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
        padding-bottom: 20px;

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

.rightBtn .baseBtn {
    margin-left: 20px;
}
</style>
