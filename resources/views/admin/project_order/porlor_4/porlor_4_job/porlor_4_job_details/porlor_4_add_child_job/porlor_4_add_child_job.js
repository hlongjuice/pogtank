import Porlor4JobService from '../../../../../../../assets/js/services/project_order/porlor_4_job_service';
let porlor4JobService = new Porlor4JobService();
export const Porlor4AddChildJob ={
    data:function(){
        return {
            add_child_job:{
                total_page_number:0,
                add_status:false,
                form:{
                    page_number:'',
                    job_order_number:'',
                    name:'',
                    parent:{},
                    quantity_factor:0,
                    unit:'',
                    group_item_per_unit:false
                },
                parents:[]
            },
        }
    },
    methods:{
        beforeOpenAddChildJobModal(event){
            //Reset Data
            this.addChildJobResetData(event);
            porlor4JobService.getParentJobs(this.porlor4.id,this.root_job.id)
                .then(result=>{
                    this.add_child_job.parents=result;
                    console.log('Parents Job Result :',result);
                }).catch(err=>{
                    alert(err);

                })
        },
        //Reset Data
        addChildJobResetData(event){
            this.add_child_job={
                add_status:false,
                total_page_number:event.params.total_page_number,
                form:{
                    page_number:event.params.page_number,
                    job_order_number:'',
                    name:'',
                    parent:'',
                    quantity_factor:0,
                    unit:'',
                    group_item_per_unit:false
                },
                parents:[]
            }
        },
        addChildJob(scope,event){
            console.log('Add Child Job Form :',this.add_child_job.form);
            this.$validator.validateAll(scope)
                .then(result=> {
                    if(result){
                        porlor4JobService.addChildJob(this.porlor4.id,
                            this.root_job.id,this.add_child_job.form)
                            .then(result=>{
                                this.add_child_job.add_status =true;
                                this.closeAddChildJobModal();
                                console.log(result);
                            }).catch(err=>{alert(err)})
                    }else{
                        console.log('Empty')
                    }
                })
        },

        addChildJob_childJobCustomLabel(item){
            let label ='';
            if(item.job_order_number == null){
                item.job_order_number = '';
            }
            label=item.job_order_number+' '+ item.name;
            return label;
        },
        closeAddChildJobModal(){
            this.$modal.hide('porlor-4-add-child-job-modal',{
                add_status:this.add_child_job.add_status
            })
        }
    }
};