<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">每日签到管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex ">
                    <el-button type="primary" round class="baseBtn" @click="export_list()">导出完整列表</el-button>
                    <div class="mobile">
                        <el-input v-model="searchInput" placeholder="请输入手机号" prefix-icon="el-icon-search" class="searchInput" @change="searchMobile">
                        </el-input>
                    </div>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column label="ID">
                            <template slot-scope="scope">
                                {{(scope.$index + 1) + (pagination - 1) * 6}}
                            </template>
                        </el-table-column>
                        <el-table-column prop="member_nickname" label="会员昵称"></el-table-column>
                        <el-table-column prop="name" label="微信昵称" width="120"></el-table-column>
                        <el-table-column prop="avatarurl" label="会员头像">
                             <template slot-scope="scope">
                                <img :src="scope.row.avatarurl" alt="" style="width:50px;height:50px;">
                            </template>
                        </el-table-column>
                        <el-table-column prop="mobile" label="会员手机号"></el-table-column>
                        <el-table-column prop="signin_count" label="签到总次数"></el-table-column>
                        <el-table-column prop="max_sign" label="最大连续签到次数"></el-table-column>
                        <el-table-column prop="continuity_sign" label="连续签到次数"></el-table-column>
                        <el-table-column prop="signin.created_at" label="最近签到的时间"></el-table-column>
                    </el-table>
                </div>
            </div>
        </div>

        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>

    <el-dialog title="导出列表" :visible.sync="dialogFormVisible">
       <el-date-picker v-model="timeRange" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" style="width:50%">
            </el-date-picker>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="downLoadExcel()">确 定</el-button>
        </div>
    </el-dialog>
</div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';

import {
    interfaceApi
} from "@/utils/interfaceAPI";

export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            activeName: "first",
            options: [{
                    value: "选项1",
                    label: "黄金糕"
                },
                {
                    value: "选项2",
                    label: "双皮奶"
                },
                {
                    value: "选项3",
                    label: "蚵仔煎"
                },
                {
                    value: "选项4",
                    label: "龙须面"
                },
                {
                    value: "选项5",
                    label: "北京烤鸭"
                }
            ],
            value: "",
            searchInput: "",
            tableData: [],
            total: 0,
            pageSize: interfaceApi.pageSize,
            pagination: 1,
            dialogFormVisible: false,
            form: {},
            exportIndex: "",
            exportList: [],
            timeRange:[]
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
        //查看纪念日
        handleSeeADay(index, row) {
            console.log(index, row);
        },

        // 签到list
        usersignin_list(page = 1, paginate = interfaceApi.pageSize, mobile = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.mobile = mobile;
            interfaceApi.usersignin_list(data, (res) => {
                console.log(res, "==re==")
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            })
        },

        currentChange(e) {
            this.pagination = e;
            this.usersignin_list(e);
        },

        // 搜索
        searchMobile(e) {
            this.usersignin_list(1, interfaceApi.pageSize, e);
        },

        export_list() {
            this.dialogFormVisible = true;
        },

        //导出列表
        usersignin_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.usersignin_excel(data, (res) => {
                console.log(res, "==usersignin_excel===");
                if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
               
            })
        },

        downLoadExcel() {
          var timeRange = this.timeRange;
            this.usersignin_excel(1,timeRange);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.usersignin_list();
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

    .mobile{
        margin-left: 30px;
    }

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
        background: #f5f6fa
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

        .contentPanel {
            margin-top: 50px;
            padding: 20px;

            .searchInput {
                width: 200px;
            }

            .tabInfo {
                padding-top: 40px;
            }

            .el-table .cell img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .scopeLink>div {
                border-bottom: 1px solid #666666
            }
        }
    }
}
</style>
