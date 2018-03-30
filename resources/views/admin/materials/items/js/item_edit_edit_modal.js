import MaterialItemService from '../../../../../assets/js/services/material/material_item_service';
let materialItemService = new MaterialItemService();
export const EditModal={
    data:function(){
        return {
            form:{
                'local_price_version_id':''
            }
        }
    },
    mounted: function () {
    },
    methods:{
        //Add Local Price
        updateLocalPrice: function (scope, ev) {
            console.log('Update Local Price Details');
            this.$validator.validateAll(scope)
                .then( result=> {
                    let errMassage = 'กรุณาระบุ ';
                    if (result) {
                        this.form.material_id=this.material.id;
                        materialItemService.updateLocalPriceDetails(this.form,this.form.local_price_version_id)
                            .then(result=>{
                                console.log('Update Local Price Result',result);
                                this.updateStatus=true;
                                toastr.success('อัพเดทเสร็จสมบูรณ์');
                                this.closeEditPriceModal();
                            }).catch(err=>{alert(err)})
                    } else {
                        this.$validator.errors.items.forEach(error => {
                            errMassage = errMassage + error.msg + ', ';
                        });
                        alert(errMassage);
                    }
                });
        },
        // -- Edit more Local Price Input
        beforeEditOpen:function(event){
            let data=event.params.local_price;
            console.log('Edit Modal Data',data);
            this.form= {
                material_id:this.material.id,//Data from parent
                local_price_id:data.local_price_id,
                local_price_version_id:data.id,
                cities: [{
                    province:data.province,
                    amphoe: data.amphoe,
                    district: data.district,
                    amphoes: data.province.amphoes,
                    districts: data.amphoe.districts,
                    localCost: data.cost,
                    localPrice: data.price,
                    wage: data.wage
                }]
            };
            console.log('Form in Edit Modal',this.form);
        },
        // Close Add Price Modal
        closeEditPriceModal: function () {
            this.$modal.hide('edit-local-price-modal')
        }
    }
};