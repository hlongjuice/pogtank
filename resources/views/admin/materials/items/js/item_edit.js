const dict = {
    custom: {
        materialName: {required: 'ชื่อสินค้า'},
        materialTypeID: {required: 'ประเภท'},
        materialUnit: {required: 'หน่วย'}
    }
};
let vm = new Vue({
    el: '#app',
    data: {
        materialName: '',
        test: 'abc',
        item: '',
        materialTypes: materialTypes,
        provinces: provinces,
        form: {
            cities: [],
            materialVendor: '',
            materialName: globalPrice.name,
            materialUnit: globalPrice.unit,
            materialType: globalPrice.type,
            materialTypeID: globalPrice.type.id,
            globalCost: globalPrice.global_cost,
            globalPrice: globalPrice.global_price,
            invoiceCost: globalPrice.invoice_cost,
            invoicePrice: globalPrice.invoice_price,
        },
        displayStatus: []
    },
    created: function () {
        this.$validator.localize('en', dict);
        this.displayStatus.push(false);
        material.local_prices.forEach(item => {
            this.form.cities.push({
                province: item.province,
                amphoe: item.amphoe,
                district: item.district,
                amphoes: item.province ? item.province.amphoes : [],
                districts: item.amphoe ? item.amphoe.districts : [],
                localCost: item.cost,
                localPrice: item.price,
                wage: item.wage
            })
        });
    },
//Methods
    methods: {
        //Modal
        showAddPriceModal:function(){
            this.$modal.show('add-local-price-modal',{
                form:this.form
            })
        },
        // -- Form Validation
        validateForm: function (scope, ev) {
            this.$validator.validateAll(scope)
                .then(function (result) {
                    let errMassage = 'กรุณาระบุ ';
                    if (result) {
                        axios.post('/admin/materials/items', vm.form)
                            .then((result) => {
                                window.location = indexRoute + '/updated'
                            });
                        return;
                    }

                    vm.$validator.errors.items.forEach(error => {
                        errMassage = errMassage + error.msg + ', ';
                    });
                    alert(errMassage);
                    ev.preventDefault();
                });
        },
        // -- Add more Local Price Input
        addPriceInput: function () {
            var city = {
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

console.log(vm.form);

