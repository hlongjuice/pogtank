let addModal = new Vue({
    el: '#editAddPriceModal',
    data: {
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
            }]
        },
    },
    methods: {
        // -- Get Amphoe
        getAmphoes: function (index) {
            this.form.cities[index].districts.splice(0);
            this.form.cities[index].amphoes = this.form.cities[index].province.amphoes;
        },
        // Close Add Price Modal
        closeAddPriceModal: function () {
            this.$modal.hide('add-local-price-modal')
        },
        // Before Open Modal
        beforeOpen: function (event) {
            console.log(event);
        },
        // -- Add more Local Price Input
        addPriceInput: function () {
            let city = {
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localPrice:0,
                localCost:0,
                wage:0
            };
            this.form.cities.push(city);
        },
        // -- Delete Local Price
        deleteLocalPrice:function(index){
            this.form.cities.splice(index,1);
        }
    }
});