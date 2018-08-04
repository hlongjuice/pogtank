import WebUrl from '../webUrl';
let webUrl = new WebUrl();
export class ContentService {
    constructor(){
        this.url = webUrl.getUrl();
    }
    //Get All Content

    // Add Content
    addContent(dataInput) {
        let url = this.url + '/admin/contents/add_content';
        return new Promise((resolve, reject) => {
            axios.post(url, dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }

    //Update Content
    updateContent(dataInput) {
        dataInput._method = 'PUT';
        let url = this.url + '/admin/update_content';
        return new Promise((resolve, reject) => {
            axios.post(url, dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }

    //Delete Content
    deleteContent(content_id) {
        let dataInput ={
          _method : 'DELETE'
        };
        let url = this.url + '/admin/delete_content/'+content_id;
        return new Promise((resolve, reject) => {
            axios.post(url, dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }


}