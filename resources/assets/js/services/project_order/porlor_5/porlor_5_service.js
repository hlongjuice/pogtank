import WebUrl from '../../webUrl';
let webUrl=new WebUrl();
class Porlor5Service {
    constructor() {
        this.url = webUrl.getUrl();
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
} export default Porlor5Service