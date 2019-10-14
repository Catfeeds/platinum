<!--  -->
<template>
<div class>
    <div class="main">
        <!-- <h2 class="title">菜单 - 默认页面</h2>-->
        <div class="content">
            <h2 class="title">会员积分明细</h2>
            <div class="contentPanel">
                <div class="tabTop flex flex-middle flex-between">
                    <div class="leftBtn">
                        <el-button type="primary" round class="baseBtn">导出完整列表</el-button>
                        <el-button type="primary" round class="baseBtn" @click="back()">返回</el-button>
                        <span class="vipname">会员昵称:{{vipName}}</span>
                        <el-date-picker v-model="value1" class="dateTime" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" @change="getDate">
                        </el-date-picker>
                        <el-select v-model="value" placeholder="请选择事件" clearable class="stateSelect" @change="getEvent">
                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                        </el-select>
                    </div>
                    <div class="rightBtn">
                        <!-- <el-input v-model="searchInput" placeholder="请输入事件" prefix-icon="el-icon-search" class="searchInput" @change="searchUser"></!-->
                        <!-- <el-select v-model="value" placeholder="请选择事件" clearable class="stateSelect" @change="getEvent">
                            <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
                        </el-select> -->
                        <!-- <el-button type="primary" round class="baseBtn">搜索</el-button> -->
                    </div>
                </div>
                <div class="tabInfo">
                    <el-table :data="tableData" border style="width: 100%">
                        <el-table-column prop="id" label="ID" width="80"></el-table-column>
                        <el-table-column prop="event" label="积分方式"></el-table-column>
                        <el-table-column prop="num" label="积分分值"></el-table-column>
                        <el-table-column prop="created_at" label="积分获取时间"></el-table-column>
                        <!-- <el-table-column prop="updated_at" label="积分到期时间"></el-table-column> -->
                    </el-table>
                </div>
            </div>
        </div>
         <!-- 分页 -->
      <el-pagination background layout="prev, pager, next" :total="total" :page-size="pageSize"
                     class="paginationStyle" @current-change="currentChange"></el-pagination>
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
            searchInput: "",
            activeName: "first",
            value1: "",
            options: [],
            value: "",
            tableData: [],
            vipName:"",
            u_id : "",
            total:0,
            pageSize:6,
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

        // 用户积分明细
        member_int_list(u_id,page = 1,paginate = 6,time = "",event=""){
            var data = {};
            data.u_id = u_id;
            data.page = page;
            data.paginate = paginate;
            data.time = time;
            data.event = event;
            interfaceApi.member_int_list(data,(res)=>{
                console.log(res,"==member_int_list===")
                if(res.code == 200){
                    this.tableData = res.data.data;
                    this.total = res.data.total;
                }
            })
        },
        getDate(e){
            console.log(e,"==e===")
            this.member_int_list(this.u_id,1,6,e)
        },
        searchUser(e){
            
        },

        getEvent(e){
            console.log(e,"==e==")
             this.member_int_list(this.u_id,"","","",e)
        },
        
        currentChange(e){
            this.member_int_list(this.u_id,e)
        },

        // 积分事件list
        member_event_list(){
            var data = {};
            interfaceApi.member_event_list(data,(res)=>{
                if(res.code == 200){
                  
                    var options = res.data;
                    var arr = [];
                    for(var i in options){
                        var obj = {};
                        obj.value = i;
                        obj.label = options[i];
                        arr.push(obj);
                    }

                    this.options = arr;
                }
            })
        },

        // 返回
        back(){
            this.$router.push("/vipPointsManagement");
        }

    },
    //生命周期 - 创建完成（可以访问当前this实例）
    created() {
        this.u_id = this.$route.query.id;
        this.vipName =  this.$route.query.name;
        // console.log(name,"==name==")
        // console.log(id,"===id==")
        this.member_int_list(this.u_id);
        this.member_event_list();
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
        height: 92%;
        margin-left: 40px;
        margin-top: 40px;
        background: #fff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;

        .tabTop {
            padding: 20px 0;
        }

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
        }

        .el-table .cell img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .contentPanel {
            margin-top: 50px;
            padding: 20px;

            .searchInput {
                width: 200px;
            }

        }
    }
}

.rightBtn .baseBtn {
    margin-left: 20px;
}

.leftBtn .vipname {
    margin-left: 20px;
}

.leftBtn .dateTime {
    margin-left: 20px;
}
</style>
