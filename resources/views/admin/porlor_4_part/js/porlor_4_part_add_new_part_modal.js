import Porlor4PartService from '../../../../assets/js/services/project_order/porlor_4_part_service';
let porlor4PartService = new Porlor4PartService();
export const AddNewPartModal={
    data:function(){
        return {
            form:{
                part_name:''
            }
        }
    },
    methods:{
        addNewPart(){
            porlor4PartService.addNewPart(this.form)
                .then(result=>{
                    this.addNewPartStatus=true;
                    this.closeAddNewPartModal();
                }).catch(err=>{alert(err)})
        },
        closeAddNewPartModal(){
            this.$modal.hide('porlor-4-part-add-new-part-modal')
        }
    }
};