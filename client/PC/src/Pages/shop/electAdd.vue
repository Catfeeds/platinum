<template>
<div class>
    <div class="main">
        <div class="content">
            <h2 class="title" v-if="saveType=='添加'">电子券管理-添加</h2>
            <h2 class="title" v-if="saveType=='编辑'">电子券管理-编辑</h2>
            <div class="headerMenu">
                <div class="add" v-if="saveType=='添加'" @click="save()">保存</div>
                <div class="add" v-if="saveType=='编辑'" @click="editor()">保存</div>
                <div class="add" @click="back()">返回</div>
            </div>
            <div class="form">
                <div class="formLeft">
                    <!-- 电子券全称 -->
                    <div class="formContent">
                        <div class="name">电子券全称</div>
                        <div class="input">
                            <el-input v-model="full_name" placeholder="请输入内容"></el-input>
                        </div>
                    </div>

                    <!-- 电子券简称 -->
                    <div class="formContent">
                        <div class="name">电子券简称</div>
                        <div class="input">
                            <el-input v-model="name" placeholder="请输入内容"></el-input>
                        </div>
                    </div>

                    <!-- 电子券详情 -->
                    <div class="formContent">
                        <div class="name">电子券详情</div>
                        <div class="input">
                            <el-input v-model="text" type="textarea" placeholder="请输入内容"></el-input>
                        </div>
                    </div>

                    <!-- 所需积分 -->
                    <div class="formContent">
                        <div class="name">所需积分</div>
                        <div class="input">
                            <el-input v-model="integral" placeholder="请输入内容" type="number"></el-input>
                        </div>
                    </div>

                    <!-- 电子券库存 -->
                    <div class="formContent">
                        <div class="name">电子券库存</div>
                        <div class="input">
                            <el-input v-model="stock" placeholder="请输入内容" type="number"></el-input>
                        </div>
                    </div>

                    <!-- 页面位置 -->
                    <div class="formContent">
                        <div class="name">页面位置</div>
                        <div class="input">
                            <!-- <el-select v-model="sortIndex" placeholder="请选择" @change="sortBtn">
                                <el-option v-for="item in optionsSort" :key="item.value" :label="item.label" :value="item.value"></el-option>
                            </el-select> -->
                            <el-input v-model="sortIndex" placeholder="请输入内容" type="number"></el-input>
                        </div>
                    </div>

                    <div class="formContent">
                        <div class="name">分类</div>
                        <div class="input">
                            <el-select v-model="classicIndex" placeholder="请选择" @change="classicBtn">
                                <el-option v-for="item in classicType" :key="item.value" :label="item.label" :value="item.value"></el-option>
                            </el-select>
                        </div>
                    </div>

                    <!-- <div class="formContent">
                        <div class="name">是否上架</div>
                        <div class="input">
                            <el-select v-model="is_shelf_index" placeholder="请选择" @change="is_shelf_btn">
                                <el-option v-for="item in is_shelf_options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                            </el-select>
                        </div>
                    </div> -->

                    <div class="formContent">
                        <div class="name">兑换时间</div>
                        <div class="input">
                            <el-date-picker style="border-radius:30px;" v-model="time" type="datetimerange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" clearable @change="duihuanDate">
                            </el-date-picker>
                        </div>
                    </div>

                </div>
                <div class="formRight">
                    <!-- 详情大图 -->
                    <div class="formContent">
                        <div class="name">详情大图</div>
                        <!-- 图片显示 -->
                        <div class="bannerInfoBigImg">

                            <div class="bannerInfoBigImgShow" v-if="imgsList.length == 0">
                                <span class="bannerInfoBigImgShowTip">图片</span>
                                <span class="bannerInfoBigImgShowTip">750pt x 350pt</span>
                            </div>

                            <div class="bannerInfoBigImgShow" v-for="(item,index) in imgsList" :key="index">
                                <div class="defaultCoverState">
                                    <img class="avatar" :src="item" />
                                    <div class="delInfo" @click="delInfoBtn(index)">X</div>
                                </div>
                            </div>
                            <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess" :on-progress="openFullScreen">
                                <el-button style="margin-left:150px;">上传</el-button>
                            </el-upload>
                        </div>
                    </div>

                    <!-- 外层小图 -->
                    <div class="formContent">
                        <div class="name">外层小图</div>
                        <!-- 图片显示 -->
                        <div class="bannerInfoBigImg">
                            <div class="bannerInfoBigImgShow">
                                <div class="defaultCoverState" v-if="defaultBannerState">
                                    <img :src="wheel_img" class="avatar" />
                                </div>

                                <div v-else>
                                    <span class="bannerInfoBigImgShowTip">图片</span>
                                    <span class="bannerInfoBigImgShowTip">750pt x 750pt</span>
                                </div>
                            </div>
                            <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess2" :on-progress="openFullScreen">
                                <el-button style="margin-left:150px;">上传</el-button>
                            </el-upload>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    interfaceApi
} from '../../utils/interfaceAPI';
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';

