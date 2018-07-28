import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
//Root Vuex ใช้ state : status สำหรับตรวจสอบว่าจำเป็นต้อง Refresh Parent หรือ ไม่
export const store = new Vuex.Store({
    state: {
        status: false
    },
    getters: {
        refreshParentStatus(state) {
            return state.status;
        }
    },
    mutations: {
        notRefreshParent(state) {
            state.status = false
        },
        refreshParent(state) {
            state.status = true;
        }
    },
    //Modules สำหรับจัดหมวดหมู่แยกประเภท vuex
    modules: {
        //external vuex modules
    }
});
