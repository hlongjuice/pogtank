import Porlor4JobService from '../../../../../../assets/js/services/project_order/porlor_4_job_service';
let porlor4JobService = new Porlor4JobService();
export const Porlor4JobDetails ={
    data:function(){
        return {
            showLoadingJobDetails:'',
            root_job:'',
            child_jobs:[]
        }
    },
    methods:{
        beforeOpenJobDetailsModal(event){
            //Get Parent Jobs
            this.root_job = event.params.root_job;
            console.log('Root Job ID :',this.root_job.id);
            console.log('Porlor 4 Job Details');
            this.child_jobs=[];
            //Get All Child Jobs
            porlor4JobService.getAllChildJobs(this.porlor4.id,this.root_job.id)//this.porlor4.id มาจาก ไฟล์ porlor_4_job ไฟล์แรก
                .then(result=>{
                    this.child_jobs=result;
                    console.log('Child Jobs :',this.child_jobs);
                }).catch(err=>{
                    console.log(err.response.status);
            })

        },
        showAddChildJobModal(page_number){
            this.$modal.show('porlor-4-add-child-job-modal',{
                page_number:page_number
            })
        },
        showAddChildJobItemModal(item){
            console.log('Show Add Child Job Item Modal');
            this.$modal.show('porlor-4-add-child-job-item-modal',{
                child_job:item
            })
        },
        //Close Modal
        closePorlor4JobDetailsModal(){
            this.$modal.hide('porlor-4-job-details-modal')
        }
    }
};