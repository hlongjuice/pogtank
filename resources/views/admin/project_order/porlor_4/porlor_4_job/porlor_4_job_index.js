import Porlor4JobService from '../../../../../assets/js/services/project_order/porlor_4_job_service';
import Porlor4Service from '../../../../../assets/js/services/project_order/porlor_4_service';
import {Porlor4JobAddRoot} from './porlor_4_job_add_root/porlor_4_job_add_root';
import {Porlor4JobDetails} from "./porlor_4_job_details/porlor_4_job_details";
import {Porlor4AddChildJob} from "./porlor_4_job_details/porlor_4_add_child_job/porlor_4_add_child_job";
import {Porlor4AddChildJobItem} from "./porlor_4_job_details/porlor_4_add_child_job_item/porlor_4_add_child_job_item";
import {Porlor4EditChildJob} from "./porlor_4_job_details/porlor_4_edit_child_job/porlor_4_edit_child_job";

let porlor4 = porlor4FromBlade; // get from index blade template
let porlor4Service = new Porlor4Service();
let porlor4JobService = new Porlor4JobService();

console.log('Porlor 4 ID :',porlor4.id);
new Vue({
    el: '#porlor-4-job-index',
    mixins:[
        Porlor4JobAddRoot,
        Porlor4JobDetails,
        Porlor4AddChildJob,
        Porlor4AddChildJobItem,
        Porlor4EditChildJob
    ],
    data: {
        porlor4:porlor4,
        //Modal Status
        addRootJobStatus:false,
        updatedJobDetailStatus:false,
        //End Modal Status
        partDetails:{},
        showLoading:'',
        jobs:[],
        project_details:{
            province:{},
            amphoe:{},
            district:{}
        }
    },
    mounted: function () {
        this.initialData();
    },
    methods: {
        initialData(){
            this.showLoading=true;
            Promise.all([
                //Get All Jobs
                porlor4JobService.getAllRootJobs(this.porlor4.id)
                    .then(result=>{
                        console.log('Init Get Jobs Method Result :',result);
                        this.jobs=result;
                        this.showLoading=false;
                    }).catch(err=>{
                        console.log('Error Job Index Get All Root Jobs :',error)
                    }),
                //Get Part Details
                porlor4JobService.getPartDetails(this.porlor4.id)
                    .then(result=>{
                        console.log('Init Get Part Result :',result);
                        this.partDetails=result;
                    }).catch(err=>{
                        console.log("Error Job index Get Part Details :",err);
                        this.showLoading=false;
                    }),
                //Get Project Details
                porlor4Service.getProjectDetails(this.porlor4.project_order_id)
                    .then(result=>{
                        console.log('Project Details is : ',result);
                        this.project_details=result;
                    }).catch(err=>{
                      console.log('Errors Job Index Get Project Details :',error)
                })
            ]).then(()=>{
                this.showLoading=false;
            }).catch(()=>{
                this.showLoading=false;
            });
        },
        refreshData(){
            this.showLoading=true;
            //Get All Jobs
            porlor4JobService.getAllRootJobs(porlor4.id)
                .then(result=>{
                    console.log('Init Get Jobs Method Result :',result);
                    this.jobs=result;
                    this.showLoading=false;
                }).catch(err=>{
                    alert(err);
                    this.showLoading=false;
                })
        },
        //Before Close Add Root Job Modal
        beforeCloseAddRootJobModal(){
            if(this.addRootJobStatus){
                this.refreshData();
            }
        },
        //Before Close Show Job Details Modal
        beforeCloseJobDetailsModal(){
            if(this.updatedJobDetailStatus){
                this.refreshData();
            }
        },
        //Add Root Job
        showAddRootJobModal(){
            this.$modal.show('porlor-4-job-add-root-job-modal')
        },
        //Show Job Details
        showJobDetailsModal(root_job){
            this.$modal.show('porlor-4-job-details-modal',{
                root_job:root_job
            });
        }

    }
});