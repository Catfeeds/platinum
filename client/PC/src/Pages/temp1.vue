<!--  -->
<template>
<div class>
    <div class="main">
        <h2 class="title">品牌商品管理</h2>
        <div class="content">
            111
        </div>
    </div>

</div>
</template>

<script>
//这里可以导入其他文件（比如：组件，工具js，第三方插件js，json文件，图片文件等等）
//例如：import 《组件名称》 from '《组件路径》';
import {
    interfaceApi
} from "../utils/interfaceAPI";
var loading;
export default {
    //import引入的组件需要注入到对象中才能使用
    components: {},
    data() {
        //这里存放数据
        return {
            isUseIndex: "",
            is_shelf_index: "",
            isSort: "",
            options: [{
                value: 1,
                label: '是'
            }, {
                value: 0,
                label: '否'
            }],
            optionsProducts: [{
                value: 1,
                label: "上架"
            }, {
                value: 0,
                label: "下架"
            }],
            optionsSort: [{
                value: 1,
                label: 1
            }, {
                value: 2,
                label: 2
            }, {
                value: 3,
                label: 3
            }, ],
            dialogTableVisible: false,
            dialogFormVisible: false,
            form: {},
            formLabelWidth: "150px",
            tableData: [],
            coverImageUrl: "",
            coverImageUrlState: true,
            bannerImageUrl: "",
            bannerImageUrlState: true,
            img_upload: interfaceApi.img_upload,
            file_upload: interfaceApi.file_upload,
            total: 0
        };
    },
    //监听属性 类似于data概念
    computed: {},
    //监控data中的数据变化
    watch: {},
    //方法集合
    methods: {
        
    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
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
        text-align: left;
        display: block;
        margin-top: 60px;
        margin-left: 100px;
        font-size: 30px;
    }

    .manageView {
        width: 121px;
        height: 50px;
    }

    .content {
        width: auto;
        height: 92%;
        margin-left: 40px;
        background: #fff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        overflow-y: auto;

        .funList {
            width: calc(100% - 72px);
            height: 44px;
            margin: 38px 36px 0;
            display: flex;
            align-items: center;

            .add {
                width: 224px;
                height: 45px;
                font-size: 16px;
                text-align: center;
                line-height: 45px;
                background: #3cb9b7;
                border-radius: 10px;
                color: #fff;
                letter-spacing: 4px;
            }

            .sortOne {
                margin-left: 130px;
            }

            .sortTwo {
                margin-left: 50px;
            }

            .sort {
                font-size: 17px;
                font-weight: bold;
                display: flex;
                align-items: center;

                .timer {
                    width: auto;
                    height: auto;
                    margin-left: 15px;
                }

                .search {
                    margin-left: 50px;
                }
            }
        }

        .form {
            width: calc(100% - 72px);
            height: auto;
            margin-top: 36px;
            margin-left: 36px;

            .imgShow {
                width: auto;
                height: 50px;
            }

            .imgShow>img {
                height: 100%;
                object-fit: contain;
            }
        }
    }
}
</style><style scoped>
.el-form-item__content {
    display: flex;
}

.use {
    background: #3cb9b7;
    color: #fff;
    padding: 4px 36px;
    font-size: 13px;
    border-radius: 4px;
}

.noUse {
    background: #fff;
    color: #3cb9b7;
    padding: 4px 36px;
    font-size: 13px;
    border-radius: 4px;
}

.alert .el-select {
    width: 385px;
}

.alert .el-form-item__content {
    display: flex;
}

.el-input__inner::-webkit-input-placeholder {
    text-align: center;
}

.el-table th>.cell {
    text-align: center;
    width: 100%;
}

.el-table td,
.el-table th.is-leaf {
    border-right: 1px solid #fff;
}

.el-table__body-wrapper .el-table th,
.el-table__body-wrapper .el-table tr {
    background: #ededed;
}

.el-table .success-row {
    background: #ededed;
}

.success-row .cell {
    color: #000;
}

.alert .el-input {
    display: block !important;
}

.el-button--primary {
    border: #3cb8b6;
    background: #3cb8b6;
}

.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.avatar-uploader .el-upload:hover {
    border-color: #409eff;
}

.avatar-uploader .el-upload>img {
    width: 180px;
    height: 180px;
    object-fit: contain;
}

.avatar-uploader .el-upload>video {
    width: 180px;
    height: 180px;
}

.avatar-uploader .el-upload {
    display: flex;
    align-items: center;
}

.avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
}

.avatar {
    width: 178px;
    height: 178px;
    display: block;
}

.avatar-uploader {
    display: flex;
    justify-content: end;
}
</style>
