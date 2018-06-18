import WebUrl from '../webUrl';
import axois from 'axios';
let webUrl = new WebUrl();
//ใน class นี้มากจาก 2 controller
//1. ItemsController
//2. NewItemsController
class MaterialItem {
    constructor(){
        this.url = webUrl.getUrl();
        this._delete_method={
            _method:'DELETE'
        };
    }
    //***** จาก New Items Controller
    //Add New Item From Porlor 4 Form
    //เพิ่ม item ใหม่ในหมวดหมู่ อื่นๆ โดยเฉพาะ
    addNewOtherItem(formInputs){
        let url = this.url+'/admin/materials/new_items/add_new_other_item';
        return new Promise((resolve,reject)=>{
            axios.post(url,formInputs)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>reject(err))
        })
    }
    //Get First 50 items
    getItems(){
        let url = this.url+'/admin/materials/new_items/get_items';
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Get Approved Items By Page
    getApprovedItemsByPage(page){
        let url = this.url +'/admin/materials/new_items/get_approved_items_by_page?page='+page;
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Get Waiting Approve Items
    getWaitingItems(){
        let url = this.url +'/admin/materials/new_items/get_waiting_items';
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    searchItemsByName(material_name){
        let inputs = {
            material_name:material_name
        };
        let url= this.url+'/admin/materials/new_items/search_items_by_name';
        return new Promise((resolve,reject)=>{
            axois.post(url,inputs)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>reject(err))
        })
    }
    //***** End From New Item Controller

    //***** จาก ItemsController
    //Add Local Prices
    addLocalPrices(formInputs){
        let url=this.url+'/admin/materials/items/add_local_prices';
        return new Promise((resolve,reject)=>{
            axois.post(url,formInputs)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        });
    }
    //Get Items Of type
    getItemsOfType(type_id){
        let url = this.url+'/admin/materials/items/get_items_of_type/'+type_id;
        return new Promise((resolve,reject)=>{
           axois.get(url)
               .then(result=>{
                   resolve(result.data)
               }).catch(err=>{reject(err)})
        });
    }

    //Get Only One Material Item
    getItem(materialID){
        let url = this.url+'/admin/materials/items/edit/global_details/' + materialID;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result => {
                    resolve(result.data);
                }).catch(err => {
                    reject(err)
            })
        })
    }
    //get Approved Local Price
    getApprovedLocalPrice(materialID){
        let url=this.url+'/admin/materials/items/edit/' + materialID + '/approved_local_prices';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result => {
                    resolve(result.data);
                }).catch(err => {
                    reject(err)
            });
        });
    }
    //Get Waiting Local Price
    getWaitingLocalPrices(materialID){
        let url = this.url+'/admin/materials/items/edit/' + materialID + '/waiting_local_prices';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                    reject(err)
            });
        });
    }
    //update Global Details Values
    updateGlobalDetails(inputData){
        inputData._method = 'PUT';
        let url = this.url+'/admin/materials/items/update_global_details';
        return new Promise((resolve,reject)=>{
            axois.post(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        });
    }
    //Update Local Price Details
    updateLocalPriceDetails(inputData,id){
        inputData._method = 'PUT';
        let url= this.url+'/admin/materials/items/update_local_price_details/'+id;
        // let url=this.url+'/test';
        return new Promise((resolve,reject)=>{
            axois.post(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Approved Item (Root Item)
    deleteApprovedItem(inputData){
        inputData._method='DELETE';
        let url =this.url+'/admin/materials/new_items/delete_approved_items';
        return new Promise((resolve,reject)=>{
            axois.post(url,inputData)
                .then(result=>{
                    resolve(result.data);
                }).catch(err=>{reject(err)})
        })

    }
    //Delete Waiting Item (Root Item)
    deleteWaitingItem(inputData){
        inputData._method='DELETE';
        let url =this.url+'/admin/materials/new_items/delete_waiting_items';
        return new Promise((resolve,reject)=>{
            axois.post(url,inputData)
                .then(result=>{
                    resolve(result.data);
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Local Price
    deleteLocalPrice(id){
        let url =this.url+'/admin/materials/items/delete_local_price/'+id;
        return new Promise((resolve,reject)=>{
            axois.post(url,this._delete_method)
                .then(result=>{
                    resolve(result.data);
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Waiting Local Price
    deleteWaitingLocalPrice(id){
        let url =this.url+'/admin/materials/items/delete_waiting_local_price/'+id;
        return new Promise((resolve,reject)=>{
            axois.post(url,this._delete_method)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })

    }
    //Search Material Item of type by name
    searchItemsOfTypeByName(materialTypeID,materialName){
        let inputData = {
            'material_name':materialName
        };
        let url = this.url+'/admin/materials/items/search_items_of_type_by_name/'+materialTypeID;
        return new Promise((resolve,reject)=>{
            axois.post(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
}export  default MaterialItem;