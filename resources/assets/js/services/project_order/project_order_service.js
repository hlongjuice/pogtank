import WebUrl from '../webUrl';
// import axios from 'axios';
let webUrl = new WebUrl();

let token = document.head.querySelector('meta[name="csrf-token"]');
console.log('Token 11',token.content);
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }
class ProjectOrderService{
    constructor(){
        this.url=webUrl.getUrl();
    }
    //Get All Project Order
    getAllProjectOrders(){
        // let url = this.url+'/my_job';
        let url = this.url+'/admin/project_order/get_all_orders';
        return new Promise((resolve,reject)=>{
            // axios.get('https://jsonplaceholder.typicode.com/posts/1')
            // axios.get('http://www.ggdemo.com/admin/project_order/get_all_orders')
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