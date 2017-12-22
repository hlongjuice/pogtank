const dict = {
    custom: {
        materialName: {required: 'ชื่อสินค้า'},
        materialTypeID: {required: 'หมวดหมู่'},
        materialUnit: {required: 'หน่วย'}
    }
};
//Created Vue Instance
let vm = new Vue({
    el: '#app',
    data: {
        materialName: '',
        test: 'abc',
        item: '',
        materialTypes: materialTypes,
        provinces: provinces,
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
            invoiceCost: 0,
            invoicePrice: 0,
        },
        displayStatus: []
    },
    created: function () {
        this.$validator.localize('en', dict);
        this.displayStatus.push(false);
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
                                alert('เพิ่มเสร็จแล้ว');
                                window.location=indexRoute+'/added';
                                // console.log(result.data);
                            }).catch(err => {
                            alert('ไม่สามารถเพิ่มข้อมูลได้ลองใหม่อีกครั้ง');
                            console.log(err);
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
                districts: []
            };
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