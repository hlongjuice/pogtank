import MaterialItemService from '../../../../../assets/js/services/material/material_item_service';
const dict = {
    custom: {
        province: {required: 'จังหวัด'},
        amphoe: {required: 'อำเภอ'},
        district: {required: 'ตำบล'}
    }
};
let materialItemService = new MaterialItemService();
export const AddModal={
    data:function(){
      return {
      }
    },
    mounted: function () {
        this.$validator.localize('en', dict);
    },
    methods:{
        //Add Local Price
        addLocalPrice: function (scope, ev) {
            console.log('Form Event',ev);
            this.$validator.validateAll(scope)
                .then( result=> {
                    let errMassage = 'กรุณาระบุ ';
                    if (result) {
                        this.form.material_id=this.material.id;
                        materialItemService.addLocalPrices(this.form)
                            .then(()=>{
                                this.addStatus=true;
                                this.closeAddPriceModal();
                            }).catch(err=>{alert(err)})
                    } else {
                        this.$validator.errors.items.forEach(error => {
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
                localPrice: 0,
                localCost: 0,
                wage: 0
            };
            this.form.cities.push(city);
        },
        beforeOpen:function(event){
            console.log('Before Open')
        },
        // Close Add Price Modal
        closeAddPriceModal: function () {
            this.$modal.hide('add-local-price-modal')
        },
        showAddPriceModal: function () {
            this.$modal.show('add-local-price-modal');
            // this.$modal.show('add-local-price-modal', {
            // form: this.form,
            // provinces: vm.provinces,
            // material_id: vm.material.id
            // })
        },

    }
};