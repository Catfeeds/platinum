<template>
<div class>
    <div class="main">
        <div class="content">
            <h2 class="title">AR返现管理</h2>
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
                   <!-- 品牌商品详情大图 -->
                    <div class="formContent" style="margin-bottom:10px;">
                        <div class="name">首页展示图片上传</div>
                    </div>
                    <div class="formContent">
                        <div></div>
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
            defaultBannerState: false,
            name: "",
            img_upload: interfaceApi.img_upload,
            wheel_img: ""
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        // AR返现详情
        get_ar_data(){
            var data = {};
            interfaceApi.get_ar_data(data,(res)=>{
                console.log(res,"==res==")
                if(res.code == 200){
                    if(res.data.img !=""){
                        this.defaultBannerState = true;
                    }
                    this.name = res.data.name;
                    this.wheel_img = res.data.img;

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

        save(){
            var name = this.name;
            var img =this.wheel_img;
            this.openFullScreen();
            this.ar_data(name,img);
        },

        // AR返现修改
        ar_data(name,img){
            var data = {};
            data.name = name;
            data.img = img;
            interfaceApi.ar_data(data,(res)=>{
                 console.log(res, "==res==")
                 loading.close();
                if (res.code == 200) {
                    this.$message({
                        message: res.msg,
                        type: 'success'
                    });
                    this.get_ar_data();
                }else{
                     this.$message.error(res.msg);
                }
            })
        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.get_ar_data();
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

<style>
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
        height: 92%;
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
                    width: 350px;;
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
