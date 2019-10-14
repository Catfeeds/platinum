<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <el-tabs v-model="activeName" type="card" @tab-click="handleClick">
                <el-tab-pane label="礼品管理" name="first">
                    <div class="tabContent">
                        <div class="tabTop flex flex-middle flex-between">
                            <div class="left">
                                <el-button type="primary" round class="baseBtn" @click="export_list()">导出完整列表</el-button>
                                <el-button type="primary" round class="baseBtn" @click="shopAdd()">添加</el-button>
                                <el-input v-model="searchInput" placeholder="请输入礼品简称" clearable prefix-icon="el-icon-search" class="searchInput" @change="searchBtn"></el-input>
                            </div>
                        </div>

                        <div class="tabInfo">
                            <el-table :data="tableData" border style="width: 100%">
                                <el-table-column label="礼品排序" width="100">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="full_name" label="礼品全称" width="130"></el-table-column>
                                <el-table-column prop="name" label="礼品简称" width="130"></el-table-column>
                                <el-table-column prop="text" label="礼品介绍"></el-table-column>
                                <el-table-column prop="giftPic" label="礼品大图">
                                    <template slot-scope="scope">
                                        <img :src="scope.row.cover" alt />
                                    </template>
                                </el-table-column>
                                <el-table-column prop="giftSmallPic" label="礼品小图">
                                    <template slot-scope="scope">
                                        <img :src="scope.row.imgs[0]" alt />
                                    </template>
                                </el-table-column>
                                <el-table-column prop="integral" label="所需积分"></el-table-column>
                                <el-table-column prop="stock" label="库存"></el-table-column>
                                <el-table-column prop="created_at" label="添加时间"></el-table-column>

                                <el-table-column prop="action" label="编辑">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center">
                                            <el-button size="mini" @click="handleEditor(scope.$index, scope.row.id)">编辑</el-button>
                                            <el-button size="mini" @click="handleDel(scope.$index, scope.row.id)">删除</el-button>
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
                            <el-cascader style="margin-left:30px" v-model="value" :options="options" :props="{ expandTrigger: 'hover' }" @change="handleChange"></el-cascader>
                            <el-input style="margin-left:30px" v-model="searchInput2" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput"></el-input>
                        </div>

                        <div class="tabInfo">
                            <el-table :data="exTableData" border style="width: 100%">
                                <el-table-column label="ID" width="70">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="gift.name" label="礼品全称"></el-table-column>
                                <el-table-column prop="user.member_nickname" label="兑换用户"></el-table-column>
                                <el-table-column prop="useraddr.name" label="收货姓名"></el-table-column>
                                <el-table-column prop="useraddr.mobile" label="收货手机"></el-table-column>
                                <el-table-column prop="useraddr.aread.name" label="收货地区"></el-table-column>
                                <el-table-column prop="useraddr.addr" label="收货地址"></el-table-column>
                                <el-table-column prop="num" label="兑换数量" width="80"></el-table-column>
                                <el-table-column prop="type" label="获取方式" width="80"></el-table-column>
                                <el-table-column prop="created_at" label="兑换时间" width="200"></el-table-column>
                                <el-table-column prop="state" label="状态" width="80">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.state == 1">待发货</div>
                                        <div v-if="scope.row.state == 2">已发送</div>
                                        <div v-if="scope.row.state == 3">已收货</div>
                                    </template>
                                </el-table-column>
                                <!-- <el-table-column prop="action" label="编辑" width="100">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center">
                                            <el-button size="mini" @click="handleDetailInfo(scope.$index, scope.row.id)">查看</el-button>
                                        </div>
                                    </template>
                                </el-table-column> -->
                            </el-table>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <h2 class="title">礼品管理</h2>
        </div>
        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>

        <!-- 分页 -->
        <el-pagination v-if="activeName == 'second'" background layout="prev, pager, next" :total="secondTotal" :page-size="scondPageSize" class="paginationStyle" @current-change="scondCurrentChange"></el-pagination>
    </div>

    <el-dialog title="礼品详情" :visible.sync="dialogFormVisible">
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

    <!--   订单礼品详情 -->
    <el-dialog title="礼品订单详情" :visible.sync="dialogTableVisible" width="90%">
        <el-table :data="gridData">
            <el-table-column prop="id" label="ID" width="80"></el-table-column>
            <el-table-column prop="gift.name" label="礼品全称"></el-table-column>
            <el-table-column prop="user.member_nickname" label="兑换用户"></el-table-column>
            <el-table-column prop="useraddr.name" label="收货姓名"></el-table-column>
            <el-table-column prop="useraddr.mobile" label="收货手机"></el-table-column>
            <el-table-column prop="useraddr.aread.name" label="收货地区"></el-table-column>
            <el-table-column prop="useraddr.addr" label="收货地址"></el-table-column>
            <el-table-column prop="num" label="兑换数量" width="80"></el-table-column>
            <el-table-column prop="type" label="获取方式" width="80"></el-table-column>
            <el-table-column prop="created_at" label="兑换时间"></el-table-column>
            <el-table-column prop="state" label="状态" width="80"></el-table-column>
        </el-table>
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
            activeName: "first",
            searchInput: "",
            searchInput2: "",
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
                },
                {
                    value: 'type',
                    label: '领取方式',
                    children: [{
                        value: '1',
                        label: '物流'
                    }, {
                        value: '2',
                        label: '到店'
                    }]
                }
            ],
            value: "",
            tableData: [],
            exTableData: [],
            dialogFormVisible: false,
            form: {},
            formLabelWidth: "120px",
            isXiajia: [{
                    value: "1",
                    label: "下架"
                },
                {
                    value: "2",
                    label: "上架"
                }
            ],
            is_shelf: "",
            img_upload: interfaceApi.img_upload,
            coverList: [],
            wheelList: [],
            total: 0,
            pagination: 1,
            pageSize: interfaceApi.pageSize,
            secondTotal: 0,
            scondPageSize: interfaceApi.pageSize,
            gridData: [],
            dialogTableVisible: false,
            dialogFormListVisible: false,
            formList: {},
            exportIndex: "",
            exportList: [],
            dialogFormListVisible2: false,
            formList2: {},
            exportIndex2: "",
            exportList2: [],
            timeRange:[],
            timeRange1:[]
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

        shopAdd() {
            this.$router.push({
                path: "/shopAdd",
                query: {
                    type: "添加"
                }
            });
        },

        searchBtn(e) {
            this.giftvoucher_list(1, interfaceApi.pageSize, e);
        },

        currentChange(e) {
            this.pagination = e;
            this.giftvoucher_list(1, interfaceApi.pageSize, e);
        },

        // 礼品list
        giftvoucher_list(page = 1, paginate = interfaceApi.pageSize, name = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.name = name;
            interfaceApi.giftvoucher_list(data, res => {
                console.log(res, "===res==");
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            });
        },

        // 编辑
        handleEditor(index, id) {
            this.$router.push({
                path: "/shopAdd",
                query: {
                    type: "编辑",
                    id:id
                }
            });
            // this.giftvoucher_deta(id);
        },

        // 礼品详情
        giftvoucher_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.giftvoucher_deta(data, res => {
                console.log(res, "==giftvoucher_deta==");
                if (res.code == 200) {
                    this.dialogFormVisible = true;
                    if (res.data.is_shelf == 1) {
                        this.is_shelf = "下架";
                    } else {
                        this.is_shelf = "上架";
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
                    this.form = res.data;
                }
            });
        },
        handleCoverRemove(file, fileList) {
            console.log(file, fileList);
            this.coverList = fileList;
            this.form.cover = fileList;

        },
        handleCoverPreview(file) {
            console.log(file, "==231313==");
        },
        handleCoverSuccess(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                // this.wheel_img = response.data.path;
                this.coverList = [];
                var obj = {};
                obj.url = response.data.path;
                this.coverList.push(obj);
                this.form.cover = this.coverList;
            }
        },

        handleWheelPreview() {},
        handleWheelRemove(file, fileList) {
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
            console.log(e, "===e===")
            this.form.is_shelf = e;
        },

        // 确定更新
        submitUp() {
            this.openFullScreen();
            this.giftvoucher_up();
        },

        // 礼品修改
        giftvoucher_up() {
            var data = {};
            console.log(this.form, "==form--")
            var arr = [];
            var imgs = this.wheelList;
            for (var i of imgs) {
                arr.push(i.url);
            }
            this.form.imgs = arr;
            data = this.form;
            interfaceApi.giftvoucher_up(data, (res) => {
                loading.close();
                console.log(res);
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.dialogFormVisible = false;
                    this.activeName = "first";
                    this.giftvoucher_list();
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        //    礼品删除
        handleDel(index, id) {
            this.delTip(id);
        },

        //    礼品删除
        giftvoucher_de(id) {
            var data = {};
            data.id = id;
            interfaceApi.giftvoucher_de(data, (res) => {
                console.log(res, "==res===")
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.giftvoucher_list();
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
                    this.giftvoucher_de(row)
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: "已取消下架"
                    });
                });
        },

        //    礼品兑换list
        giftorder_list(page = 1, paginate = interfaceApi.pageSize, order_no = "", g_id = "", u_id = "", time = "", state = "", type = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.order_no = order_no;
            data.g_id = g_id;
            data.u_id = u_id;
            data.time = time;
            data.state = state;
            data.type = type;
            interfaceApi.giftorder_list(data, (res) => {
                console.log(res, "==res==giftorder_list")
                if (res.code == 200) {
                    this.exTableData = res.data.data;
                    var exTableData = [];
                    for (var i of res.data.data) {
                        if (i.type == 1) {
                            i.type = "物流"
                        } else {
                            i.type = "到店"
                        }
                        exTableData.push(i)
                    }
                    this.exTableData = exTableData
                }
            })
        },

        scondCurrentChange(e) {
            this.pagination = e;
            this.giftorder_list(e);
        },

        handleDetailInfo(index, id) {
            this.giftorder_deta(id);
        },
        //    礼品订单详情
        giftorder_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.giftorder_deta(data, (res) => {
                console.log(res.data, "===giftorder_deta===")
                if (res.code == 200) {
                    this.dialogTableVisible = true;
                    this.gridData = [];
                    this.gridData.push(res.data);
                }
            })
        },

        // 筛选
        handleChange(e) {
            console.log(e)
            if (e[0] == "state") {
                this.giftorder_list(1, interfaceApi.pageSize, "", "", "", "", e[1]);
            } else if (e[0] == "type") {
                this.giftorder_list(1, interfaceApi.pageSize, "", "", "", "", "", e[1]);
            }
        },

        export_list() {
            this.dialogFormListVisible = true;
        },

        //导出列表
        giftvoucher_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.giftvoucher_excel(data, (res) => {
                console.log(res, "==giftvoucher_excel===");
                 if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
            })
        },

        downLoadExcel() {
            var timeRange = this.timeRange;
            this.giftvoucher_excel(1,timeRange);
        },

        export_list2() {
            this.dialogFormListVisible2 = true;
        },

        //导出列表
        giftorder_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.giftorder_excel(data, (res) => {
                console.log(res, "==giftorder_excel===");
                 if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
            })
        },

        exportBtn2(e) {
            this.exportIndex = e;
        },

        downLoadExcel2() {
            var timeRange1 = this.timeRange1;
            this.giftorder_excel(1,timeRange1);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.giftvoucher_list();
        this.giftorder_list();
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
