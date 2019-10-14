<template>
<div id="app">
    <router-view />
</div>
</template>

<script>
import store from "@/store/store.js";
export default {
    name: "App",
    mounted() {
        window.onpopstate = () => {
            if (!this.$store.state.allowBack) {
              history.go(1);
            }
        }
    }
};
</script>

<style>
* {
    box-sizing: border-box;
}

html,
body {
    height: 100%;
    font-size: 20px;
}

body {
    padding: 0;
    margin: 0;
}

.container {
    height: 100%;
}

#app {
    font-family: "微软雅黑", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    height: 100%;
    overflow: hidden;
}

/* 滚动槽 */
.scroll::-webkit-scrollbar {
    width: 0px;
    height: 0px;
}

.scroll::-webkit-scrollbar-track {
    border-radius: 3px;
    background: rgba(0, 0, 0, 0.06);
    -webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.08);
}

/* 滚动条滑块 */
.scroll::-webkit-scrollbar-thumb {
    border-radius: 3px;
    background: rgba(0, 0, 0, 0.12);
    -webkit-box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2);
}

.el-table th.gutter {
    display: table-cell !important
}

.el-select {
    width: 100%;
}

.el-textarea__inner {
    height: 154px !important;
}

.el-switch__label.is-active {
    color: #3cb9b7;
}

.pagination {
    text-align: right;
    margin-top: 60px;
    margin-bottom: 20px;
}

.el-pagination.is-background .el-pager li:not(.disabled).active {
    background: #3cb8b6;
}

.el-table td,
.el-table th.is-leaf,
.el-table .sort-caret.ascending,
.el-table .descending .sort-caret.descending,
.el-table .sort-caret.descending,
.el-table .ascending .sort-caret.ascending,
.el-table td,
.el-table th.is-leaf,
.el-table--border,
.el-table--group {
    border-color: #c9c9c9;
}

.el-table--border::after,
.el-table--group::after,
.el-table::before {
    background: none;
}

.el-table .cell {
    text-align: center;
    text-overflow: ellipsis;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.el-table th {
    background: #eaeaea;
    color: #929292;
}
</style>
