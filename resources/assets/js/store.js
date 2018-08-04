import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
//Root Vuex ใช้ state : status สำหรับตรวจสอบว่าจำเป็นต้อง Refresh Parent หรือ ไม่
export const store = new Vuex.Store({
    state: {
        status: false,
        vuePageHiddenStatus:true,
        user:''
    },
    getters: {
        refreshParentStatus(state) {
            return state.status;
        },
        vuePageStatus(state){
            return state.vuePageHiddenStatus
        },
        //User
        getUser(state){
            return state.user;
        }
    },
    mutations: {
        notRefreshParent(state) {
            state.status = false
        },
        refreshParent(state) {
            state.status = true;
        },
        //Page
        vuePageHidden(state){
            state.vuePageHiddenStatus =true;
        },
        vuePageShow(state){
            state.vuePageHiddenStatus=false;
        },
        //User
        setUser(state,payload){
            console.log('Set User Payload :',payload);
            state.user = payload
        }

    },
    actions:{
        vuePageShow({commit}){
            commit('vuePageShow')
        }
    },
    //Modules สำหรับจัดหมวดหมู่แยกประเภท vuex
    modules: {
        //external vuex modules
    }
});
