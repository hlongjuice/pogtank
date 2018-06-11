import WebUrl from '../webUrl';
let webUrl=new WebUrl();
class Porlor4Service{
    constructor(){
        this.url=webUrl.getUrl();
        this._delete_method={
            _method:'DELETE'
        };
    }

    exportByRootID(porlor4_id,root_job_id){
        let url=this.url+'/project/export/porlor4/'+porlor4_id+'/job/'+root_job_id;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                reject(err)
            })
        })
    }
}export default Porlor4Service;