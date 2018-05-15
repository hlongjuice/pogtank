import WebUrl from '../webUrl';
let webUrl = new WebUrl();
class ProjectOrderService{
    constructor(){
        this.url=webUrl.getUrl();
    }
    //Get All Project Order
    getAllProjectOrders(){
        let url = this.url+'/admin/project_order/get_all_orders';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    console.log('Result',result);
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
                })
        })
    }
    //Add New Project Order
    addNewOrder(inputData){
        let url=this.url+'/admin/project_order/add_new_order';
        return new Promise((resolve,reject)=>{
            axios.post(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{alert(err)})
        })
    }
    //Update Project Details
    updateProjectDetails(inputData){
        let url=this.url+'/admin/project_order/update_project_details';
        return new Promise((resolve,reject)=>{
            axios.put(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Order
    deleteProject(id){
        let url=this.url+'/admin/project_order/delete_project/'+id;
        return new Promise((resolve,reject)=>{
           axios.delete(url)
               .then(result=>{
                   resolve(result.data)
               }).catch(err=>{reject(err)})
        });
    }
}export default ProjectOrderService;