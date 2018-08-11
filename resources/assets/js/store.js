import Vue from 'vue';
import Vuex from 'vuex';
import {UserService} from "./services/user/user_service";
let userService = new UserService();
Vue.use(Vuex);
//Root Vuex ใช้ state : status สำหรับตรวจสอบว่าจำเป็นต้อง Refresh Parent หรือ ไม่
export const store = new Vuex.Store({
    state: {
        parentStatus: false,
        vuePageHiddenStatus:true,
        user:'',
        loading:false
    },
    getters: {
        refreshParentStatus(state) {
            return state.parentStatus;
        },
        vuePageStatus(state){
            return state.vuePageHiddenStatus
        },
        //User
        getUser(state){
            return state.user;
        },
        //Loading
        loadingStatus(state){
            return state.loading;
        }
    },
    mutations: {
        notRefreshParent(state) {
            state.parentStatus = false
        },
        refreshParent(state) {
            state.parentStatus = true;
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
            state.user = payload
        },
        clearUser(state){
            state.user = '';
        },
        //Loading
        loading(state){
          state.loading=true;
        },
        stopLoading(state){
            state.loading = false
        }

    },
    actions:{
        vuePageShow({commit}){
            commit('vuePageShow')
        },
        getUser(context){
            return new Promise((resolve,reject)=>{
                //get user api ถ้า use ยัง empty
                if(context.state.user === ''){
                    userService.getUser()
                        .then(result=>{
                            context.commit('setUser',result);
                            resolve(result);
                        }).catch(err=>{reject(err)})
                }else{//หากมีข้อมูล user แล้วก็ใช้ดึงจาก state มาใช้แทน
                    resolve(context.state.user);
                }
            });
        }
    },
    //Modules สำหรับจัดหมวดหมู่แยกประเภท vuex
    modules: {
        //external vuex modules
    }
});
