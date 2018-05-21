import Porlor4JobService from '../../../../../../assets/js/services/project_order/porlor_4_job_service';

let porlor4JobService = new Porlor4JobService();
export const Porlor4JobDetails = {
    data: function () {
        return {
            showLoadingJobDetails: false,
            root_job: '',
            child_jobs: [],
            child_jobs_v2: '',
            detailScrollable: true,
            job_details: {
                pages: []
            }
        }
    },
    methods: {
        beforeOpenJobDetailsModal(event) {
            //Get Parent Jobs
            this.root_job = event.params.root_job;
            console.log('Root Job ID :', this.root_job.id);
            console.log('Porlor 4 Job Details');
            this.child_jobs = [];
            this.job_details = {
                checked: []
            }

        },
        //Opened Job Details Modal
        openedJobDetailsModal() {
            this.getAllChildJobAndItems();
        },
        //Get All Child Job and Item
        getAllChildJobAndItems() {
            this.showLoadingJobDetails = true;
            porlor4JobService.getAllChildJobsV2(this.porlor4.id, this.root_job.id)
                .then(result => {
                    // this.child_jobs = result;
                    this.child_jobs = result;
                    console.log('All Child Job V2 :', this.child_jobs);
                    this.showLoadingJobDetails=false;
                })
        },
        showAddChildJobModal(page_number, total_page_number) {
            this.detailScrollable = false;
            this.$modal.show('porlor-4-add-child-job-modal', {
                page_number: page_number,
                total_page_number: total_page_number
            })
        },
        showAddChildJobItemModal(job, page_number) {
            this.detailScrollable = false;
            console.log('Show Add Child Job Item Modal');
            this.$modal.show('porlor-4-add-child-job-item-modal', {
                child_job: job,
                page_number: page_number
            })
        },
        //Show Edit Child Job Modal
        showEditChildJobModal(job) {
            this.detailScrollable = false;
            this.$modal.show('porlor-4-edit-child-job-modal', {
                job: job
            })
        },
        //Show Edit Child Job Item Modal
        showEditChildJobItemModal(job_item){
          this.detailScrollable= false;
          this.$modal.show('porlor-4-edit-child-job-item-modal',{
              job_item:job_item
          })
        },
        //Close Modal
        closePorlor4JobDetailsModal() {
            this.$modal.hide('porlor-4-job-details-modal')
        },
        // Before Close Add Child Job
        beforeCloseAddChildJobModal(event) {
            this.detailScrollable = true;
            let status = event.params.add_status;
            if (status) {
                this.getAllChildJobAndItems()
            }
        },
        //closedAddChildJobItemModal
        beforeCloseAddChildJobItemModal(event) {
            this.detailScrollable = true;
            console.log('Close Add Child Job Item Modal Event :', event);
            let status = event.params.add_status;
            if (status) {
                this.getAllChildJobAndItems()
            }
        },
        //Before Close Edit Child Job
        beforeCloseEditChildJobModal(event) {
            console.log('Before Close Edit Child Job Modal', event);
            this.detailScrollable = true;
            let status = event.params.edit_status;
            if (status) {
                this.getAllChildJobAndItems()
            }
        },
        //Before Close Edit Child Job Item
        beforeCloseEditChildJobItemModal(event) {
            console.log('Before Close Edit Child Job Modal', event);
            this.detailScrollable = true;
            let status = event.params.edit_status;
            if (status) {
                this.getAllChildJobAndItems()
            }
        },
        jobDetails_addPorlor4Page() {
            //ถ้ายังไม่มีข้อมูลซักหน้าก็เพิ่มหน้าใหม่ใส่ child_jobs array ได้เลย
            if (this.child_jobs.length < 1) {
                let newPage = {
                    page: 1,
                    jobs: [],
                    total_page: 1,
                    page_sum_price_wage: 0
                };
                this.child_jobs.push(newPage);
                //หากมีข้อมูลเดิมอยู่แล้วต้องมาเช็คเงื่อนไขเพิ่มเติมดังนี้
            } else {
                let errCount = 0;
                let newPage = {
                    page: null,
                    jobs: [],
                    total_page: null,
                    page_sum_price_wage: 0
                };
                //วนลูปดูการเรียกลำดับ page ว่ามีตัวเลขกระโดดข้ามหน้าหรือไม่ เช่น 1,2,4,5 (หน้า 3 หายไป)
                for (let i = 1; i < this.child_jobs.length; i++) {
                    //หากมี หน้าถัดไป - หน้าปัจจุบัน ไม่เท่ากับ 1 แสดงว่ามีหน้าขาด 4 - 2 = 2
                    if (this.child_jobs[i].page - this.child_jobs[i - 1].page !== 1) {
                        //แก้โดยให้หน้าปัจจุบัน + 1
                        newPage.page = this.child_jobs[i - 1].page + 1;
                        //แต่หมายเลขหน้าสุดท้ายยังคงเลขเดิมไม่ต้องบวกเพิ่ม
                        newPage.total_page = this.child_jobs.slice(-1).pop().page;
                        this.child_jobs.splice(i, 0, newPage);
                        i = this.child_jobs.length;
                        //หากมีการเรียกหน้ากระโดดข้าม errCount จะ +1
                        errCount++;
                    }
                }
                //ถ้า errCount === 0 แปลว่าการเรียงเลขหน้าปกติ
                //หน้าใหม่ก็จะ +1 จากหน้าสุดท้ายของชุดข้อมูลเดิม โดยที่หน้าสุดท้ายใหม่ก็จะเท่ากับหน้าใหม่ด้วยเช่นกัน
                if (errCount === 0) {
                    newPage.page = this.child_jobs.slice(-1).pop().page + 1;
                    newPage.total_page = newPage.page;
                    this.child_jobs.push(newPage)
                }
            }
        },
        jobDetails_deleteItem(item, order_number, index) {
            console.log('delete Item Index :', index);
            let item_index = index + 1;
            let item_order_number = order_number + '.1.' + item_index;
            console.log('Delete Item : ', item);
            this.$dialog.confirm('' +
                '<p>ยืนยันการลบ</p><h4 class="text-danger">' + item_order_number + ' '
                + item.details.approved_global_details.name + '</h4>'
            ).then(() => {
                this.showLoadingJobDetails=true;
                porlor4JobService.deleteItem(this.porlor4.id, item.id)
                    .then(result => {
                        this.getAllChildJobAndItems();
                        this.showLoadingJobDetails=false;
                    }).catch(err => {
                    alert(err)
                })
            }).catch(() => {

            });
        },
        jobDetails_deleteChildJob(job) {
            this.$dialog.confirm('' +
                '<p>ยืนยันการลบ</p><h4 class="text-danger">' + job.job_order_number + ' ' + job.name + '</h4>'
                + '<p>การลบนี้จะลบรายการย่อยในกลุ่มด้วยทั้งหมด</p>'
            )
                .then(() => {
                    this.showLoadingJobDetails=true;
                    console.log('Delete Child Job :', job);
                    porlor4JobService.deleteChildJob(this.porlor4.id, job.id)
                        .then(result => {
                            this.getAllChildJobAndItems();
                            this.showLoadingJobDetails=false;
                        }).catch(err => {
                        alert(err)
                    })
                }).catch(() => {
            });
        },
        jobDetails_deletePage(index) {
            this.child_jobs.splice(index, 1);
        }
    }
};