import Porlor4JobService from '../../../../../../../assets/js/services/project_order/porlor_4_job_service';
let porlor4JobService = new Porlor4JobService();
export const Porlor4AddChildJob ={
    data:function(){
        return {
            add_child_job:{
                form:{
                    job_order_number:'',
                    name:'',
                    parent:{},
                    quantity_factor:0,
                    unit:'',
                    page_number:''
                },
                parents:[]
            },
        }
    },
    methods:{
        beforeOpenAddChildJobModal(event){
            //Reset Data
            this.addChildJobResetData(event.params.page_number);
            porlor4JobService.getParentJobs(this.porlor4.id,this.root_job.id)
                .then(result=>{
                    this.add_child_job.parents=result;
                    console.log('Parents Job Result :',result);
                }).catch(err=>{
                    alert(err);

                })
        },
        //Reset Data
        addChildJobResetData(page_number){
            this.add_child_job={
                form:{
                    job_order_number:'',
                    name:'',
                    parent:{
                        job_order_number:'',
                        id:0,
                        name:'รายการหลัก'
                    },
                    quantity_factor:0,
                    unit:'',
                    page_number:page_number
                },
                test:'test',
                parents:[]
            }
        },
        addChildJob(scope,event){
            console.log('Child Job Form :',this.add_child_job.form);
            this.$validator.validateAll(scope)
                .then(result=> {
                    if(result){
                        porlor4JobService.addChildJob(this.porlor4.id,
                            this.root_job.id,this.add_child_job.form)
                            .then(result=>{
                                console.log(result);
                            }).catch(err=>{alert(err)})
                    }else{
                        console.log('Empty')
                    }
                })
        },

        childJobCustomLabel(item){
            return item.job_order_number+' '+ item.name;
        },
        closeAddChildJobModal(){
            this.$modal.hide('porlor-4-add-child-job-modal')
        }
    }
};