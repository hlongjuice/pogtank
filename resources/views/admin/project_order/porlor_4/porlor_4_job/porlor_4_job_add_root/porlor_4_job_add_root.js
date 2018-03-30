import Porlor4JobService from '../../../../../../assets/js/services/project_order/porlor_4_job_service';

let porlor4JobService = new Porlor4JobService();
export const Porlor4JobAddRoot = {
    data: function () {
        return {
            form: {
                root_job_name: ''
            }
        }
    },
    methods: {
        beforeOpenAddRootJobModal() {
            this.addRootJobStatus = false;
            this.form.root_job_name='';
            console.log('Porlor4 from parent : ',this.porlor4);
        },
        addRootJob(scope, ev) {
            this.$validator.validateAll(scope)
                .then(result=> {
                    if(result){
                        porlor4JobService.addRootJob(this.porlor4.id, this.form)
                            .then(() => {
                                this.addRootJobStatus = true;
                                toastr.success('บันทึกเสร็จสมบูรณ์');
                                this.closeAddRootJobModal()
                            }).catch(err => {
                            alert(err)
                        })
                    }
                });
        },
        closeAddRootJobModal() {
            this.$modal.hide('porlor-4-job-add-root-job-modal')
        }

    }
};