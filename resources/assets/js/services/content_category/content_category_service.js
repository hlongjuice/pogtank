import WebUrl from '../webUrl';
let webUrlService = new WebUrl();
export class ContentCategoryService {
    constructor(){
        this.url = webUrlService.getUrl();
    }
    //Add Category
    addCategory(dataInput) {
        let url = this.url + '/admin/content_categories/add_category';
        return new Promise((resolve, reject) => {
            axios.post(url,dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
    //Get Selected Category
    //region Get Selected Category
    getCategory(id) {
        let url = this.url + '/admin/content_categories/get_category/'+id;
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

    // Get All Categories
    getAllCategories(parent = 0) {
        let url = this.url + '/admin/content_categories/get_all_categories/'+parent;
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
    getAllCategoriesWithRoot(parent=0) {
        let url = this.url + '/admin/content_categories/get_all_categories_with_root/'+parent;
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
    getAllCategoriesWithSelectAll(parent=0) {
        let url = this.url + '/admin/content_categories/get_all_categories_with_select_all/'+parent;
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }

    // Get All Categories Without ID
    getAllCategoriesWithoutID(id,parent=0) {
        let url = this.url + '/admin/content_categories/get_all_categories_without_id/'+parent+'/'+id;
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }

    //Update Category
    updateCategory(dataInput) {
        dataInput._method='PUT';
        let url = this.url + '/admin/content_categories/update_category';
        return new Promise((resolve, reject) => {
            axios.post(url,dataInput )
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
    //Delete Categories
    deleteCategories(dataInputs) {
        dataInputs._method = 'DELETE';
        let url = this.url + '/admin/content_categories/delete_categories';
        return new Promise((resolve, reject) => {
            axios.post(url, dataInputs)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }


}