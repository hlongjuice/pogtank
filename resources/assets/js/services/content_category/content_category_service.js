import WebUrl from '../webUrl';
let webUrlService = new WebUrl();
export class ContentCategoryService {
    constructor(){
        this.webUrl = webUrlService.getUrl();
    }
    //region Add Category
    addCategory(dataInput) {
        let url = this.webUrl + '/admin/content_categories/add_category';
        return new Promise((resolve, reject) => {
            axios.post(url,dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
    //endregion
    //region Get All Categories
    getAllCategories() {
        let url = this.webUrl + '/admin/content_categories/get_all_categories';
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }

    //endregion
}