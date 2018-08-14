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

    // Get All Contents
    getAllContents(page) {
        let url = this.url + '/admin/contents/get_all_contents?page='+page;
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }

    // Get Single Content
    getContent(id) {
        let url = this.url + '/admin/contents/get_content/'+id;
        return new Promise((resolve, reject) => {
            axios.get(url)
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
        let url = this.url + '/admin/contents/update_content';
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
    deleteContents(dataInput) {
        dataInput._method ='DELETE';
        let url = this.url + '/admin/contents/delete_contents';
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