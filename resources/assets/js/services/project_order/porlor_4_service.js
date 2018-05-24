import WebUrl from '../webUrl';
    let webUrl=new WebUrl();
    class Porlor4Service{
    constructor(){
        this.url=webUrl.getUrl();
        this._delete_method={
            _method:'DELETE'
        };
    }
    //Add New Part
    addNewPart(order_id,dataInput){
        let url=this.url+'/admin/project_order/'+order_id+'/porlor_4/add_part';
        return new Promise((resolve,reject)=>{
            axios.post(url,dataInput)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Part
    deletePart(porlor_4_id){
        let url=this.url+'/admin/project_order/porlor_4/delete_part/'+porlor_4_id;
        return new Promise((resolve,reject)=>{
            axios.post(url,this._delete_method)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Get All Porlor 4
    getAllParts(order_id){
        let url=this.url+'/admin/project_order/'+order_id+'/porlor_4/get_all_parts';
        return new Promise((resolve,reject)=>{
           axios.get(url)
               .then(result=>{
                   resolve(result.data);
               }).catch(err=>{reject(err)})
        });
    }
    //Get Project Details
    getProjectDetails(order_id){
        let url = this.url+'/admin/project_order/'+order_id+'/porlor_4/get_project_details';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    console.log('Get Project Details Service');
                    resolve(result.data);
                }).catch(err=>{reject(err)})
        })
    }
    //Update Part
    updatePart(dataInputs){
        dataInputs._method = 'PUT';
        let url = this.url+'/admin/project_order/porlor_4/update_part';
        return new Promise((resolve,reject)=>{
            axios.post(url,dataInputs)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
}export default Porlor4Service;