<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">会员权益管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn" @click="save()">保存</el-button>
                    </div>
                </div>
                <div class="tabContent">
                    <div class="tc">
                        <div class="imgBorder">
                            <img :src="tableData[2].logo" alt v-if="tableData!=''"/>
                        </div>
                        <div class="info">VIP会员权益图片</div>
                        <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess2" :on-progress="openFullScreen">
                            <el-button class="elButton">上传</el-button>
                        </el-upload>
                    </div>
                    <div class="tc">
                        <div class="imgBorder">
                            <img :src="tableData[1].logo" alt  v-if="tableData!=''" />
                        </div>
                        <div class="info">高级会员权益图片</div>
                        <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess1" :on-progress="openFullScreen">
                            <el-button class="elButton">上传</el-button>
                        </el-upload>
                    </div>
                    <div class="tc">
                        <div class="imgBorder">
                            <img :src="tableData[0].logo" alt v-if="tableData!=''" />
                        </div>
                        <div class="info">普通会员权益图片</div>
                        <el-upload class="upload-demo1" :action="img_upload" :show-file-list="false" :on-success="handleAvatarSuccess0" :on-progress="openFullScreen">
                            <el-button class="elButton">上传</el-button>
                        </el-upload>
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
            input: "",
            activeName: "first",
            options: [{
                    value: "选项1",
                    label: "会员昵称"
                },
                {
                    value: "选项2",
                    label: "收货姓名"
                },
                {
                    value: "选项3",
                    label: "收货手机"
                },
                {
                    value: "选项4",
                    label: "收货地区"
                },
                {
                    value: "选项5",
                    label: "收货地址"
                }
            ],
            value: "",
            tableData: [],
            puTongVipImg: "",
            img_upload: interfaceApi.img_upload
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

        user_equity_list() {
            var data = {};
            interfaceApi.user_equity_list(data, res => {
                console.log(res, "==res==");
                if (res.code == 200) {
                    this.tableData = res.data;
                }
            });
        },

        handleAvatarSuccess0(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.tableData[0].logo = response.data.path;
            }
        },

        handleAvatarSuccess1(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.tableData[1].logo = response.data.path;
            }
        },

        handleAvatarSuccess2(response, res, file) {
            console.log(response, "==response")
            loading.close();
            if (response.code == 200) {
                this.tableData[2].logo = response.data.path;
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

        // 会员权益修改
        user_equity_up(){
            var data = {};
            data.data = this.tableData;
            interfaceApi.user_equity_up(data,(res)=>{
                console.log(res,"==res==")
                loading.close();
                if(res.code == 200){
                    this.$message({
                        message: '修改成功',
                        type: 'success'
                    });
                }
            })
        },

        save(){
            this.openFullScreen();
            this.user_equity_up();
        }
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.user_equity_list();
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
        margin-left: 40px;
        margin-top: 40px;
        background: #fff;
        display: flex;
        flex-direction: column;
        position: relative;

        .tabTop {
            padding: 20px 0;
        }

        .contentPanel {
            margin-top: 50px;
            padding: 20px;

            .baseBtn {
                letter-spacing: 4px;
            }

            .searchInput {
                width: 200px;
            }

            .tabContent {
                width: 1142px;
                height: auto;
                display: flex;
                margin-left: 100px;
                justify-content: space-between;

                .tc {
                    width: 300px;
                    height: 100%;
                    display: flex;
                    flex-direction: column;

                    .imgBorder {
                        height: 400px;
                        border: 1px solid #666666;
                        display: flex;
                        align-items: center;
                        justify-content: center;

                        img {
                            width: 100%;
                            height: 100%;
                            object-fit: contain;
                        }
                    }

                    .info {
                        color: #666;
                        font-size: 18px;
                        margin-top: 80px;
                    }
                }
            }
        }
    }
}
</style><style scoped>
.upload-demo1 .elButton {
    width: 202px;
    height: 50px;
    color: #fff;
    background: #233f68;
    font-weight: bold;
    letter-spacing: 4px;
    border-radius: 30px;
    margin-top: 30px;
}
</style>