var loading;
export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            defaultCoverState: false, //上传默认
            defaultBannerState: false,
            sortIndex: "",
            optionsSort: [{
                    value: "1",
                    label: "升序"
                },
                {
                    value: "2",
                    label: "降序"
                }
            ],
            img_upload: interfaceApi.img_upload,
            wheel_img: "",
            name: "",
            stock: "",
            integral: "",
            text: "",
            full_name: "",
            cover_img: "",
            classicType: [],
            classicIndex: "",
            is_shelf_index: "",
            is_shelf_options: [{
                    value: "1",
                    label: "下架"
                },
                {
                    value: "2",
                    label: "上架"
                }
            ],
            time: "",
            saveType: "",
            index: "",
            imgsList: []
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        sortBtn(e) {
            this.sortIndex = e;
        },

        save() {
            var full_name = this.full_name;
            var name = this.name;
            var text = this.text;
            var integral = this.integral;
            var stock = this.stock;
            var sort = this.sortIndex;
            var cover = this.wheel_img;
            var imgs = this.imgsList;
            this.voucher_add(full_name, name, text, integral, stock, sort, cover, imgs);
        },

        voucher_add(full_name, name, text, integral, stock, sort, cover, imgs) {
            var data = {};
            data.full_name = full_name;
            data.name = name;
            data.text = text;
            data.integral = integral;
            data.stock = stock;
            data.sort = sort;
            data.cover = cover;
            data.imgs = imgs;
            data.sales = 0;
            data.type = this.classicIndex;
            data.is_shelf = 2;
            data.start = this.time[0];
            data.end = this.time[1];
            interfaceApi.voucher_add(data, (res) => {
                console.log(res, "==voucher_add===")
                if (res.code == 200) {
                    this.$message({
                        showClose: true,
                        message: '添加成功',
                        type: 'success'
                    });
                    this.$router.push("/shopElect");
                } else {
                    this.$message.error(res.msg);
                }
            })

        },

        handleAvatarSuccess(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.imgsList.push(response.data.path)
                this.defaultCoverState = true;
            }else if(response.code == 215){
                 this.$message.error(response.data);
            }
        },

        handleAvatarSuccess2(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.wheel_img = response.data.path;
                this.defaultBannerState = true;
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

        // 分类list
        classs_list() {
            var data = {};
            interfaceApi.classs_list(data, (res) => {
                console.log(res, "==classs_list==")
                if (res.code == 200) {
                    var arr = [];
                    for (var i of res.data.data) {
                        var obj = {};
                        obj.label = i.name;
                        obj.value = i.id;
                        arr.push(obj);
                    }

                    this.$nextTick(() => {
                        this.classicType = arr;
                        console.log(this.classicType, "==arr==")
                    })

                }
            })
        },
        classicBtn(e) {
            console.log(e, "==e==")
            this.classicIndex = e;
        },

        is_shelf_btn(e) {
            this.is_shelf_index = e;
        },

        duihuanDate(e) {
            console.log(e)
            this.time = e;
        },

        //电子券详情
        voucher_deta(id) {
            var data = {};
            data.id = id;
            interfaceApi.voucher_deta(data, (res) => {
                console.log(res, "==voucher_deta===")
                if (res.code === 200) {
                    this.full_name = res.data.full_name;
                    this.name = res.data.name;
                    this.text = res.data.text;
                    this.integral = res.data.integral;
                    this.stock = res.data.stock;
                    this.sortIndex = res.data.sort;
                    this.classicIndex = res.data.type;
                    res.data.start = res.data.start.split(" ")[0];
                    res.data.end = res.data.end.split(" ")[0];
                    var arr = [];
                    arr[0] = res.data.start;
                    arr[1] = res.data.end;
                    this.time = arr;
                    this.imgsList = res.data.imgs;
                    this.defaultBannerState = true;
                    this.wheel_img = res.data.cover;
                }
            })
        },

        //电子券修改
        editor() {
            var full_name = this.full_name;
            var name = this.name;
            var text = this.text;
            var integral = this.integral;
            var stock = this.stock;
            var sort = this.sortIndex;
            var cover = this.wheel_img;
            var imgs = this.imgsList;
            var data = {};
            data.id = this.index;
            data.full_name = full_name;
            data.name = name;
            data.text = text;
            data.integral = integral;
            data.stock = stock;
            data.sort = sort;
            data.cover = cover;
            data.imgs = imgs;
            data.sales = 0;
            data.type = this.classicIndex;
            data.is_shelf = 2;
            data.start = this.time[0];
            data.end = this.time[1];
            interfaceApi.voucher_up(data, (res) => {
                console.log(res,"==voucher_up");
                if (res.code == 200) {
                    this.$message({
                        showClose: true,
                        message: '保存成功',
                        type: 'success'
                    });
                    this.back();
                } else {
                    this.$message.error(res.msg);
                }
            })
        },

        // 删除详情大图
        delInfoBtn(e) {
            console.log(e)
            this.imgsList.splice(e, 1);
        },
        back() {
            this.$router.push("/shopElect")
        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.classs_list();
        this.saveType = this.$route.query.type;
        this.index = this.$route.query.id;
        if (typeof this.index  !== "undefined") {
            this.voucher_deta(this.index);
        }
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
.headerMenu {
    display: flex;
}

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
        background: #f5f6fa
    }

    .content {
        width: 1510px;
        height: auto;
        margin-left: 40px;
        margin-top: 40px;
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
            margin-top: 86px;
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
                        height: auto;
                    }
                }
            }

            .formContent {
                width: 550px;
                height: auto;
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;

                .name {
                    font-size: 17px;
                    // font-weight: bold;
                    letter-spacing: 2px;
                    white-space: nowrap;
                    color: #737373;
                }

                .input {
                    width: 396px;
                    height: auto;
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
                    width: 300px;
                    height: 150px;
                    float: right;
                    border: 1px solid #b1b1b1;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 10px;

                    .defaultCoverState {
                        width: 100%;
                        height: 100%;
                        position: relative;

                         .delInfo{
                            width: 20px;
                            height: 20px;
                            position: absolute;
                            right: -40px;
                            top: 0px;
                            cursor: pointer;
                        }

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
</style>
