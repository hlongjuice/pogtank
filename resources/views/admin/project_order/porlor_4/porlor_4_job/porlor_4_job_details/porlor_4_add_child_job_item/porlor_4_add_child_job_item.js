import MaterialTypeService from '../../../../../../../assets/js/services/material/material_type_service';
import MaterialItemService from '../../../../../../../assets/js/services/material/material_item_service';
import Porlor4JobService from '../../../../../../../assets/js/services/project_order/porlor_4_job_service';

let porlor4JobService = new Porlor4JobService();
let materialItemService = new MaterialItemService();
let materialTypeService = new MaterialTypeService();
export const Porlor4AddChildJobItem = {
    data() {
        return {
            add_child_job_item: {
                child_job:'',
                add_status: false,
                isLoading: false,
                leaf_jobs: [],
                new_material_item: {
                    name: ''
                },
                form: {
                    is_item:1,
                    page_number:'',
                    child_job: '',
                    items: [{
                        material_types: [],
                        material_items: [],
                        material_type: '',
                        material_item: '',
                        material_name: '',
                        local_price: '',
                        local_wage: '',
                        quantity: 0,
                        unit: ''
                    }]
                },
            }
        }
    },
    methods: {
        beforeOpenAddChildJobItemModal(event) {
            this.addChildJobItemResetData(event);
        },
        openedAddChildJobItemModal() {
            this.add_child_job_item.isLoading = true;
            Promise.all([
                porlor4JobService.getAllChildJobsWithOutItems(this.porlor4.id,this.root_job.id)
                    .then(result=>{
                        this.add_child_job_item.leaf_jobs = result;
                        console.log('Leaf Jobs :', this.add_child_job_item.leaf_jobs);
                    }).catch(err=>{

                }),
                //Get All Leaf Jobs
                // porlor4JobService.getAllLeafJobs(this.porlor4.id, this.root_job.id)
                //     .then(result => {
                //         this.add_child_job_item.leaf_jobs = result;
                //         console.log('Leaf Jobs :', this.add_child_job_item.leaf_jobs);
                //     }),
                //เลือก items 200 รายการแรก ทาง types ทั้งหมด
                //Get Material Items
                materialItemService.getItems()
                    .then(result => {
                        this.add_child_job_item.form.items[0].material_items = result;
                    }).catch(err => {
                    alert(err);
                })
                //ด้านล่างเป็นการแยกประเภท items จาก types
                //Get Material Types
                // materialTypeService.getMaterialTypeTree()
                //     .then(result => {
                //         let allType = {
                //             name_eng: 'all',
                //             name: 'ทั้งหมด',
                //             id: 0
                //         };
                //         this.add_child_job_item.form.items[0].material_types = result;
                //         //Add selected All type at first of type list
                //         this.add_child_job_item.form.items[0].material_types.unshift(allType);
                //         this.add_child_job_item.form.items[0].material_type =  this.add_child_job_item.form.items[0].material_types[0];
                //         //Get Material Items
                //         materialItemService.getItemsOfType(this.add_child_job_item.form.items[0].material_type.id)
                //             .then(result => {
                //                 this.add_child_job_item.form.items[0].material_items = result;
                //             }).catch(err => {
                //             alert(err);
                //         })
                //     })
                //     .catch(err => {alert(err);})
            ]).then(() => {
                this.add_child_job_item.isLoading = false;
            }).catch(() => {
                this.add_child_job_item.isLoading = false;
            });
        },
        addChildJobItemResetData(event) {
            let child_job = event.params.child_job;
            let page_number=event.params.page_number;
            if(child_job == null){
                child_job = '';
            }
            console.log('Add Child Job Item Event data : ',event.params);
            this.add_child_job_item = {
                add_status: false,
                isLoading: false,
                leaf_jobs: [],
                new_material_item: {
                    name: ''
                },
                form: {
                    is_item :1 ,
                    page_number:page_number,
                    child_job: child_job,
                    items: [{
                        material_types: [],
                        material_items: [],
                        material_type: '',
                        material_item: '',
                        material_name: '',
                        local_price: '',
                        local_wage: '',
                        quantity: 0,
                        unit: ''
                    }]
                },
            }
        },
        addChildJobItem(form, event) {
            //this.project_details จาก ไฟล์ root mixin (porlor_4_index.js)
            this.add_child_job_item.form.project_details = this.project_details;
            console.log('Item Form Inputs :',this.add_child_job_item.form);
            this.$validator.validateAll(form)
                .then(result => {
                    if (result) {
                        this.add_child_job_item.isLoading = true;
                        porlor4JobService.addChildJobItemV2(this.porlor4.id, this.add_child_job_item.form)
                            .then(result => {
                                console.log('Add New Item Success');
                                this.add_child_job_item.isLoading = false;
                                this.add_child_job_item.add_status = true;
                                this.closeAddChildJobItemModal();
                            }).catch(err => {
                            alert(err);
                            this.add_child_job_item.isLoading = false;
                        })
                    } else {
                        alert('กรุณาระบุข้อมูล')
                    }
                })
        },
        addChildJobItemDeleteInput(index) {
            this.add_child_job_item.form.items.splice(index, 1);
        },
        addChildJobItemGetItemDetails(index, item) {
            console.log('Get Item Details ', index, item, parent);
            if (item) {
                this.add_child_job_item.form.items[index].local_price = item.global_price;
                this.add_child_job_item.form.items[index].local_wage = item.global_wage;
                this.add_child_job_item.form.items[index].unit = item.unit;
            }
        },
        addChildJobItem_AddMoreInputs() {
            //
            if (this.add_child_job_item.isLoading === false) {
                this.add_child_job_item.isLoading = true;
            }
            let new_item = {
                material_types: [],
                material_items: [],
                material_type: '',
                material_item: '',
                material_name: '',
                local_price: '',
                local_wage: '',
                quantity: 0,
                unit: ''
            };
            materialItemService.getItems()
                .then(result => {
                    new_item.material_items = result;
                    this.add_child_job_item.form.items.push(new_item);
                    this.add_child_job_item.isLoading = false
                }).catch(err => {
                alert(err);
                this.add_child_job_item.isLoading = false
            })

            //Get Material Types
            // materialTypeService.getMaterialTypeTree()
            //     .then(result => {
            //         let allType = {
            //             name_eng: 'all',
            //             name: 'ทั้งหมด',
            //             id: 0
            //         };
            //         new_item.material_types = result;
            //         //Add selected All type at first of type list
            //         new_item.material_types.unshift(allType);
            //         new_item.material_type = new_item.material_types[0];
            //         //Get Material Items
            //         materialItemService.getItemsOfType(this.add_child_job_item.form.items[0].material_type.id)
            //             .then(result => {
            //                 new_item.material_items = result;
            //                 this.add_child_job_item.isLoading = false;
            //                 this.add_child_job_item.form.items.push(new_item);
            //             }).catch(err => {
            //             alert(err);
            //             this.add_child_job_item.isLoading = false;
            //         })
            //     })
            //     .catch(err => {
            //         alert(err)
            //         this.add_child_job_item.isLoading = false;
            //     })
        },
        addChildJobItem_AddNewMaterialItem(item, index) {
            let inputs = {
                material_item: {
                    name: this.add_child_job_item.new_material_item.name
                }
            };
            console.log('Add New Item Inputs', inputs);
            materialItemService.addNewOtherItem(inputs)
                .then(new_item => {
                    console.log('Add New Item Success : ', new_item);
                    item.material_item = new_item;
                    materialItemService.searchItemsByName(this.add_child_job_item.new_material_item.name)
                        .then(items => {
                            item.material_items = items;
                        }).catch(err => {
                        alert(err)
                    })

                }).catch(err => {
                alert(err)
            })
        },
        addChildJobItem_SearchItemsByName(item, search_name) {
            console.log('Search Items By Name :', search_name);
            this.add_child_job_item.new_material_item.name = search_name;
            materialItemService.searchItemsByName(search_name)
                .then(result => {
                    console.log('Search Result :', result);
                    item.material_items = result;
                }).catch(err => {
                alert(err)
            })
        },
        closeAddChildJobItemModal() {
            this.$modal.hide('porlor-4-add-child-job-item-modal', {
                add_status: this.add_child_job_item.add_status
            })
        },
        getMaterialTypes() {

        },
        //Get Items OF Type
        getMaterialItemsOfType(index) {
            this.add_child_job_item.form.items[index].material_item = '';
            materialItemService.getItemsOfType(this.add_child_job_item.form.items[index].material_type.id)
                .then(result => {
                    console.log('Material Item :', result);
                    this.add_child_job_item.form.items[index].material_items = result;
                }).catch(err => {
                alert(err)
            })
        },
        //Search Item Of Type By name
        searchMaterialItemsOfType(item, search_name) {
            this.add_child_job_item.new_material_item.name = search_name;
            // this.add_child_job_item.isLoading = true;
            materialItemService.searchItemsOfTypeByName(item.material_type.id, search_name)
                .then(result => {
                    console.log('Search Material Items :', result);
                    this.add_child_job_item.material_items = result;
                    // this.add_child_job_item.isLoading = false;
                }).catch(err => {
                alert(err)
            })
        },
        childJobCustomLabel(item) {
            return item.job_order_number + ' ' + item.name;
        },
        materialItemCustomLabel(item) {
            if (item.approved_global_details) {
                return item.approved_global_details.name;
            }
        },
    },
    watch: {
        //หน้าใช้งานใน porlor 4 ราคาต่างๆเป็นราคา ประจำตำบล แต่ข้อมูลที่ดึงมาจาก DB จะดึงราคาส่วนกลางมาแสดง
        //หากราคาส่วนกลางไม่ตรงกับราคาประจำตำบลนั้นๆ ผู้ใช้สามารถแก้ไขและปรับปรุงได้
        'add_child_job_item.form.material_item'(item) {
            console.log('Add Child Job Item Selected Item :', item);
            this.add_child_job_item.form.local_price = item.approved_global_details.global_price;
            this.add_child_job_item.form.local_wage = item.approved_global_details.global_wage;
            this.add_child_job_item.form.unit = item.approved_global_details.unit;
        }
    }
};