import Porlor4JobService from '../../../../../../../assets/js/services/project_order/porlor_4_job_service';

let porlor4JobService = new Porlor4JobService();
export const Porlor4EditChildJob = {
    data: function () {
        return {
            edit_child_job: {
                showLoading: false,
                edit_status: false,
                child_job: '',
                form: {
                    id:'',
                    page_number: '',
                    job_order_number: '',
                    name: '',
                    parent: {},
                    quantity_factor: 0,
                    unit: '',
                    group_item_per_unit: ''
                },
                parents: []
            },
        }
    },
    methods: {
        beforeOpenEditChildJobModal(data) {
            this.edit_child_job.child_job = data.params.job;
            console.log('Before OPen Edit Child Job Data :', data);
        },
        openedEditChildJobModal() {
            this.edit_child_job.showLoading = true;
            let child_job = this.edit_child_job.child_job;
            console.log('Opened Edit Child Job Modal Child Job :', child_job);
            porlor4JobService.getParentJobs(this.porlor4.id, this.root_job.id)
                .then(result => {
                    console.log('Parents Job Result :', result);
                    let parent = child_job.ancestors.filter(item => {
                        return item.id === child_job.parent_id
                    }).pop();
                    //Initial Data
                    this.edit_child_job.form = {
                        id:child_job.id,
                        page_number: child_job.page_number,
                        job_order_number: child_job.job_order_number,
                        name: child_job.name,
                        parent: parent,
                        quantity_factor: child_job.quantity_factor,
                        unit: child_job.unit,
                        group_item_per_unit: child_job.group_item_per_unit
                    };
                    this.edit_child_job.parents = result;
                    this.edit_child_job.showLoading = false;

                }).catch(err => {
                alert(err);
            });
        },

        editChildJob_updateData(form, event){
            console.log('Update Data');
            this.$validator.validateAll(form)
                .then(result=>{
                    if(result){
                        this.edit_child_job.isLoading = true;
                        porlor4JobService.updateChildJob(this.porlor4.id,this.edit_child_job.form)
                            .then(result=>{
                                console.log('Update Child Job Success');
                                this.edit_child_job.isLoading = false;
                                this.edit_child_job.edit_status = true;
                                this.closeEditChildJobModal();
                            })
                            .catch()
                    }else{
                        alert('กรุณาระบุข้อมูล')
                    }
                }).catch(err=>{})
        }
        ,
        closeEditChildJobModal() {
            console.log('Close Edit Child Job Modal');
            this.$modal.hide('porlor-4-edit-child-job-modal',{
                edit_status:this.edit_child_job.edit_status
            });
        },
        editChildJob_childJobCustomLabel(item) {
            let label = '';
            label = item.job_order_number + ' ' + item.name;
            return label;
        }
    }
};