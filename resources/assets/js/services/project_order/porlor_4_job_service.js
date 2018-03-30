import WebUrl from '../webUrl';
let webUrl=new WebUrl();
class Porlor4JobService {
    constructor(){
        this.url= webUrl.getUrl();
    }
    //Add Root Job
    addRootJob(porlor_4_id,dataInputs){
        let url = this.url+'/admin/project_order/porlor_4_id/'+porlor_4_id+'/add_root_job';
        return new Promise((resolve,reject)=>{
            axios.post(url,dataInputs)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                reject(err)
            })
        })
    }
    //Add Child Job
    addChildJob(porlor_4_id,root_job_id,dataInputs){
        let url = this.url+'/admin/project_order/porlor_4_id/'+porlor_4_id+'/add_child_job/'+root_job_id;
        return new Promise((resolve,reject)=>{
            axios.post(url,dataInputs)
                .then(result=>{
                    resolve(result);
                }).catch(err=>{reject(err)})
        })
    }
    //Get All Root Jobs
    getAllRootJobs(porlor_4_id){
        let url=this.url+'/admin/project_order/porlor_4_id/'+porlor_4_id+'/get_all_root_jobs';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        })
    }
    //Get All Child Job
    getAllChildJobs(porlor_4_id,root_job_id){
        let url = this.url+"/admin/project_order/porlor_4_id/"+porlor_4_id+'/get_all_child_jobs/'+root_job_id;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Get All Leaf Jobs
    getAllLeafJobs(porlor_4_id,root_job_id){
        let url =this.url+"/admin/project_order/porlor_4_id/"+porlor_4_id+'/get_all_leaf_jobs/'+root_job_id;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Get Parents Job
    getParentJobs(porlor_4_id,porlor_4_job_id){
        let url=this.url+'/admin/project_order/porlor_4_id/'+porlor_4_id+'/get_parent_jobs/'+ porlor_4_job_id;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        })
    }
    //Get Part Details
    getPartDetails(porlor_4_id){
        let url = this.url+'/admin/project_order/porlor_4_id/'+porlor_4_id+'/get_part_details';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        })
    }

}export default Porlor4JobService;