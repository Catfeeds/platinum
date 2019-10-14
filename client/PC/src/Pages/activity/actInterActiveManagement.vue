<template>
<div class>
    <div class="main">
        <div class="content">
            <h2 class="title">线上互动管理</h2>
            <div class="add" @click="save()">保存</div>
            <div class="form">
                <div class="formLeft">
                    <!-- 互动名称 -->
                    <div class="formContent">
                        <div class="name">互动名称</div>
                        <div class="input">
                            <el-input v-model="name" placeholder="请输入内容"></el-input>
                        </div>
                    </div>

                    <!-- 互动链接 -->
                    <!-- <div class="formContent">
                        <div class="name">互动链接</div>
                        <div class="input">
                            <el-input v-model="url" placeholder="请输入内容"></el-input>
                        </div>
                    </div> -->

                    <!-- 是否添加积分 -->
                    <div class="formContent">
                        <div class="name">是否添加积分</div>
                        <div class="input">
                            <el-select v-model="sortIndex" placeholder="请选择" @change="isAddIntergal">
                                <el-option v-for="item in optionsSort" :key="item.value" :label="item.label" :value="item.value"></el-option>
                            </el-select>
                        </div>
                    </div>

                    <!-- 增加积分分值 -->
                    <div class="formContent">
                        <div class="name">增加积分分值</div>
                        <div class="input">
                            <el-input v-model="integral" placeholder="请输入内容"></el-input>
                        </div>
                    </div>

                    <!-- 完成后跳转内链 -->
                    <!-- <div class="formContent">
                        <div class="name">完成后跳转内链</div>
                        <div class="input">
                            <el-input v-model="complete_url" placeholder="请输入内容"></el-input>
                        </div>
                    </div> -->

                    <!-- 上传视频 -->
                    <div class="formContent">
                        <div class="name">首页展示视频上传</div>
                        <!-- 图片显示 -->
                        <div class="bannerInfoBigImg">
                            <div class="bannerInfoBigImgShow">
                                <div class="defaultCoverState">
                                    <video :src="videoUrl" class="avatar" />
                                </div>
                               
                            </div>
                            <el-upload class="upload-demo1" :action="file_upload" :show-file-list="false" :on-success="handleAvatarSuccess2" :on-progress="openFullScreen">
                                <el-button>上传</el-button>
                            </el-upload>
                        </div>
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

                </div>
            </div>
        </div>
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
            bannerImageUrlState: true,
            defaultCoverState: false, //上传默认
            defaultBannerState: false,
            name: "",
            url: "",
            sortIndex: "",
            optionsSort: [{
                    value: "1",
                    label: "是"
                },
                {
                    value: "2",
                    label: "否"
                }
            ],
            is_shelf_index: "",
            img_upload: interfaceApi.img_upload,
            file_upload:interfaceApi.file_upload,
            wheel_img: "",
            complete_url: "",
            integral: "",
            videoUrl:"",
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        // 线上互动详情
        get_online() {
            var data = {};
            interfaceApi.get_online(data, (res) => {
                console.log(res, "==res==")
                if (res.code == 200) {
                    if (res.data.img != "") {
                        this.defaultBannerState = true;
                    }
                    this.name = res.data.name;
                    this.wheel_img = res.data.img;
                    this.videoUrl = res.data.url;
                    this.integral = res.data.integral;
                    this.sortIndex = res.data.is;
                    this.complete_url = res.data.complete_url;
                }
            })
        },

        handleAvatarSuccess(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.wheel_img = response.data.path;
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

        isAddIntergal(e) {
            console.log(e, "==e==")
            this.sortIndex = e;
        },
        save() {
            var name = this.name;
            var url = this.videoUrl;
            var sortIndex = this.sortIndex;
            var integral = this.integral;
            var complete_url = "";
            var img = this.wheel_img;
            this.openFullScreen();
            this.online(name, url, sortIndex, integral, img, complete_url);
        },

        // 上传视频
        handleAvatarSuccess2(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.videoUrl = response.data.path;
            }
        },

        // 线上互动修改
        online(name, url, is, integral, img, complete_url) {
            var data = {};
            data.name = name;
            data.url = url;
            data.is = is;
            data.integral = integral;
            data.img = img;
            data.complete_url = complete_url;
            interfaceApi.online(data, (res) => {
                loading.close();
                console.log(res, "==res==")
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                }else{
                     this.$message.error(res.msg);
                }
            })
        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.get_online();
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
                height: 100px;
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
    }
}
</style>
