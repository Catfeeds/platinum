<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <el-tabs v-model="activeName" type="card" @tab-click="handleClick">
                <el-tab-pane label="电子券管理" name="first">
                    <div class="tabContent">
                        <div class="tabTop flex flex-middle flex-between">
                            <div class="leftBtn">
                                <el-button type="primary" round class="baseBtn" @click="export_list()">导出完整列表</el-button>
                                <el-button type="primary" round class="baseBtn" @click="electAdd()">添加</el-button>
                                <el-input v-model="searchInput" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput"></el-input>
                            </div>
                            <!-- <div class="rightBtn">

                                <el-cascader v-model="value" :options="firstOptions" :props="{ expandTrigger: 'hover' }" @change="firsthandleChange"></el-cascader>
                                <el-input v-model="searchInput" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput"></el-input>
                                <el-button type="primary" round class="baseBtn">搜索</el-button>
                            </div> -->
                        </div>

                        <div class="tabInfo">
                            <el-table :data="tableData" border style="width: 100%">
                                <el-table-column label="电子券排序">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="full_name" label="电子券全称"></el-table-column>
                                <el-table-column prop="text" label="电子券介绍"></el-table-column>
                                <el-table-column prop="giftPic" label="电子券大图">
                                    <template slot-scope="scope">
                                        <img :src="scope.row.cover" alt />
                                    </template>
                                </el-table-column>
                                <el-table-column prop="giftSmallPic" label="电子券小图">
                                    <template slot-scope="scope">
                                        <img :src="scope.row.imgs[0]" alt />
                                    </template>
                                </el-table-column>
                                <el-table-column prop="integral" label="所需积分"></el-table-column>
                                <el-table-column prop="stock" label="库存"></el-table-column>
                                <el-table-column prop="created_at" label="添加时间" width="200"></el-table-column>
                                <el-table-column prop="" label="兑换时间" width="200">
                                    <template slot-scope="scope">
                                        {{scope.row.start}} - {{ scope.row.end}}
                                    </template>
                                </el-table-column>


                                <el-table-column prop="is_regist" label="新人礼">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.is_regist == 0">否</div>
                                        <div v-if="scope.row.is_regist == 1">是</div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="action" label="编辑" width="200">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center">
                                            <el-button size="mini" @click="handleEditor(scope.row, scope.row.id)">编辑</el-button>
                                            <el-button size="mini" @click="handleDel(scope.row, scope.row.id)">删除</el-button>
                                        </div>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </div>
                </el-tab-pane>

                <el-tab-pane label="兑换列表" name="second">
                    <div class="tabContent">
                        <div class="tabTop flex">
                            <el-button type="primary" round class="baseBtn" @click="export_list2()">导出完整列表</el-button>
                            <el-cascader style="margin-left:20px;" v-model="seconValue" :options="secondOptions" :props="{ expandTrigger: 'hover' }" @change="handleChange"></el-cascader>
                            <el-input v-model="input" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput"></el-input>
                        </div>

                        <div class="tabInfo">
                            <el-table :data="exTableData" border style="width: 100%">
                                <el-table-column label="ID" width="80">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="voucher.full_name" label="电子券全称"></el-table-column>
                                <el-table-column prop="user.member_no" label="兑换用户"></el-table-column>
                                <el-table-column prop="user.member_nickname" label="兑换人姓名"></el-table-column>
                                <el-table-column prop="user.mobile" label="兑换人手机"></el-table-column>
                                <el-table-column prop="num" label="兑换数量" width="80"></el-table-column>
                                <el-table-column prop="created_at" label="兑换时间"></el-table-column>
                                <el-table-column prop="state" label="状态" width="80">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.state == 1">待核销</div>
                                        <div v-if="scope.row.state == 2">已核销</div>
                                        <div v-if="scope.row.state == 3">已失效</div>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <h2 class="title">电子券管理</h2>
        </div>
        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>

        <el-pagination v-if="activeName == 'second'" background layout="prev, pager, next" :total="secondTotal" :page-size="pageSize" class="paginationStyle" @current-change="secondCurrentChange"></el-pagination>

    </div>
    <el-dialog title="电子券详情" :visible.sync="dialogFormVisible">
        <el-form :model="form">
            <el-form-item label="礼品券id" :label-width="formLabelWidth">
                <el-input v-model="form.id" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>
            <el-form-item label="名称" :label-width="formLabelWidth">
                <el-input v-model="form.name" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>
            <el-form-item label="库存" :label-width="formLabelWidth">
                <el-input v-model="form.stock" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>
            <el-form-item label="销量" :label-width="formLabelWidth">
                <el-input v-model="form.sales" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>
            <el-form-item label="兑换积分" :label-width="formLabelWidth">
                <el-input v-model="form.integral" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>

            <el-form-item label="详情" :label-width="formLabelWidth">
                <el-input type="textarea" :rows="2" placeholder="请输入内容" v-model="form.text" style="width:50%;display:flex"></el-input>
            </el-form-item>

            <el-form-item label="是否下架" :label-width="formLabelWidth">
                <el-select v-model="is_shelf" placeholder="请选择" style="width:50%;display:flex" @change="shelfBtn">
                    <el-option v-for="item in isXiajia" :key="item.value" :label="item.label" :value="item.value"></el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="封面图" :label-width="formLabelWidth">
                <el-upload class="upload-demo" :action="img_upload" :on-preview="handleCoverPreview" :on-remove="handleCoverRemove" :file-list="coverList" list-type="picture" style="width:50%;display:flex;flex-direction: column;" :on-success="handleCoverSuccess" :on-progress="openFullScreen">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>
            <el-form-item label="轮播图" :label-width="formLabelWidth">
                <el-upload class="upload-demo" :action="img_upload" :on-preview="handleWheelPreview" :on-remove="handleWheelRemove" :file-list="wheelList" list-type="picture" style="width:50%;display:flex;flex-direction: column;" :on-success="handleWheelSuccess" :on-progress="openFullScreen">
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="submitUp">确 定</el-button>
        </div>
    </el-dialog>

    <el-dialog title="导出列表" :visible.sync="dialogFormListVisible">
         <el-date-picker v-model="timeRange" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" style="width:50%">
            </el-date-picker>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormListVisible = false">取 消</el-button>
            <el-button type="primary" @click="downLoadExcel()">确 定</el-button>
        </div>
    </el-dialog>

    <el-dialog title="导出列表" :visible.sync="dialogFormListVisible2">
       <el-date-picker v-model="timeRange1" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" style="width:50%">
            </el-date-picker>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormListVisible2 = false">取 消</el-button>
            <el-button type="primary" @click="downLoadExcel2()">确 定</el-button>
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

