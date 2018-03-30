import ProductService from '../../../../assets/js/services/product/product_service';

let productService = new ProductService();
new Vue({
    el: '#product-index',
    data: {
        showLoading: '',
        products: {}
    },
    mounted: function () {
        this.showLoading = true;
        this.initialData()
    },
    methods: {
        //Initial
        initialData() {
            Promise.all([
                productService.getAllProducts()
                    .then(result => {
                        this.products = result;
                    }).catch(err => {
                    alert(err)
                })
            ]).then(()=>{
                this.showLoading=false;
            }).catch(()=>{

            })
        },
        //Get All Product
        refreshData() {
            productService.getAllProducts()
                .then(result => {
                    this.products = result;
                }).catch(err => {
                alert(err)
            })
        },
        //Get Selected Product Page
        getSelectedProductPage(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            productService.getSelectedProductPage(page)
                .then(result => {
                    this.products = result
                }).catch(err => {
                alert(err)
            })
        }
    }
});