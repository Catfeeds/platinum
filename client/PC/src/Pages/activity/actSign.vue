<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <el-tabs v-model="activeName" type="card" @tab-click="handleClick">
                <el-tab-pane label="列表" name="first">
                    <div class="tabContent">
                        <div class="tabTop flex">
                            <el-button type="primary" round class="baseBtn" @click="export_list()">导出完整列表</el-button>
                            <el-input style="margin-left:30px;" v-model="searchInput" placeholder="请输入内容" prefix-icon="el-icon-search" class="searchInput" @change="search"></el-input>
                        </div>

                        <div class="tabInfo">
                            <el-table :data="tableData" border style="width: 100%">
                                <el-table-column label="ID" width="60">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="name" label="活动名称" width="100"></el-table-column>
                                <el-table-column prop="button_name" label="按钮文案"></el-table-column>
                                <el-table-column prop="integral" label="赠送积分"></el-table-column>
                                <el-table-column prop="url" label="内链"></el-table-column>
                                <el-table-column prop="start" label="开始时间"></el-table-column>
                                <el-table-column prop="end" label="结束时间"></el-table-column>
                                <el-table-column prop="created_at" label="创建时间"></el-table-column>
                                <el-table-column prop="qr_img" label="菊花码">
                                    <template slot-scope="scope">
                                        <img :src="scope.row.qr_img" alt="" style="width:50px;height:50px;" v-if="scope.row.qr_img!=null">
                                    </template>
                                </el-table-column>
                                <el-table-column prop="" label="编辑">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center">
                                            <el-button size="mini" @click="handleEditor(scope.$index, scope.row.id)">编辑</el-button>
                                            <el-button size="mini" @click="handleLook(scope.$index, scope.row.id)">查看</el-button>
                                        </div>
                                    </template>
                                </el-table-column>

                            </el-table>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane :label="activityName" name="second">
                    <div class="add" @click="editor()" v-if="activityName == '活动编辑'">保存</div>
                    <div class="add" @click="save()" v-else>保存</div>
                    <div class="form">
                        <div class="formLeft">
                            <!-- 互动名称 -->
                            <div class="formContent">
                                <div class="name">活动名称</div>
                                <div class="input">
                                    <el-input v-model="name" placeholder="请输入内容"></el-input>
                                </div>
                            </div>

                            <!-- 互动链接 -->
                            <div class="formContent">
                                <div class="name">按钮文案</div>
                                <div class="input">
                                    <el-input v-model="button_name" placeholder="请输入内容"></el-input>
                                </div>
                            </div>

                            <!-- 增加积分 -->
                            <div class="formContent">
                                <div class="name">增加积分</div>
                                <div class="input">
                                    <el-input v-model="integral" placeholder="请输入内容"></el-input>
                                </div>
                            </div>

                            <!-- 完成后跳转内链 -->
                            <!-- <div class="formContent">
                                <div class="name">跳转内链</div>
                                <div class="input">
                                    <el-input v-model="url" placeholder="请输入内容"></el-input>
                                </div>
                            </div> -->

                            <div class="formContent">
                                <div class="name">活动时间</div>
                                <div class="input">
                                    <el-date-picker style="width:600px;" v-model="activityTime" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" @change="getDate"></el-date-picker>
                                </div>
                            </div>

                            <div class="formContent" v-if="activityName == '活动编辑'">
                                <img :src="qr_img" alt="" style="width:200px;height:200px;display:block;margin:0 auto;">
                            </div>
                        </div>
                        <div class="formRight">
                            <!-- 品牌商品详情大图 -->
                            <div class="formContent">
                                <div class="name">首页展示图片上传</div>
                                <!-- 图片显示 -->
                                <div class="bannerInfoBigImg">
                                    <div class="bannerInfoBigImgShow">
                                        <div class="defaultCoverState" v-if="defaultBannerState">
                                            <img :src="wheel_img" class="avatar" />
                                        </div>
                                        <div v-else>
                                            <span class="bannerInfoBigImgShowTip">图片</span>
                                            <span class="bannerInfoBigImgShowTip">750pt x 350pt</span>
                                        </div>
                                    </div>
                                    <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess" :on-progress="openFullScreen">
                                        <el-button>上传</el-button>
                                    </el-upload>
                                </div>
                            </div>

                            <!-- 签到大图 -->
                            <div class="formContent">
                                <div class="name">签到大图</div>
                                <!-- 图片显示 -->
                                <div class="bannerInfoBigImg">
                                    <div class="bannerInfoBigImgShow">
                                        <div class="defaultCoverState" v-if="defaultQianDaoState">
                                            <img :src="qianDao_img" class="avatar" />
                                        </div>
                                        <div v-else>
                                            <span class="bannerInfoBigImgShowTip">图片</span>
                                            <span class="bannerInfoBigImgShowTip">750pt x 350pt</span>
                                        </div>
                                    </div>
                                    <el-upload style="margin-left:80px;" class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess2" :on-progress="openFullScreen">
                                        <el-button>上传</el-button>
                                    </el-upload>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <h2 class="title">活动签到管理</h2>
        </div>

        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>

    <el-dialog title="签到人员列表" :visible.sync="dialogTableVisible">
        <el-table :data="gridData">
            <el-table-column property="id" label="ID" width="150"></el-table-column>
            <el-table-column property="activity.name" label="活动名称" width="200"></el-table-column>
            <el-table-column property="user.member_nickname" label="签到会员名称"></el-table-column>
            <el-table-column property="user.mobile" label="签到会员手机"></el-table-column>
            <el-table-column property="created_at" label="签到时间"></el-table-column>
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
            activityName: "活动添加",
            name: "",
            button_name: "",
            integral: "",
            url: "",
            defaultBannerState: false,
            img_upload: interfaceApi.img_upload,
            activityTime: [],
            value: "",
            tableData: [],
            total: 0,
            pageSize: interfaceApi.pageSize,
            pagination: 1,
            searchInput: "",
            startTime: "",
            endTime: "",
            wheel_img: "",
            editorid: "",
            dialogTableVisible: false,
            gridData: [],
            dialogFormVisible: false,
            form: {},
            exportIndex: "",
            exportList: [],
            defaultQianDaoState: false,
            qianDao_img: "",
            qr_img: "",
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
            if (tab.name == "first") {
                this.activityName = "活动添加";
                this.name = "";
                this.button_name = "";
                this.integral = "";
                this.url = "";
                this.activityTime = [];
                this.wheel_img = "";
                this.defaultBannerState = false;
                this.defaultQianDaoState = false;
                this.qianDao_img = "";
            }
        },

        // 活动list
        activity_list(page = 1, paginate = interfaceApi.pageSize, name = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.name = name;
            interfaceApi.activity_list(data, (res) => {
                console.log(res, "==activity_list==");
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            })
        },

        editor() {
            var id = this.editorid;
            var name = this.name;
            var button_name = this.button_name;
            var integral = this.integral;
            var url = "";
            var img = this.wheel_img;
            var start = this.startTime;
            var end = this.endTime;
            var img_bg = this.qianDao_img;
            this.openFullScreen();
            this.activity_up(id, name, button_name, integral, url, img, start, end, img_bg);
        },

        // 活动修改
        activity_up(id, name, button_name, integral, url, img, start, end, img_bg) {
            var data = {};
            data.id = id;
            data.name = name;
            data.button_name = button_name;
            data.integral = integral;
            data.url = url;
            data.img = img;
            data.start = start;
            data.end = end;
            data.img_bg = img_bg;
            interfaceApi.activity_up(data, (res) => {
                console.log(res, "==activity_up==")
                loading.close();
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.activeName = "first";
                    this.activity_list();
                } else if (res.code == 215) {
                    this.$message.error(res.data);
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        handleEditor(index, row) {
            this.editorid = row;
            this.activityName = "活动编辑"
            this.activity_deta(row);
        },

        // 活动详情
        activity_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.activity_deta(data, (res) => {
                console.log(res, "===activity_deta===")
                if (res.code == 200) {
                    this.activeName = "second";
                    this.name = res.data.name;
                    this.button_name = res.data.button_name;
                    this.integral = res.data.integral;
                    this.url = res.data.url;
                    if (res.data.img != "") {
                        this.defaultBannerState = true;
                        this.wheel_img = res.data.img;
                    }
                    this.activityTime = [];
                    this.activityTime.push(res.data.start);
                    this.activityTime.push(res.data.end);
                    this.startTime = res.data.start;
                    this.endTime = res.data.end;
                    this.qr_img = res.data.qr_img;
                    this.qianDao_img = res.data.img_bg;
                    this.defaultQianDaoState = true;

                }
            })
        },

        // 查看签到list
        handleLook(index, row) {
            console.log(row);
            this.useractivity_list(1, interfaceApi.pageSize, "", row)
        },

        // 活动签到管理
        useractivity_list(page = 1, paginate = interfaceApi.pageSize, name = "", a_id = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.name = name;
            data.a_id = a_id;
            interfaceApi.useractivity_list(data, res => {
                console.log(res, "==useractivity_list==");
                if (res.code == 200) {
                    this.dialogTableVisible = true;
                    this.gridData = res.data.data;
                }
            });
        },
        currentChange(e) {
            this.pagination = e;
            this.activity_list(e);
        },

        search(e) {
            this.activity_list(1, interfaceApi.pageSize, e);
        },

        handleAvatarSuccess(response, res, file) {
            console.log(response, "==response");
            loading.close();
            if (response.code == 200) {
                this.wheel_img = response.data.path;
                this.defaultBannerState = true;
            }
        },

        handleAvatarSuccess2(response, res, file) {
            console.log(response, "==response");
            loading.close();
            if (response.code == 200) {
                this.qianDao_img = response.data.path;
                this.defaultQianDaoState = true;
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

        getDate(e) {
            console.log(e, "==e===");
            this.startTime = e[0];
            this.endTime = e[1];
        },

        save() {
            var name = this.name;
            var button_name = this.button_name;
            var integral = this.integral;
            var url = "";
            var img = this.wheel_img;
            var startTime = this.startTime;
            var endTime = this.endTime;
            var img_bg = this.qianDao_img;
            this.openFullScreen();
            this.activity_add(name, button_name, integral, integral, img, startTime, endTime, img_bg);
        },

        // 活动添加
        activity_add(name, button_name, integral, url, img, start, end, img_bg) {
            var data = {};
            data.name = name;
            data.button_name = button_name;
            data.integral = integral;
            data.url = url;
            data.img = img;
            data.start = start;
            data.end = end;
            data.img_bg = img_bg;
            interfaceApi.activity_add(data, res => {
                console.log(res, "==activity_add===");
                loading.close();
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.activeName = "first";
                    this.activity_list();
                } else if (res.code == 215) {
                    this.$message.error(res.data);
                } else {
                    this.$message.error(res.msg);
                }

            });
        },

        export_list() {
            this.dialogFormVisible = true;
        },

        //导出列表
        useractivity_excel(page = 1, time) {
            var data = {};
            data.page = 1;
            data.paginate = 100;
            data.time = time;
            interfaceApi.useractivity_excel(data, (res) => {
                console.log(res, "==useractivity_excel===");
                   if(res.code == 200){
                      window.location.href = res.data.url
                }else{
                    this.$message.error(res.msg);
                }
            })
        },

        downLoadExcel() {
           var timeRange = this.timeRange;
            this.useractivity_excel(1, timeRange);
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.activity_list();
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

<style scoped>
.upload-demo1 .el-button {
    width: 202px;
    height: 51px;
    background: #233f68;
    border-radius: 30px;
    color: #fff;
    letter-spacing: 4px;
    font-size: 16px;
    margin-top: 42px;
}

.main .el-input__inner,
.main .el-select:hover .el-input__inner,
.main .el-select .el-input__inner:focus,
.main .el-select:hover .el-input__inner,
.main .el-select .el-input__inner:focus,
.main .el-select .el-input.is-focus .el-input__inner {
    border-color: #233f68;
    border-radius: 0;
}
</style><style lang="less" scoped>
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
        padding-bottom: 20px;

        .add {
            width: 150px;
            height: 40px;
            font-size: 16px;
            text-align: center;
            line-height: 40px;
            background: #233f68;
            border-radius: 30px;
            color: #fff;
            letter-spacing: 4px;
            // margin-left: 46px;
            margin: 20px 46px;
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
                    font-weight: bold;
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
                    width: 350px;
                    height: 175px;
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
                float: right;
            }

            .scopeLink>div {
                border-bottom: 1px solid #666666;
            }
        }
    }

    .scopeLink>div {
        cursor: pointer;
    }
}
</style>
