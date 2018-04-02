import City from '../../../../../assets/js/services/city';
import MaterialType from '../../../../../assets/js/services/material/material_type_service';
import WebUrlService from '../../../../../assets/js/services/webUrl';

let webUrlService = new WebUrlService();
const dict = {
    custom: {
        materialName: {required: 'ชื่อสินค้า'},
        materialTypeID: {required: 'หมวดหมู่'},
        materialUnit: {required: 'หน่วย'},
        province: {required: 'จังหวัด'},
        amphoe: {required: 'อำเภอ'},
        district: {required: 'ตำบล'}
    }
};
//Created Vue Instance
let vm = new Vue({
    el: '#material-item-create',
    data: {
        show:'',
        city:new City(),
        materialName: '',
        test: 'abc',
        item: '',
        materialTypes:[],
        provinces:[],
        form: {
            cities: [{
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            }],
            materialVendor: '',
            materialName: '',
            materialUnit: '',
            materialType: '',
            materialTypeID: '',
            globalCost: 0,
            globalPrice: 0,
            globalWage:0,
            invoiceCost: 0,
            invoicePrice: 0,
            invoiceWage:0
        },
        displayStatus: []
    },
    created: function () {
    },
    //Mounted
    mounted:function(){
        console.log('Mounted');
        this.show=true;
        this.$validator.localize('en', dict);
        this.displayStatus.push(false);
        let materialTypes=new MaterialType();
        Promise.all([
            materialTypes.getMaterialTypeTree()//Get All Materials
                .then(result=>{
                    console.log(result);
                    vm.materialTypes=result;
                }).catch(err=>{
            }),
            this.city.getProvinces() // Get Provinces
                .then(result => {
                    vm.provinces=result;
                }).catch(err => {
                console.log(err)
            })
        ])
            .then(()=>{
                this.show=false;
            })
            .catch();
    },
//Methods
    methods: {
        // -- Form Validation
        validateForm: function (scope, ev) {
            this.$validator.validateAll(scope)
                .then(function (result) {
                    let errMassage = 'กรุณาระบุ ';
                    if (result) {
                        axios.post('/admin/materials/items', vm.form)
                            .then((result) => {
                                // alert('เพิ่มเสร็จแล้ว');
                                // window.location=indexRoute+'/added';
                               window.location= webUrlService.getRoute('/admin/materials/items/submitted/added');
                                console.log(result);
                            }).catch(err => {
                            alert('ไม่สามารถเพิ่มข้อมูลได้ลองใหม่อีกครั้ง');
                            console.log(err);
                            console.log('Bad!!')
                        });
                    } else {
                        vm.$validator.errors.items.forEach(error => {
                            errMassage = errMassage + error.msg + ', ';
                        });
                        alert(errMassage);
                    }
                });
        },
        // -- Add more Local Price Input
        addPriceInput: function () {
            let city = {
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            };
            // let city='';
            this.form.cities.push(city);
        },
        // -- Get Amphoe
        getAmphoes: function (index) {
            this.form.cities[index].amphoe = ''; // clear old amphoe
            this.form.cities[index].district = '';//clear old district
            this.form.cities[index].districts.splice(0);
            this.form.cities[index].amphoes = this.form.cities[index].province.amphoes;
        },
        // -- Get District
        getDistricts: function (index) {
            this.form.cities[index].district = ''; // clear old district
            axios.get('/admin/materials/items/districts/' + this.form.cities[index].amphoe.id)
                .then(function (result) {
                    vm.form.cities[index].districts = result.data;
                    console.log(result.data);
                }).catch(err => {
                console.log(err);
            })
        },
        // -- Delete Local Price Input
        deleteLocalPrice: function (number) {
            console.log(number);
        }
    },
    watch: {
        'form.materialType': function () {
            this.form.materialTypeID = this.form.materialType.id;
        }
    },
});