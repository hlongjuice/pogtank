import WebUrl from '../webUrl';
let webUrlService = new WebUrl();
export class ContentCategoryService {
    constructor(){
        this.webUrl = webUrlService.getUrl();
    }
    //Add Category
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
    // Get All Categories
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
    // Get All Categories with Root
    getAllCategoriesWithRoot() {
        let url = this.webUrl + '/admin/content_categories/get_all_categories_with_root';
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
}