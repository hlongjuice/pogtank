import WebUrl from '../../services/webUrl';
let webUrl = new WebUrl();
export class ContentImageService{
    constructor(){
        this.webUrl = webUrl.getUrl();
    }

    uploadImage(formData){
        let url = this.webUrl+'/admin/contents/upload_image';
        return new Promise((resolve,reject)=>{
            axios.post(url, formData)
                .then(result => {
                   resolve(result.data)
                })
                .catch(err => {
                  reject(err)
                })
        });
    }
}