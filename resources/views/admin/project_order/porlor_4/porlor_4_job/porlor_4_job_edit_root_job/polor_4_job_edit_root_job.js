import Porlor4JobService from '../../../../../../assets/js/services/project_order/porlor_4_job_service';
let porlor4JobService = new Porlor4JobService();
export const Porlor4JobEditRootJobModal = {
    data(){
        return {
            edit_root_job:{
                is_updated:false,
                is_loading:false,
                form: {
                    porlor_4_job_id:'',
                    root_job_name: ''
                }
            }

        }
    },
    methods:{
        beforeOpenPorlor4JobEditRootJobModal(data){
            let root_job = data.params.root_job;
            this.edit_root_job.is_updated=false;
            this.edit_root_job.form.porlor_4_job_id = root_job.id;
            this.edit_root_job.form.root_job_name = root_job.name;
        },
        openedPorlor4JobEditRootJobModal(){

        },
        closePorlor4JobEditRootJobModal(){
            this.$modal.hide('porlor-4-job-edit-root-job-modal',{
                is_updated:this.edit_root_job.is_updated
            })
        },
        editRootJobModal_updateData(scope,event){
            this.$validator.validateAll(scope)
                .then(result=>{
                    if(result){
                        this.edit_root_job.is_loading=true;
                        porlor4JobService.updateRootJob(this.porlor4.id,this.edit_root_job.form) // this.porlor4.id จาก หน้า index
                            .then(result=>{
                                this.edit_root_job.is_updated=true;
                                this.closePorlor4JobEditRootJobModal();
                                this.edit_root_job.is_loading=false;
                            })
                            .catch(err=>{alert(err)})
                    }
                    else{
                        alert('กรุณาระบุข้อมูล')
                    }
                })
        }
    }
};