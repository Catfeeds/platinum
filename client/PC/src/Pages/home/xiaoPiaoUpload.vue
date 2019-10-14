<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <el-tabs v-model="activeName" type="card" @tab-click="handleClick">
                <el-tab-pane label="列表" name="first">
                    <div class="tabContent">
                        <div class="tabTop flex flex-middle">
                            <el-button type="primary" round class="baseBtn" @click="export_list()">导出完整列表</el-button>
                            <el-select v-model="value" placeholder="筛选" class="stateSelect" @change="stateOptions" clearable>
                                <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                            </el-select>
                            <el-input v-model="input" type="tel" placeholder="请输入手机号码" prefix-icon="el-icon-search" class="searchInput" @change="searchBtn" clearable></el-input>
                        </div>

                        <div class="tabInfo">
                            <el-table :data="tableData" border style="width: 100%">
                                <el-table-column prop="" label="ID" fixed="left">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="receipt_activity.name" label="活动" width="180"></el-table-column>
                                <el-table-column prop="receipt_no" label="单号" width="180"></el-table-column>
                                <el-table-column prop="user.name" label="微信昵称" width="100"></el-table-column>
                                <el-table-column prop="" label="头像">
                                    <template slot-scope="scope">
                                        <img style="width:50px;height:50px;" :src="scope.row.user.avatarurl" alt="" v-if="scope.row.user!=null">
                                    </template>
                                </el-table-column>
                                <el-table-column prop="user.mobile" label="会员手机号" width="180"></el-table-column>
                                <el-table-column prop="buy_time" label="购买时间" width="180"></el-table-column>
                                <el-table-column prop="buy_money" label="购买金额" width="100"></el-table-column>
                                <el-table-column prop="brand" label="购买品牌" width="180"></el-table-column>
                                <el-table-column prop="model" label="购买品类" width="100"></el-table-column>
                                <el-table-column prop="text" label="购买理由" width="100"></el-table-column>
                                <el-table-column label="状态" width="100">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.state == 2">初审通过</div>
                                    </template>
                                </el-table-column>
                                <el-table-column label="是否返现" width="100">
                                    <!-- w_id -->
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.w_id == null">否</div>
                                        <div v-else>是</div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="imgs" label="照片" width="140">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center">
                                            <el-button size="mini" @click="handleSeePhoto(scope.$index, scope.row)">点击查看</el-button>
                                        </div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="firstCheck" label="初审" width="180" fixed="right">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center" v-if="scope.row.state == 1">
                                            <el-button size="mini" @click="handleChuShenPass(scope.$index, scope.row.id)">通过</el-button>
                                            <el-button size="mini" @click="handleChuShenOver(scope.$index, scope.row.id)">驳回</el-button>
                                        </div>
                                        <div class="flex flex-middle flex-center" v-if="scope.row.state == 2">
                                            <div style="color:#ccc;">通过</div>
                                        </div>
                                        <div class="flex flex-middle flex-center" v-if="scope.row.state == 3">
                                            <div style="color:#ccc;">驳回</div>
                                        </div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="endCheck" label="复核" width="180" fixed="right">
                                    <template slot-scope="scope">
                                        <div class="flex flex-middle flex-center" v-if="scope.row.re_state == 2">
                                            <div style="color:#ccc;">通过</div>
                                        </div>
                                        <div class="flex flex-middle flex-center" v-if="scope.row.re_state == 3">
                                            <div style="color:#ccc;">驳回</div>
                                        </div>
                                        <div class="scopeLink flex flex-middle flex-center" v-if="scope.row.state == 2 && scope.row.re_state == 1">
                                            <el-button size="mini" @click="handlefuhePass(scope.row, scope.row.id)">通过</el-button>
                                            <el-button size="mini" @click="handlefuheOver(scope.row, scope.row.id)">驳回</el-button>
                                        </div>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="互动设置" name="second">
                    <div class="tabContent">
                        <div class="secondContent">
                            <div class="add" @click="save()">保存</div>
                            <div class="form">
                                <div class="formLeft">
                                    <!-- 互动名称 -->
                                    <div class="formContent">
                                        <div class="name">是否启用互动</div>
                                        <div class="input">
                                            <el-select v-model="isQiYongHuDongIndex" placeholder="请选择">
                                                <el-option v-for="item in isQiYongHuDong" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                        </div>
                                    </div>

                                    <!-- 互动链接 -->
                                    <div class="formContent">
                                        <div class="name">浮层按钮文案</div>
                                        <div class="input">
                                            <el-input v-model="button_text" placeholder="请输入内容"></el-input>
                                        </div>
                                    </div>

                                    <!-- <div class="formContent">
                                        <div class="name">浮层提示文案</div>
                                        <div class="input">
                                            <el-input v-model="msg_text" placeholder="请输入内容"></el-input>
                                        </div>
                                    </div>

                                    <div class="formContent">
                                        <div class="name">互动链接</div>
                                        <div class="input">
                                            <el-input v-model="huDongUrl" placeholder="请输入内容"></el-input>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="formRight">
                                    <!-- 品牌商品详情大图 -->
                                    <div class="formContent">
                                        <div class="name">小票上传成功提示弹框图</div>
                                        <!-- 图片显示 -->
                                        <div class="bannerInfoBigImg" style="margin-left:20px;">
                                            <div class="bannerInfoBigImgShow">
                                                <div class="defaultCoverState" v-if="defaultBannerState">
                                                    <img :src="wheel_img" class="avatar" />
                                                </div>

                                                <div v-else>
                                                    <span class="bannerInfoBigImgShowTip">图片</span>
                                                    <span class="bannerInfoBigImgShowTip">750pt x 750pt</span>
                                                </div>
                                            </div>
                                            <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess" :on-progress="openFullScreen">
                                                <el-button>上传</el-button>
                                            </el-upload>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <h2 class="title">小票上传管理</h2>
        </div>
        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>

    <!-- 图片信息 -->
    <el-dialog title="图片查看" :visible.sync="dialogImgVisible" width="50%" :before-close="handleImgClose">
        <div class="xiaoPiaoImg">
            <img :src="item" alt class="xiaoPiaoImgInfo" v-for="(item,index) in xiaoPiaoImgInfo" :key="index" />
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="dialogImgVisible = false">取 消</el-button>
            <el-button type="primary" @click="dialogImgVisible = false">确 定</el-button>
        </span>
    </el-dialog>

    <el-dialog title="导出列表" :visible.sync="dialogFormVisible">
         <el-date-picker v-model="timeRange" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" style="width:50%">
            </el-date-picker>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="downLoadExcel()">确 定</el-button>
        </div>
    </el-dialog>

    <el-dialog title="积分与返现" :visible.sync="dialogFormVisibleShenhe">
        <el-form>
            <el-form-item label="积分" :label-width="formLabelWidth">
                <el-input v-model="jifen" type="number" autocomplete="off" style="width:50%;display:flex;"></el-input>
            </el-form-item>
            <el-form-item label="倍数" :label-width="formLabelWidth">
                <el-select v-model="beiShu" placeholder="请选择" style="width:50%;display:flex;">
                    <el-option v-for="item in perNumOptions" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="返现金额" :label-width="formLabelWidth" style="text-align:left;">
                <span>{{fanXianMoney}}元</span>
            </el-form-item>
        </el-form>

        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisibleShenhe = false">取 消</el-button>
            <el-button type="primary" @click="zengSongJifenBtn">确 定</el-button>
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
            options: [{
                    value: "1",
                    label: "未初审"
                },
                {
                    value: "2",
                    label: "初审通过未复核"
                },
                {
                    value: "3",
                    label: "初审驳回"
                },
                {
                    value: "4",
                    label: "复核通过"
                },
                {
                    value: "5",
                    label: "复核驳回"
                }
            ],
            value: "",
            tableData: [],
            input: "",
            dialogImgVisible: false,
            xiaoPiaoImgInfo: "",
            total: 0,
            pageSize: interfaceApi.pageSize,
            pagination: 1,
            isQiYongHuDong: [{
                    value: "1",
                    label: "是"
                },
                {
                    value: "2",
                    label: "否"
                }
            ],
            perNumOptions: [],
            beiShu: 1,
            img_upload: interfaceApi.img_upload,
            isQiYongHuDongIndex: "",
            button_text: "",
            msg_text: "",
            huDongUrl: "",
            defaultBannerState: false,
            wheel_img: "",
            dialogFormVisible: false,
            form: {},
            exportIndex: "",
            exportList: [],
            dialogFormVisibleShenhe: false,
            jifen: "",
            formLabelWidth: "150px",
            fuheIndex: "",
            fanXianMoney: 0, //返现金额
            user_w: [],
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

        // 获取倍数
        getPerNum() {
            var arr = [];
            for (var i = 1; i < 11; i++) {
                var obj = {};
                obj.value = i;
                obj.label = i;
                arr.push(obj);
            }
            this.perNumOptions = arr;
            console.log(this.perNumOptions, "==this.perNumOptions ===")
        },

        handleSeePhoto(index, row) {
            console.log(index, row);
            var tableData = this.tableData;
            console.log(tableData, "===tableData==");
            this.dialogImgVisible = true;
            this.xiaoPiaoImgInfo = tableData[index].imgs;
        },

        // 初审通过
        handleChuShenPass(index, row) {
            this.Tip(row, "通过初审", "取消初审", 2)
        },

        // 初审驳回
        handleChuShenOver(index, row) {
            this.Tip(row, "驳回初审", "驳回取消", 3)
        },

        // 提示 -- 初审
        Tip(row, tip, text, state, cb) {
            this.$confirm("此操作将" + tip + ", 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                })
                .then(() => {
                    // cb();
                    this.receipt_pre_exa(row, state);
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: text
                    });
                });
        },

        handleImgClose(done) {
            done();
        },

        // 复核通过
        handlefuhePass(res, row) {
            console.log(res, "==res==");
            console.log(this.tableData, "==tableData==")
            this.fanXianMoney = 0;
            for (var i of this.tableData) {
                if (i.id == row) {
                    console.log(i.user_w, "==user_w==")
                    if (i.user_w != null) {
                        this.fanXianMoney = i.user_w.money;
                    }
                }
            }
            this.dialogFormVisibleShenhe = true;
            this.fuheIndex = row;
            this.jifen = Math.floor(res.buy_money / 10);
            this.beiShu = 1;

        },

        // 复核驳回
        handlefuheOver(index, row) {
            // this.receipt_to_re(row, 3);
            this.Tip2(row, "驳回复核", "取消", 3)
        },

        // 提示 - 复审
        Tip2(row, tip, text, state, cb) {
            this.$confirm("此操作将" + tip + ", 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                })
                .then(() => {
                    // cb();
                    this.receipt_to_re(row, state);
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: text
                    });
                });
        },

        // 小票初审
        receipt_pre_exa(id, state, msg = "") {
            var that = this;
            var data = {};
            data.id = id;
            data.state = state;
            data.msg = msg;
            interfaceApi.receipt_pre_exa(data, res => {
                console.log(res, "==res==");
                if (res.code === 200) {
                    if (state == 2) {
                        this.$message({
                            message: "初审通过",
                            type: "success"
                        });
                    } else if (state == 3) {
                        this.$message({
                            message: "初审驳回",
                            type: "success"
                        });
                    }
                    var pagination = that.pagination;
                    that.receipt_list(pagination);
                } else {
                    this.$message.error(res.msg);
                }
            });
        },

        // 小票复核
        receipt_to_re(id, state, msg = "", integral = 1, multiple = 1) {
            var that = this;
            var data = {};
            data.id = id;
            data.state = state;
            data.msg = msg;
            data.integral = integral;
            data.multiple = multiple;

            if (data.integral == "") {
                this.$message.error('请输入赠送积分');
                return;
            }

            interfaceApi.receipt_to_re(data, res => {
                console.log(res, "==res==");
                loading.close();
                if (res.code === 200) {
                    if (state == 2) {
                        this.$message({
                            message: "复核通过",
                            type: "success"
                        });
                        this.dialogFormVisibleShenhe = false;
                    } else if (state == 3) {
                        this.$message({
                            message: "复核驳回",
                            type: "success"
                        });
                    }
                    var pagination = that.pagination;
                    that.receipt_list(pagination);
                } else {
                    this.$message.error(res.msg);
                }
            });
        },

        //小票list
        receipt_list(page = 1, paginate = interfaceApi.pageSize, state = "", mobile = "") {
            var that = this;
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.state = state;
            data.mobile = mobile;
            interfaceApi.receipt_list(data, res => {
                console.log(res, "==res==");
                if (res.code == 200) {
                    for (var i of res.data.data) {
                        i.buy_time = i.buy_time.split(" ")[0]
                    }

                    that.tableData = res.data.data;
                    that.total = res.data.total;

                }
            });
        },

        // 分页
        currentChange(e) {
            var pageSize = this.pageSize;
            this.pagination = e;
            this.receipt_list(e, pageSize);
        },

        // 状态筛选
        stateOptions(e) {
            var pageSize = this.pageSize;
            this.value = e;
            this.receipt_list(1, pageSize, e);
        },

        // 搜索
        searchBtn(e) {
            console.log(e, "==e==");
            var pageSize = this.pageSize;
            this.receipt_list(1, pageSize, "", e);
        },

        // 小票互动详情
        receipt_interaction_get() {
            var data = {};
            interfaceApi.receipt_interaction_get(data, res => {
                console.log(res, "=r=es====res===");
                if (res.code == 200) {
                    this.isQiYongHuDongIndex = res.data.is;
                    this.button_text = res.data.button_text;
                    this.msg_text = res.data.msg_text;
                    this.url = res.data.url;
                    if (res.data.img != "") {
                        this.defaultBannerState = true;
                        this.wheel_img = res.data.img;
                    }
                }
            });
        },

        // 保存
        save() {
            var is = this.isQiYongHuDongIndex;
            var button_text = this.button_text;
            var msg_text = "";
            var img = this.wheel_img;
            var url = "";
            this.receipt_interaction(is, button_text, msg_text, img, url);
        },

        // 小票互动修改
        receipt_interaction(is, button_text, msg_text, img, url) {
            var data = {};
            data.is = is;
            data.button_text = button_text;
            data.msg_text = msg_text;
            data.img = img;
            data.url = url;
            interfaceApi.receipt_interaction(data, res => {
                console.log(res, "==res==");
                this.openFullScreen();
                if (res.code == 200) {
                    this.$message({
                        message: '添加成功',
                        type: 'success'
                    });
                    this.activeName = "first";
                } else {
                    this.$message.error(res.msg);
                }
                loading.close();
            });
        },

        handleAvatarSuccess(response, res, file) {
            console.log(response, "==response");
            loading.close();
            if (response.code == 200) {
                this.wheel_img = response.data.path;
            }
        },
        openFullScreen() {
            loading = this.$loading({
                lock: true,
                text: "加载中",
                spinner: "el-icon-loading",
                background: "rgba(0, 0, 0, 0.7)"
            });
        },

        //导出列表
        export_list() {
            this.dialogFormVisible = true;
           
        },

        //导出列表
        receipt_excel(page = 1,time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.receipt_excel(data, (res) => {
                console.log(res, "==receipt_excel===");
                if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
               
            })
        },

        downLoadExcel() {
            var timeRange = this.timeRange;
            this.receipt_excel(1,timeRange);
           
        },

        // 赠送积分
        zengSongJifenBtn() {
            var id = this.fuheIndex;
            var jifen = this.jifen * this.beiShu;
            this.openFullScreen();
            this.receipt_to_re(id, 2, "", jifen)

        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.receipt_list();
        this.receipt_interaction_get();
        this.getPerNum();
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
        height: auto;
        margin-left: 40px;
        margin-top: 40px;
        background: #fff;
        display: flex;
        flex-direction: column;
        position: relative;
        padding-bottom: 50px;

        .tabTop {
            padding: 20px 0;
        }

        .tabContent {
            text-align: left;
            padding: 0 20px;

            .stateSelect {
                width: 200px;
                margin-left: 30px;
                margin-right: 30px;
            }

            .searchInput {
                width: 200px;
                float: right;
            }

            .scopeLink>div {
                border-bottom: 1px solid #666666;
                cursor: pointer;
            }

            .secondContent {
                width: 1510px;
                height: 92%;
                background: #fff;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                position: relative;

                .add {
                    width: 202px;
                    height: 51px;
                    font-size: 16px;
                    text-align: center;
                    line-height: 51px;
                    background: #233f68;
                    border-radius: 30px;
                    color: #fff;
                    letter-spacing: 4px;
                    margin-top: 26px;
                    margin-left: 46px;
                }

                .form {
                    width: 1250px;
                    height: auto;
                    margin-top: 36px;
                    margin-left: 46px;
                    display: flex;
                    justify-content: space-between;

                    .formLeft {
                        width: 550px;
                        height: auto;

                        .formContent {
                            align-items: center;
                        }
                    }

                    .formRight {
                        width: 520px;
                        height: auto;
                        background: auto;

                        .formContent {
                            width: 100%;
                        }

                        .brandGoodsIntroduce {
                            width: 100%;
                            height: auto;
                            display: flex;
                            justify-content: space-between;

                            .name {
                                font-size: 17px;
                                font-weight: bold;
                                letter-spacing: 2px;
                            }

                            .input {
                                width: 394px;
                                height: 156px;
                            }
                        }
                    }

                    .formContent {
                        width: 550px;
                        height: auto;
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 50px;

                        .name {
                            font-size: 17px;
                            // font-weight: bold;
                            color: #737373;
                            letter-spacing: 2px;
                            white-space: nowrap;
                        }

                        .input {
                            width: 396px;
                            height: 46px;
                            display: flex;
                            align-items: center;

                            .upload {
                                width: 202px;
                                height: 51px;
                                background: #233f68;
                                font-size: 17px;
                                border-radius: 5px;
                                font-weight: bold;
                                letter-spacing: 4px;
                                line-height: 51px;
                            }
                        }
                    }

                    .bannerInfoBigImg {
                        width: 100%;
                        height: auto;

                        .bannerInfoBigImgShow {
                            width: 352px;
                            height: 352px;
                            float: right;
                            border: 1px solid #b1b1b1;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;

                            .defaultCoverState {
                                width: 100%;
                                height: 100%;

                                img {
                                    width: 100%;
                                    height: 100%;
                                    object-fit: contain;
                                }

                                video {
                                    width: 100%;
                                    height: 100%;
                                    object-fit: contain;
                                }
                            }

                            .bannerInfoBigImgShowTip {
                                font-size: 17px;
                                color: #818181;
                            }

                            .bannerInfoBigImgShowTip:last-of-type {
                                margin-top: 10px;
                            }
                        }
                    }
                }
            }
        }
    }
}

.xiaoPiaoImg {
    width: 100%;
    height: 400px;
    overflow: auto;

    .xiaoPiaoImgInfo {
        width: 100%;
        height: auto;
        // object-fit: contain;
    }
}
</style><style scoped>
.upload-demo1 .el-button {
    width: 202px;
    height: 51px;
    background: #233f68;
    border-radius: 30px;
    color: #fff;
    letter-spacing: 4px;
    font-size: 16px;
    margin-top: 42px;
    margin-left: 106px;
}
</style>
