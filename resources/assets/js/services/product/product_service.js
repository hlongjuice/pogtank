import WebUrl from '../webUrl';
import axois from 'axios';
let webUrl = new WebUrl();
class ProductService{
    constructor(){
        this.url=webUrl.getUrl();
    }
    //Get Products
    getAllProducts(){
        let url = this.url+'/admin/product/get_all_products';
        return new Promise((resolve,reject)=>{
           axios.get(url)
               .then(result=>{
                   resolve(result.data)
               }).catch(err=>{reject(err)})
        });
    }
    //Get All Product With Page
    getAllProductsWithPages(){
        let url = this.url+'/admin/product/get_all_products_with_pages';
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //getSelectedProductPage
    getSelectedProductPage(page){
        let url = this.url+'/admin/product/get_all_products?page='+page;
        return new Promise((resolve,reject)=>{
            axois.get(url)
                .then(result=>{
                    console.log('Get Selected Product Page Result :',result);
                    resolve(result.data)
                })
                .catch(err=>{reject(err)})
        })
    }
    //Add New Product
    addNewProduct(inputData){
        let url = this.url+'/admin/product/add_new_product';
        return new Promise((resolve,reject)=>{
            axois.post(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        });

    }
}export default ProductService;