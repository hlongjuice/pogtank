import Porlor4JobService from '../../../../../../../assets/js/services/project_order/porlor_4_job_service';
import MaterialItemService from '../../../../../../../assets/js/services/material/material_item_service';

let materialItemService = new MaterialItemService();
let porlor4JobService = new Porlor4JobService();
export const Porlor4EditChildJobItem = {
    data: function () {
        return {
            edit_child_job_item: {
                job_item: '',
                show_real_time_add_new_material_button: false,
                updated_status: false,
                isLoading: false,
                new_material_item: {
                    name: '',
                    is_loading: false
                },
                old_item_id: '',
                form: {
                    project_details: '',
                    job_id: '',
                    item_id: '',
                    is_item: 1,
                    page_number: '',
                    child_job: '',
                    material_items: [],
                    material_type: '',
                    material_item: '',
                    material_name: '',
                    local_price: '',
                    local_wage: '',
                    quantity: 0,
                    unit: ''
                },
            }
        }
    },
    methods: {
        beforeOpenEditChildJobItemModal(event) {
            console.log('Edit Child Job ITem Job ITem : ', event.params.job_item);
            console.log('Item ID', this.edit_child_job_item.form.item_id);
            this.editChildJobItem_resetData();
            this.edit_child_job_item.old_item_id = '';
            // this.edit_child_job_item.job_item = event.params.job_item;
            this.edit_child_job_item.form.job_id = event.params.job_item.id;
            this.edit_child_job_item.form.item_id = event.params.job_item.item.id;
            this.edit_child_job_item.form.material_item = event.params.job_item.item.details;
            this.edit_child_job_item.form.local_price = event.params.job_item.item.local_price;
            this.edit_child_job_item.form.local_wage = event.params.job_item.item.local_wage;
            this.edit_child_job_item.form.unit = event.params.job_item.item.unit;
            this.edit_child_job_item.form.quantity = event.params.job_item.item.quantity;
            this.edit_child_job_item.form.project_details = this.project_details;
            this.edit_child_job_item.old_item_id = this.edit_child_job_item.form.material_item.approved_global_details.id;
            console.log('Edit Child Job Ites Form :', this.edit_child_job_item.form)

        },
        openedEditChildJobItemModal() {
            this.edit_child_job_item.isLoading = true;
            Promise.all([
                //Get Material Items
                materialItemService.getItems()
                    .then(result => {
                        this.edit_child_job_item.form.material_items = result;
                        // this.edit_child_job_item.form.material_item =
                    }).catch(err => {
                    alert(err);
                })
            ]).then(() => {
                this.edit_child_job_item.isLoading = false;
            }).catch(() => {
                this.edit_child_job_item.isLoading = false;
            });
        },
        //Reset Data Before Use
        editChildJobItem_resetData() {
            this.edit_child_job_item = {
                job_item: '',
                show_real_time_add_new_material_button: false,
                updated_status: false,
                isLoading: false,
                new_material_item: {
                    name: '',
                    is_loading: false
                },
                old_item_id: '',
                form: {
                    project_details: '',
                    job_id: '',
                    item_id: '',
                    is_item: 1,
                    page_number: '',
                    child_job: '',
                    material_items: [],
                    material_type: '',
                    material_item: '',
                    material_name: '',
                    local_price: '',
                    local_wage: '',
                    quantity: 0,
                    unit: ''
                },
            }
        },
        editChildJobItem_updateItem(form, event) {
            console.log('Update Item Form', form, event);
            //this.project_details จาก ไฟล์ root mixin (porlor_4_index.js)
            console.log('Item Form Inputs :', this.edit_child_job_item.form);
            this.$validator.validateAll(form)
                .then(result => {
                    if (result) {
                        this.edit_child_job_item.isLoading = true;
                        porlor4JobService.updateChildJobItem(this.porlor4.id, this.edit_child_job_item.form)
                            .then(result => {
                                console.log('Update Child Job Item Success');
                                this.edit_child_job_item.isLoading = false;
                                this.edit_child_job_item.updated_status = true;
                                this.closeEditChildJobItemModal();
                            }).catch(err => {
                            alert(err);
                            this.edit_child_job_item.isLoading = false;
                        })
                    } else {
                        alert('กรุณาระบุข้อมูล')
                    }
                })
        },
        editChildJobItem_getItemDetails(item) {
            console.log('Edit Child Job Form Item ID :', this.edit_child_job_item.form.material_item.approved_global_details.id);
            console.log('Selected Item ', item);
            if (item) {
                if (this.edit_child_job_item.old_item_id != item.id || this.edit_child_job_item.old_item_id == '') {
                    this.edit_child_job_item.form.local_price = item.global_price;
                    this.edit_child_job_item.form.local_wage = item.global_wage;
                    this.edit_child_job_item.form.unit = item.unit;
                }
            }
        },

        editChildJobItem_addNewMaterialItem() {
            let inputs = {
                material_item: {
                    name: this.edit_child_job_item.new_material_item.name
                }
            };
            this.$refs.edit_child_job_item_multi_select_item.deactivate();
            this.add_child_job_item.new_material_item.is_loading=true;
            console.log('Add New Item Inputs', inputs);
            materialItemService.addNewOtherItem(inputs)
                .then(new_item => {
                    console.log('Add New Item Success : ', new_item);
                    this.edit_child_job_item.form.material_item = new_item;
                    materialItemService.searchItemsByName(this.edit_child_job_item.new_material_item.name)
                        .then(items => {
                            console.log('get New Item Success : ', new_item);
                            this.edit_child_job_item.form.material_items = items;
                            this.add_child_job_item.new_material_item.is_loading=false;
                        }).catch(err => {
                        alert(err)
                    })

                }).catch(err => {
                alert(err)
            })
        },

        editChildJobItem_searchItemsByName(search_name) {
            console.log('Search Items By Name :', search_name);
            this.edit_child_job_item.new_material_item.name = search_name;
            materialItemService.searchItemsByName(search_name)
                .then(result => {
                    console.log('Search Result :', result);
                    this.edit_child_job_item.material_items = result;
                    let findSearchIndex = this.edit_child_job_item.material_items.findIndex(item => {
                        return item.approved_global_details.name == search_name;
                    });
                    this.edit_child_job_item.show_real_time_add_new_material_button = findSearchIndex < 0;
                    if(this.edit_child_job_item.material_items.length == 0){
                        this.edit_child_job_item.show_real_time_add_new_material_button = false;
                    }
                }).catch(err => {
                alert(err)
            })
        },
        closeEditChildJobItemModal() {
            this.$modal.hide('porlor-4-edit-child-job-item-modal', {
                edit_status: this.edit_child_job_item.updated_status
            })
        },
        editChildJobItem_customLabel(item) {
            return item.job_order_number + ' ' + item.name;
        },
        editChildJobItem_materialItemCustomLabel(item) {
            if (item.approved_global_details) {
                return item.approved_global_details.name;
            }
        },
    }
};