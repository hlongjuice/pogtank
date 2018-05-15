import CityService from '../../../assets/js/services/city';
import ProjectOrderService from '../../../assets/js/services/project_order/project_order_service';
let projectOrderService = new ProjectOrderService();
let cityService = new CityService();
export const ProjectOrderEditModal = {
  data(){
      return {
          project_order_edit:{
              is_updated:false,
              showLoading:'',
              provinces: [],
              amphoes: [],
              districts: [],
              products: [],
              form:{}
          }
      }
  },
    methods:{
        beforeOpenProjectOrderEditModal(data){
            this.project_order_edit.is_updated = false;
            this.project_order_edit.form = Object.assign({},data.params.order);
        },
        openedProjectOrderEditModal(){
            console.log('Order Form :',this.project_order_edit.form);
            cityService.getProvinces()
                .then(result => {
                    this.project_order_edit.provinces = result;
                    this.getAmphoes();
                    this.getDistricts();
                }).catch(err=>{alert(err)})
        },

        closeProjectOrderEditModal(){
            this.$modal.hide('project-order-edit-modal',{
                is_updated:this.project_order_edit.is_updated
            })
        },
        projectOrderEditModal_updateDetails(scope,event){
            this.$validator.validateAll(scope)
                .then(result=>{
                    if(result){
                        projectOrderService.updateProjectDetails(this.project_order_edit.form)
                            .then(result=>{
                                this.project_order_edit.is_updated=true;
                                this.closeProjectOrderEditModal();
                            }).catch(err=>{

                        })
                    }else{
                        alert('กรุณาระบุข้อมูลให้ครบถ้วน')
                    }
                }).catch(err=>{
                    alert(err)
            })
        },
        // -- Get Amphoe
        getAmphoes(changed) {
            console.log('Get Amphoes');
            console.log('Event Get Amphoes : ',event);
            if(changed){
                console.log('Province Changed');
                this.project_order_edit.form.amphoe = ''; // clear old amphoe
                this.project_order_edit.form.district = '';//clear old district
            }
            this.project_order_edit.districts.splice(0); // clear district array
            this.project_order_edit.amphoes = this.project_order_edit.form.province.amphoes;
        },
        // -- Get District
        getDistricts(changed) {
            if(changed){
                console.log('Amphoes Changed');
                this.project_order_edit.form.district = ''; // clear old district
            }
            cityService.getDistricts(this.project_order_edit.form.amphoe.id)
                .then(result => {
                    this.project_order_edit.districts = result;
                }).catch(err => {
                alert(err);
            });
        },
    }
};