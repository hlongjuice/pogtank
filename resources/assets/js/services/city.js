import axios from 'axios';
import WebUrl from './webUrl';
var webUrl=new WebUrl();
class City{
    constructor(){
        this.webUrl=webUrl.getUrl();
    }
    //Static Method
    static allProvince(){
        let url = this.url+'/admin/materials/city/provinces';
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    resolve(result.data);
                    console.log(result);
                }).catch(err=>{
                reject(err)
            })
        })
    }
    getProvinces(){
        return new Promise((resolve,reject)=>{
            axios.get(this.webUrl+'/admin/materials/city/provinces')
                .then(result=>{
                    resolve(result.data);
                    console.log('Province :',result);
                }).catch(err=>{
                    reject(err)
            })
        });
    }
    getDistricts(amphoeID){
        console.log('Amphoe ID',amphoeID);
        let url =this.webUrl+'/admin/materials/items/districts/' + amphoeID;
        console.log('Get District URL:',url);
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(function (result) {
                    resolve(result.data);
                }).catch(err => {
                    reject(err)
            })
        })
    }
}
export default City;