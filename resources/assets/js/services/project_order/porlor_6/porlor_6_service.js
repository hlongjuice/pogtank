import WebUrl from '../../webUrl';
let webUrl=new WebUrl();
class Porlor6Service {
    constructor() {
        this.url = webUrl.getUrl();
        this._put_method ={
            _method:'PUT'
        }
    }
    //Get Porlor5
    getPorlor6(project_order_id){
        let url=this.url+'/admin/project_order/'+project_order_id+'/porlor_6';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
} export default Porlor6Service