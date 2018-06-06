import WebUrl from '../../webUrl';
let webUrl=new WebUrl();
class Porlor5Service {
    constructor() {
        this.url = webUrl.getUrl();
        this._put_method ={
            _method:'PUT'
        }
    }
    //Get Porlor5
    getPorlor5(project_order_id){
        let url=this.url+'/admin/project_order/'+project_order_id+'/porlor_5';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Move to Previous Page
    moveToPreviousPage(project_order_id,porlor4_id){
        let url=this.url+'/admin/project_order/'+project_order_id+'/porlor_5/porlor4/move_to_previous_page/'+porlor4_id;
        return new Promise((resolve,reject)=>{
            axios.post(url,this._put_method)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Move to Next Page
    moveToNextPage(project_order_id,porlor4_id){
        let url=this.url+'/admin/project_order/'+project_order_id+'/porlor_5/porlor4/move_to_next_page/'+porlor4_id;
        return new Promise((resolve,reject)=>{
            axios.post(url,this._put_method)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
} export default Porlor5Service