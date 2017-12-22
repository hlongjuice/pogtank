const dict= {
    custom: {
        materialName: {
            required:''
        }
    }
};
let itemCreate= new Vue({
    el: '#app',
    data: {
        materialName: '',
        test: 'abc',
        item: '',
        materialTypes:[],
        provinces:[],
        // materialTypes: JSON.parse('{!! $materialTypes !!}'),
        // provinces: JSON.parse('{!!$provinces!!}'),
        form: {
            city: [{
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            }],
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
            console.log(this.$validator);
            this.$validator.validateAll(scope)
                .then(function (result) {
                    if (result) {
                        alert('All Valid');
                        return;
                    }
                    alert('Invalid');
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
            this.form.city.push(city);
        },
        // -- Get Amphoe
        getAmphoes: function (index) {
            this.form.city[index].amphoe = ''; // clear old amphoe
            this.form.city[index].district = '';//clear old district
            this.form.city[index].amphoes = this.form.city[index].province.amphoes;
        },
        // -- Get District
        getDistricts: function (index) {
            this.form.city[index].district = ''; // clear old district
            axios.get('/admin/materials/items/districts/' + this.form.city[index].amphoe.id)
                .then(function (result) {
                    vm.$data.form.city[index].districts = result.data;
                    console.log(result.data);
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