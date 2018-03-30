import WebUrl from '../webUrl';
import axois from 'axios';
let webUrl = new WebUrl();
class MaterialType {
    constructor() {
        this.url=webUrl.getUrl();
    }
    //Get Material Types
    getMaterialTypeTree(){
        let url=this.url+'/admin/materials/types/get_material_type_tree';
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{
                    reject(err)
            })
        });
    }
    //Get all types that could be parent
    getMaterialParentTypes(){
        let url=this.url+'/admin/materials/types/get_material_parent_type';
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data);
                    console.log('Service Get Type :',result);
                }).catch(err=>{
                    reject(err)
            })
        })
    }
    //get selected material Type
    getMaterialType(id){
        let url=this.url+'/admin/materials/types/get_material_type/'+id;
        return new Promise((resolve,reject)=>{
               axois.get(url)
                   .then(result=>{
                       resolve(result.data)
                   }).catch(err=>{
                       reject(err)
               })
        });
    }
    //get parent siblings types
    getMaterialParentSiblingTypes(id){
        let url=this.url+'/admin/materials/types/get_material_parent_sibling_types/'+id;
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data);
                }).catch(err=>{
                    reject(err);
            })
        });
    }
}
export default MaterialType;