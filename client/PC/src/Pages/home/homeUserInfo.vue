<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">个人信息管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex ">
                    <el-button type="primary" round class="baseBtn" @click="export_list()">导出完整列表</el-button>
                    <el-input style="margin-left:30px;" clearable v-model="searchInput" type="tel" placeholder="请输入手机号码" prefix-icon="el-icon-search" class="searchInput" @change="searchMobile"></el-input>
                    <el-input style="margin-left:30px;" clearable v-model="searchName" type="tel" placeholder="请输入会员昵称" prefix-icon="el-icon-search" class="searchInput" @change="searchNameBtn"></el-input>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column label="ID" width="80">
                            <template slot-scope="scope">
                                {{(scope.$index + 1) + (pagination - 1) * 6}}
                            </template>
                        </el-table-column>
                        <el-table-column prop="member_nickname" label="会员昵称" width="120"></el-table-column>
                        <el-table-column prop="name" label="微信昵称" width="120"></el-table-column>
                        <el-table-column prop="unionid" label="unionid" width="300"></el-table-column>
                        <el-table-column prop="avatarurl" label="头像">
                            <template slot-scope="scope">
                                <img :src="scope.row.avatarurl" alt />
                            </template>
                        </el-table-column>
                        <el-table-column prop="mobile" label="会员手机号" width="180"></el-table-column>
                        <el-table-column prop="detail.sex" label="性别">
                            <template slot-scope="scope">
                                <div v-if="scope.row.detail.sex == 1">男</div>
                                <div v-if="scope.row.detail.sex == 2">女</div>
                                <div v-if="scope.row.detail.sex == null">暂无</div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="detail.birthday" label="生日" width="180"></el-table-column>
                        <el-table-column prop="provinced.name" label="省份"></el-table-column>
                        <el-table-column prop="cityd.name" label="城市"></el-table-column>
                        <el-table-column prop="aread.name" label="地址"></el-table-column>
                        <el-table-column prop="detail.memorial_day_name" label="纪念日" width="180">
                            <template slot-scope="scope">
                                <div class="scopeLink flex flex-middle flex-center">
                                    <el-button size="mini" @click="handleSeeTable(scope.$index, scope.row)">查看</el-button>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column prop="created_at" label="入会时间" width="180"></el-table-column>
                        <el-table-column prop="updated_at" label="最近访问时间" width="180"></el-table-column>
                        <el-table-column prop="b" label="资料完善度">
                            <template slot-scope="scope">
                                {{scope.row.b}}%
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
        </div>

        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>

    <!-- 嵌套表格的 -->
    <el-dialog title="纪念信息" :visible.sync="dialogTableVisible">
        <el-table :data="gridData">
            <el-table-column property="name" label="纪念名称"></el-table-column>
            <el-table-column property="date" label="纪念日期"></el-table-column>
        </el-table>
    </el-dialog>

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
import {
    interfaceApi
} from "../../utils/interfaceAPI";
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';

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
            tableData: [],
            searchInput: "",
            dialogTableVisible: false,
            gridData: [],
            total: 0,
            pageSize: interfaceApi.pageSize,
            pagination: 1,
            dialogFormVisible: false,
            form: {},
            exportIndex: "",
            exportList: [],
            searchName: "",
            timeRange: []
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

        // 个人信息管理
        // 用户list
        user_list(page = 1, paginate = interfaceApi.pageSize, mobile = "", member_nickname = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.mobile = mobile;
            data.member_nickname = member_nickname;
            interfaceApi.user_list(data, res => {
                console.log(res, "===用户list");
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            });
        },
        handleSeeTable(index, row) {
            this.dialogTableVisible = true;
            var tableData = this.tableData;
            var id = row.id;
            var arr = [];
            console.log(this.tableData, "==tableData")
            for (var i of tableData) {
                if (id == i.id) {
                    console.log(i.detail, "==detail;")
                    var obj = {};
                    obj.name = i.detail.full_name;
                    obj.date = i.detail.birthday;
                    arr.push(obj);
                }
            }

            if (arr[0].name !== null) {
                this.gridData = arr;
            } else {
                this.gridData = [];
            }

            console.log(this.gridData, "==gridData==")

        },
        currentChange(e) {
            this.pagination = e;
            this.user_list(e);
        },
        //手机号码查询
        searchMobile(e) {
            console.log(e, "==e==");
            this.user_list(1, interfaceApi.pageSize, e);
        },

        // 昵称搜索
        searchNameBtn(e) {
            this.user_list(1, interfaceApi.pageSize, "", e);
        },

        export_list() {
            this.dialogFormVisible = true;
        },

        //导出列表
        user_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.user_excel(data, (res) => {
                console.log(res, "==user_excel===");
                if (res.code == 200) {
                    window.location.href = res.data.url
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        downLoadExcel() {
            var timeRange = this.timeRange;
            this.user_excel(1, timeRange);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.user_list();
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
                border-bottom: 1px solid #666666;
            }
        }
    }
}
</style>
