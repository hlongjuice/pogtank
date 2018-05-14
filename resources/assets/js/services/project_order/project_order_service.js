import WebUrl from '../webUrl';
// import axios from 'axios';
let webUrl = new WebUrl();
class ProjectOrderService{
    constructor(){
        this.url=webUrl.getUrl();
    }
    //Get All Project Order
    getAllProjectOrders(){
        let url = this.url+'/my_test';
        // let url = this.url+'/admin/project_order/get_all_orders';
        return new Promise((resolve,reject)=>{
            axios.get('http://www.ggdemo.com/my_test')
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
        let url=this.url+'/admin/project_order/update_order';
        return new Promise((resolve,reject)=>{
            axios.put(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Order
}export default ProjectOrderService;