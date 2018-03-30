import WebUrl from '../webUrl';
import axois from 'axios';
let webUrl = new WebUrl();
class MaterialItem {
    constructor(){
        this.url = webUrl.getUrl();
    }
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
        let url = this.url+'/admin/materials/items/update_global_details';
        return new Promise((resolve,reject)=>{
            axois.put(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        });
    }
    //Update Local Price Details
    updateLocalPriceDetails(inputData,id){
        let url= this.url+'/admin/materials/items/update_local_price_details/'+id;
        // let url=this.url+'/test';
        return new Promise((resolve,reject)=>{
            axois.put(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Local Price
    deleteLocalPrice(id){
        let url =this.url+'/admin/materials/items/delete_local_price/'+id;
        return new Promise((resolve,reject)=>{
            axois.delete(url)
                .then(result=>{
                    resolve(result.data);
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Waiting Local Price
    deleteWaitingLocalPrice(id){
        let url =this.url+'/admin/materials/items/delete_waiting_local_price/'+id;
        return new Promise((resolve,reject)=>{
            axois.delete(url)
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