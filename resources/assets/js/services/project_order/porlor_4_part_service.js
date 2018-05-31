import WebUrl from '../webUrl';
let webUrl = new WebUrl();
class Porlor4Part{
    constructor(){
        this.url=webUrl.getUrl();
        this._delete_method={
            _method:'DELETE'
        };
        this._put_method={
            _method:'PUT'
        }
    }
    //Add New Part
    addNewPart(dataInputs){
        let url = this.url+'/admin/porlor_4_parts/add_new_part';
        return new Promise((resolve,reject)=>{
            axios.post(url,dataInputs)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        })
    }
    //Get All Parts
    getAll(){
        let url = this.url+'/admin/porlor_4_parts/get_all';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                    console.log('Porlor 4 Part Service :',result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Get Available Parts
    getAvailableParts(project_order_id,porlor_4_id=null){
        let url = this.url+'/admin/porlor_4_parts/get_available_parts/'+project_order_id+'/porlor_4/'+porlor_4_id;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
}

export default Porlor4Part;