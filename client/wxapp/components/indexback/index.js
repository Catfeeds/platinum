const app = getApp();
const { API, beats, icom, config } = app;
import regeneratorRuntime from '../../common/js/plugs/regeneratorRuntime';
import promisify from '../../common/js/plugs/promisify.js';
Component({
    /**
     * 组件的属性列表
     */
    properties: {
        // 这里定义了innerText属性，属性值可以在组件使用时指定
        active: {
            type: Number,
            value: 0
        }
    },

    /**
     * 组件的初始数据
     */
    data: {

    },
    /**
     * 组件定义生命周期方法
     */
    lifetimes: {

    },
    /**
     * 组件所在页面的生命周期
     */
    pageLifetimes: {

    },
    /**
     * 组件的方法列表
     */
    methods: {
        updateData() {
            this.initData();
        },

        async initData() {
            console.log('index')
        }

    }
})