let addModal = new Vue({
    el: '#editAddPriceModal',
    data: {
        provinces: provinces,
        form: {
            province: '',
            amphoe: '',
            district: '',
            amphoes: [],
            districts: []
        }
    },
    methods: {
        // -- Get Amphoe
        getAmphoes: function () {
            this.form.districts.splice(0);
            this.form.amphoes = this.form.province.amphoes;
        },
        closeAddPriceModal:function(){
            this.$modal.hide('add-local-price-modal')
        },
        beforeOpen:function(event){
            console.log(event);
        },
    }
});