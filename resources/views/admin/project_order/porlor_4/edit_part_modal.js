import Porlor4PartService from '../../../../assets/js/services/project_order/porlor_4_part_service';
import Porlor4Service from '../../../../assets/js/services/project_order/porlor_4_service';
let porlor4Service = new Porlor4Service();
let porlor4PartService = new Porlor4PartService();
export const EditPartModal ={
  data(){
      return {
          edit_part:{
              is_updated:false,
              is_loading:false,
              parts:[],
              form:{
                  project_order_id:'',
                  porlor_4_id:'',
                  part:''
              }
          }
      }
  },
  methods:{
      beforeOpenEditPartModal(data){
        console.log('Item Data :',data.params.item);
          let item = data.params.item;
          this.edit_part.is_updated=false;
          this.edit_part.form.project_order_id=item.project_order_id;
          this.edit_part.form.porlor_4_id=item.id;
          this.edit_part.form.part=item.part;
      },
      openedEditPartModal(){
          console.log('Edit Part Form',this.edit_part.form);
          this.edit_part.is_loading=true;
          porlor4PartService.getAvailableParts(this.edit_part.form.project_order_id,this.edit_part.form.porlor_4_id)
              .then(result=>{
                  console.log('Get Available Part : ',result);
                  this.edit_part.is_loading=false;
                  this.edit_part.parts=result;
              }).catch(err=>{alert(err)})
      },
      closeEditPartModal(){
          this.$modal.hide('porlor-4-edit-part-modal',{
              is_updated:this.edit_part.is_updated
          })
      },
      porlor4EditModal_updatePart(scope,event){
          this.$validator.validateAll(scope)
              .then(result=>{
                  if(result){
                      this.edit_part.is_loading=true;
                      porlor4Service.updatePart(this.edit_part.form)
                          .then(result=>{
                              this.edit_part.is_updated=true;
                              this.closeEditPartModal();
                              this.edit_part.is_loading=false;
                          }).catch(err=>{alert(err)})
                  }else{
                      alert('กรุณาระบุข้อมูล')
                  }
              })
      }
  }
};