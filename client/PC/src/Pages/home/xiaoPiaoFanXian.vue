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
                            <el-button type="primary" round class="baseBtn" @click="add()">新增返现券</el-button>
                        </div>

                        <div class="tabInfo">
                            <el-table :data="tableData" border style="width: 100%">
                                <el-table-column label="ID" width="80">
                                    <template slot-scope="scope">
                                        {{(scope.$index + 1) + (pagination - 1) * 6}}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="name" label="返现券名称"></el-table-column>
                                <el-table-column prop="money" label="金额"></el-table-column>
                                <el-table-column prop="stock" label="库存"></el-table-column>
                                <el-table-column prop="probability" label="概率">
                                    <template slot-scope="scope">
                                        {{scope.row.probability}}%
                                    </template>
                                </el-table-column>
                                <el-table-column prop="state" label="状态">
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.state == 1">启用</div>
                                        <div v-if="scope.row.state == 2">停用</div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop label="编辑">
                                    <template slot-scope="scope">
                                        <div class="scopeLink flex flex-middle flex-center">
                                            <el-button size="mini" @click="handleSetting(scope.$index, scope.row.id)">设置</el-button>
                                            <el-button size="mini" @click="handleDel(scope.$index, scope.row.id)">删除</el-button>
                                        </div>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <h2 class="title">小票返现管理</h2>
        </div>
        <!-- 分页 -->
        <el-pagination v-if="activeName == 'first'" background layout="prev, pager, next" :total="total" :page-size="pageSize" class="paginationStyle" @current-change="currentChange"></el-pagination>
    </div>

    <el-dialog title="新增返现券" :visible.sync="dialogFormVisible">
        <el-form :model="form">
            <el-form-item label="活动名称" :label-width="formLabelWidth">
                <el-input v-model="form.name" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>

            <el-form-item label="返现券金额" :label-width="formLabelWidth">
                <el-input v-model="form.money" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>

            <el-form-item label="返现券总库存" :label-width="formLabelWidth">
                <el-input v-model="form.stock" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>

            <el-form-item label="概率" :label-width="formLabelWidth">
                <el-input v-model="form.probability" autocomplete="off" style="width:50%;display:flex"></el-input>
            </el-form-item>

            <el-form-item label="状态" :label-width="formLabelWidth">
                <el-select v-model="form.state" placeholder="请选择" style="width:50%;display:flex" @change="changeState">
                    <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
        </el-form>

        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary" @click="submitAdd()">确 定</el-button>
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
                    label: "启用"
                },
                {
                    value: "2",
                    label: "停用"
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
            img_upload: interfaceApi.img_upload,
            isQiYongHuDongIndex: "",
            button_text: "",
            msg_text: "",
            huDongUrl: "",
            defaultBannerState: false,
            wheel_img: "",
            dialogFormVisible: false,
            form: {
                name: '',
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: ''
            },
            formLabelWidth: '120px',
            clickType: null,
            uploadIndex: "",
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

        handleSeePhoto(index, row) {},

        handleImgClose(done) {
            this.$confirm("确认关闭？")
                .then(_ => {
                    done();
                })
                .catch(_ => {});
        },

        currentChange(e) {
            this.pagination = e;
            this.withdrawal_list(e);
        },

        withdrawal_list(page = 1, paginate = interfaceApi.pageSize, name = "") {
            var data = {};
            data.page = page;
            data.paginate = paginate;
            data.name = name;

            interfaceApi.withdrawal_list(data, res => {
                console.log(res);
                if (res.code == 200) {
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            });
        },

        // 删除
        handleDel(index, row) {
            this.delTip(row);
        },

        // 返回券删除
        withdrawal_de(id) {
            this.openFullScreen();
            var data = {};
            data.id = id;
            interfaceApi.withdrawal_de(data, res => {
                console.log(res, "==res==");
                loading.close();
                if (res.code == 200) {
                    this.$message({
                        type: "success",
                        message: "删除成功!"
                    });

                    this.withdrawal_list();
                } else {
                    this.$message.error(res.msg);
                }
            });
        },

        // 删除提示
        delTip(row) {
            this.$confirm("此操作将永久删除该信息, 是否继续?", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                })
                .then(() => {
                    this.withdrawal_de(row);
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: "已取消删除"
                    });
                });
        },

        openFullScreen() {
            loading = this.$loading({
                lock: true,
                text: "加载中",
                spinner: "el-icon-loading",
                background: "rgba(0, 0, 0, 0.7)"
            });
        },

        // 新增
        add() {
            this.dialogFormVisible = true;
            this.clickType = "newAdd"
            this.form = {};
        },
        // 返现券添加
        withdrawal_add() {
            var data = {};
            data = this.form;
            interfaceApi.withdrawal_add(data, (res) => {
                console.log(res, "==res===")
                loading.close();
                if (res.code == 200) {
                    this.dialogFormVisible = false;
                    this.$message({
                        message: '添加成功',
                        type: 'success'
                    });

                    this.withdrawal_list();
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        // 设置
        handleSetting(index, row) {
            this.dialogFormVisible = true;
            this.uploadIndex = row;
            this.clickType = "upload";
            this.withdrawal_deta(row);
        },

        // 返现券详情
        withdrawal_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.withdrawal_deta(data, (res) => {
                console.log(res, "==res===")
                if (res.code == 200) {
                    this.form = res.data;
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        changeState(e) {
            console.log(e)
            this.form.state = e;
        },

        submitAdd() {
            this.openFullScreen();
            if (this.clickType == "newAdd") {
                this.withdrawal_add();
            } else {
                this.withdrawal_up();
            }
        },

        // 返现券修改
        withdrawal_up() {
            var data = {};
            data = this.form;
            interfaceApi.withdrawal_up(data, (res) => {
                console.log(res, "===res==")
                loading.close();
                if (res.code == 200) {
                    this.dialogFormVisible = false;
                    this.$message({
                        message: '修改成功',
                        type: 'success'
                    });
                    this.withdrawal_list();
                } else {
                    this.$message.error(res.msg);
                }
            })
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.withdrawal_list();
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
    height: auto;

    .xiaoPiaoImgInfo {
        width: 100%;
        height: 200px;
        object-fit: fill;
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