var loading;
export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            timeRange:[],
            timeRange1:[],
            input: "",
            total: 0,
            searchInput: "",
            activeName: "first",
            firstOptions: [{
                value: 'is_shelf',
                label: '是否下架',
                children: [{
                    value: '1',
                    label: '是'
                }, {
                    value: '2',
                    label: '否'
                }]
            }],

            secondOptions: [{
                value: 'state',
                label: '状态',
                children: [{
                    value: '1',
                    label: '待核销'
                }, {
                    value: '2',
                    label: '已核销'
                }, {
                    value: '3',
                    label: '已失效'
                }, ]
            }],
            pageSize:interfaceApi.pageSize,
            value: "",
            tableData: [],
            exTableData: [],
            dialogFormVisible: false,
            form: {},
            is_shelf: "",
            coverList: [],
            wheelList: [],
            formLabelWidth: "120px",
            isXiajia: [{
                    value: "1",
                    label: "上架"
                },
                {
                    value: "2",
                    label: "下架"
                }
            ],
            img_upload: interfaceApi.img_upload,
            secondTotal: 0,
            seconValue: "",
            dialogFormListVisible: false,
            formList: {},
            exportIndex: "",
            exportList: [],
            dialogFormListVisible2: false,
            formList2: {},
            exportIndex2: "",
            exportList2: [],
            pagination: 1,
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

        // 编辑
        handleEditor(row, id) {
            console.log(row.id)
             this.$router.push({
                path:"/electAdd",
                query:{
                    type:"编辑",
                    id:id
                }
            })
        },
        //    礼品删除
        handleDel(index, id) {
            this.delTip(id);
        },

        //礼品删除
        voucher_de(id) {
            var data = {};
            data.id = id;
            interfaceApi.voucher_de(data, (res) => {
                console.log(res, "==voucher_de===")
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.voucher_list();
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        // 删除提示
        delTip(row) {
            this.$confirm("此操作将下架该信息, 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                })
                .then(() => {
                    this.voucher_de(row)
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: "已取消下架"
                    });
                });
        },

        //电子券详情
        voucher_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.voucher_deta(data, (res) => {
                console.log(res, "==res===")
                if (res.code === 200) {
                    this.dialogFormVisible = true;
                    this.form = res.data;
                    if (res.data.is_shelf == 1) {
                        this.is_shelf = "上架";
                    } else {
                        this.is_shelf = "下架";
                    }

                    var obj = {};
                    obj.url = res.data.cover;
                    this.coverList = [];
                    this.coverList.push(obj);
                    console.log(this.coverList, "==coverList==")

                    var imgs = res.data.imgs;
                    var arr = [];
                    for (var i = 0; i < imgs.length; i++) {
                        var a = {};
                        a.url = imgs[i]
                        arr.push(a);
                    }
                    this.wheelList = arr;
                    console.log(this.wheelList, "==wheelList==")
                }
            })
        },

        //电子券修改
        voucher_up(id) {
            var data = {};
            console.log(this.form, "==form--")
            var arr = [];
            var imgs = this.wheelList;
            for (var i of imgs) {
                arr.push(i.url);
            }
            this.form.imgs = arr;
            data = this.form;
            interfaceApi.voucher_up(data, (res) => {
                console.log(res);
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.dialogFormVisible = false;
                    this.activeName = "first";
                    this.voucher_list();
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        handleCoverPreview(file) {
            console.log(file, "==231313==");
        },
        handleCoverSuccess(response, res, file) {
            console.log(response, "==response111")
            loading.close();
            if (response.code == 200) {
                // this.wheel_img = response.data.path;
                this.coverList = [];
                var obj = {};
                obj.url = response.data.path;
                this.coverList.push(obj);
                this.form.cover = this.coverList;
            }else if(response.code == 215){
                this.$message.error(response.data);
            }
        },

        handleCoverRemove(file, fileList) {
            console.log(file, fileList);
            this.coverList = fileList;
            this.form.cover = fileList;
        },

        handleWheelPreview() {},
        handleWheelRemove(file, fileList) {
            console.log(fileList);
            this.wheelList = fileList;
            this.form.imgs = fileList;
        },
        handleWheelSuccess(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                // this.wheel_img = response.data.path;
                var obj = {};
                obj.url = response.data.path;
                this.wheelList.push(obj);
                this.form.imgs = this.wheelList;
            }else if(response.code == 215){
                 this.$message.error(response.data);
            }
        },

        openFullScreen() {
            loading = this.$loading({
                lock: true,
                text: '加载中',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        shelfBtn(e) {
            this.form.is_shelf = e;
        },

        // 确定更新
        submitUp() {
            console.log(this.form, "==form===")
            this.voucher_up();
        },

        currentChange(e) {
            this.pagination = e;
            this.voucher_list(e)
        },

        firsthandleChange(e) {
            console.log(e)
            if (e[0] == "is_shelf") {
                this.voucher_list(1, interfaceApi.pageSize, "", "", e[1]);
            }
        },

        //电子券list
        voucher_list(page = 1, paginate = interfaceApi.pageSize, name = "", type = "", is_shelf = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.name = name;
            data.type = type;
            data.is_shelf = is_shelf;
            interfaceApi.voucher_list(data, (res) => {
                console.log(res, "==voucher_list===")
                if (res.code == 200) {
                    for(var i of res.data.data){
                          i.start = i.start.split(" ")[0];
                          i.end = i.end.split(" ")[0];
                    }
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            })
        },

        electAdd() {
            this.$router.push({
                path:"/electAdd",
                query:{
                    type:"添加"
                }
            })
        },

        //    电子券订单详情
        voucherorder_list(page = 1, paginate = interfaceApi.pageSize, u_id = "", v_id = "", state = "", time = "", s_id = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.u_id = u_id;
            data.v_id = v_id;
            data.state = state;
            data.time = time;
            data.s_id = s_id;
            interfaceApi.voucherorder_list(data, (res) => {
                console.log(res, "==voucherorder_list==")
                if (res.code === 200) {
                    this.exTableData = res.data.data;
                    this.secondTotal = res.data.total;
                }
            })
        },

        // 
        handleChange(e) {
            console.log(e)
            if (e[0] == "state") {
                this.voucherorder_list(1, interfaceApi.pageSize, "", "", e[1]);
            }
        },

        // 第二个分页
        secondCurrentChange(e) {
            this.pagination = e;
            this.voucherorder_list(e)
        },

        export_list() {
            this.dialogFormListVisible = true;
        },

        //导出列表
        voucher_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.voucher_excel(data, (res) => {
                console.log(res, "==voucher_excel===");
                if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
            })
        },

        downLoadExcel() {
             var timeRange = this.timeRange;
            this.voucher_excel(1,timeRange);
        },

        export_list2() {
            this.dialogFormListVisible2 = true;
        },

        //导出列表
        voucherorder_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.voucherorder_excel(data, (res) => {
                console.log(res, "==voucherorder_excel===");
               if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
            })
        },

        downLoadExcel2() {
            var timeRange1 = this.timeRange1;
            this.voucherorder_excel(1,timeRange1);
        }
    },

    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.voucher_list();
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

        .tabContent {
            text-align: left;
            padding: 0 20px;

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
                cursor: pointer;
            }

            .el-table .cell img {
                width: 50px;
                height: 50px;
                object-fit: cover;
            }
        }
    }
}

.exList .baseBtn {
    margin-left: 20px;
}

.el-form-item__content {
    display: flex !important;
}
</style>
