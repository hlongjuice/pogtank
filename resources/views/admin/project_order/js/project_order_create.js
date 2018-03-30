import ProductService from '../../../../assets/js/services/product/product_service';
import CityService from '../../../../assets/js/services/city';
import ProjectOrderService from '../../../../assets/js/services/project_order/project_order_service';
import WebUrl from '../../../../assets/js/services/webUrl';

let productService = new ProductService();
let cityService = new CityService();
let projectOrderService = new ProjectOrderService();
let webUrlService = new WebUrl();
new Vue({
    el: '#project-order-create',
    data: {
        showLoading:'',
        provinces: [],
        amphoes: [],
        districts: [],
        products: [],
        form: {
            product: '',
            project_name: '',
            province: '',
            amphoe: '',
            district: '',
            location: '',
            owner_name: '',
            agency_name: '',
            referee_name: '',
            form_number: '',
            form_number_release:new Date()
        }
    },
    mounted: function () {
        this.showLoading=true;
        this.initialData();
    },
    methods: {
        initialData() {
            Promise.all([
                //Get Provinces
                cityService.getProvinces()
                    .then(result => {
                        this.provinces = result;
                    }).catch(err=>{alert(err)}),
                //Get Products
                productService.getAllProducts()
                    .then(result=>{
                        this.products=result;
                    }).catch(err=>{alert(err)})
            ]).then(()=>{
                this.showLoading=false;
            }).catch(()=>{

            });
        },
        //Add New Order
        addNewOrder(){
            console.log('Form Input :',this.form);
            projectOrderService.addNewOrder(this.form)
                .then(()=>{
                    window.location=webUrlService.getRoute('/admin/project_order');
                }).catch(err=>{alert(err)})
        },
        // -- Get Amphoe
        getAmphoes() {
            this.form.amphoe = ''; // clear old amphoe
            this.form.district = '';//clear old district
            this.districts.splice(0); // clear district array
            this.amphoes = this.form.province.amphoes;
        },
        // -- Get District
        getDistricts() {
            this.form.district = ''; // clear old district
            cityService.getDistricts(this.form.amphoe.id)
                .then(result => {
                    this.districts = result;
                }).catch(err => {
                alert(err);
            });
        },
    }
});