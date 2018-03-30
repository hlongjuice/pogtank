import ProductService from '../../../../assets/js/services/product/product_service';
import WebUrl from '../../../../assets/js/services/webUrl';

let webUrl = new WebUrl();
let productService = new ProductService();
new Vue({
    el: '#product-create',
    data: {
        form: {
            name: ''
        }
    },
    methods: {
        addNewProduct: function (scope, ev) {
            this.$validator.validateAll(scope)
                .then(result => {
                    if(result){
                        productService.addNewProduct(this.form)
                            .then(result => {
                                let route = webUrl.getRoute('/admin/product');
                                window.location = route;
                            }).catch(err => {
                            alert(err)
                        })
                    }
                    else {
                        vm.$validator.errors.items.forEach(error => {
                            errMassage = errMassage + error.msg + ', ';
                        });
                        alert(errMassage);
                    }
                })
        }
    }
    });