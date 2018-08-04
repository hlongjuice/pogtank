import WebUrl from '../webUrl';
import {store} from "../../store";

let webUrl = new WebUrl();
export class UserService{
    constructor() {
        this.url = webUrl.getUrl();
    }

    //User ใช้ Vuex ในการบันทึกข้อมูล User จะได้ไม่ต้อเรียกจาก database ที่ครั้งที่ขอใช้
    getUser() {
        let url = this.url + '/admin/user';
        return new Promise((resolve, reject) => {
            //หากเป็นการเรียกครั้งแรก ใช้ axios get User มาจาก Api
            if(store.getters.getUser === ''){
                axios.get(url)
                    .then(result => {
                        console.log('Get User From DB');
                        resolve(result.data);
                        //จากนั้นบันทึกลง Vuex
                        store.commit('setUser',result.data);
                    }).catch(err => {
                    reject(err)
                })
            }else{ //
                resolve(store.getters.getUser)
            }
        })
    }


}