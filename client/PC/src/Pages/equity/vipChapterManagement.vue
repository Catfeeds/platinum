<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">会员章程管理</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn" @click="save()">保存</el-button>
                    </div>
                </div>
                <div class="tabContent">
                    <!-- <quill-editor v-model="content" ref="myQuillEditor" :options="editorOption" @blur="onEditorBlur($event)" @focus="onEditorFocus($event)" @change="onEditorChange($event)">
                    </quill-editor> -->
                    <editor ref="myTextEditor" :fileName="'myFile'" :canCrop="canCrop" :uploadUrl="uploadUrl" v-model="content"></editor>
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
    quillEditor
} from "vue-quill-editor"; //调用编辑器

import {
    interfaceApi
} from "@/utils/interfaceAPI";

import editor from "@/Pages/editor/Quilleditor.vue";

var loading;
export default {
    //import引入的组件需要注入到对象中才能使用
    components: {
        quillEditor,
        editor
    },
    data() {
        //这里存放数据
        return {
             canCrop: false,
            content: ``,
            editorOption: {},
            uploadUrl:interfaceApi.img_upload
        };
    },
    //监听属性 类似于data概念
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill;
        },
    },
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

        onEditorReady(editor) { // 准备编辑器

        },
        onEditorBlur() {}, // 失去焦点事件
        onEditorFocus() {}, // 获得焦点事件
        onEditorChange(e) {
            // console.log(e,"====e===")
        }, // 内容改变事件

          openFullScreen() {
            loading = this.$loading({
                lock: true,
                text: '加载中',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },

        save(){
            this.openFullScreen();
            this.constitution_up();
        },


        // 会员章程管理
        constitution_up(){
            var data = {};
            data.data = this.content;
            interfaceApi.constitution_up(data,(res)=>{
                loading.close();
                if(res.code == 200){
                    this.$message({
                        message: '保存成功',
                        type: 'success'
                    });
                }
            })
        },

        // 会员章程list
        constitution_list(){
            var data = {};
            interfaceApi.constitution_list(data,(res)=>{
                console.log(res,"==constitution_list==")
                if(res.code == 200){
                    this.content = res.data;
                }
            })
        }
        
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.constitution_list();
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
