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
                add_status:false,
                isLoading: false,
                leaf_jobs: [],
                material_types: [],
                material_items: [],
                form: {
                    child_job: '',
                    material_type: '',
                    material_item: '',
                    material_name: '',
                    local_price:'',
                    local_wage:'',
                    quantity:0,
                    unit:''
                }
            }
        }
    },
    methods: {
        beforeOpenAddChildJobItemModal(event) {
            this.addChildJobItemResetData();
        },
        openedAddChildJobItemModal(){
            this.add_child_job_item.isLoading=true;
            Promise.all([
                //Get Material Types
                materialTypeService.getMaterialTypeTree()
                    .then(result => {
                        let allType={
                          name_eng:'all',
                            name:'ทั้งหมด',
                          id:0
                        };
                        this.add_child_job_item.material_types = result;
                        //Add selected All type at first of type list
                        this.add_child_job_item.material_types.unshift(allType);
                        console.log('Material Types : ', this.add_child_job_item.material_types);
                    }).catch(err => {
                    alert(err)
                }),
                //Get All Leaf Jobs
                porlor4JobService.getAllLeafJobs(this.porlor4.id, this.root_job.id)
                    .then(result => {
                        this.add_child_job_item.leaf_jobs = result;
                        console.log('Leaf Jobs :', this.add_child_job_item.leaf_jobs);
                    }),
                //Get Material Items
                materialItemService.getItemsOfType(this.add_child_job_item.form.material_type.id)
                    .then(result=>{
                        this.add_child_job_item.material_items=result;
                    }).catch(err=>{alert(err)})

            ]).then(()=>{
                this.add_child_job_item.isLoading=false;
            })
                .catch();
        },
        addChildJobItemResetData() {
            this.add_child_job_item = {
                add_status:false,
                isLoading: false,
                leaf_jobs: [],
                material_types: [],
                material_items: [],
                form: {
                    child_job: '',
                    material_type: {
                        name_eng:'all',
                        name:'ทั้งหมด',
                        id:0
                    },
                    material_item: '',
                    material_name: '',
                    quantity:0,
                    local_price:'',
                    local_wage:'',
                    unit:'',

                }
            }
        },
        addChildJobItem(form, event) {
            this.$validator.validateAll(form)
                .then(result => {
                    if (result) {
                        this.add_child_job_item.isLoading=true;
                        porlor4JobService.addChildJobItem(this.porlor4.id,this.add_child_job_item.form)
                            .then(result=>{
                                this.add_child_job_item.isLoading=false;
                                this.add_child_job_item.add_status=true;
                                this.closeAddChildJobItemModal();
                            }).catch(err=>{
                                alert(err);
                                this.add_child_job_item.isLoading=false;
                        })
                    }else{
                        alert('กรุณาระบุข้อมูล')
                    }
                })
        },
        closeAddChildJobItemModal() {
            this.$modal.hide('porlor-4-add-child-job-item-modal',{
                add_status:this.add_child_job_item.add_status
            })
        },
        getMaterialTypes() {

        },
        //Get Items OF Type
        getMaterialItemsOfType() {
            materialItemService.getItemsOfType(this.add_child_job_item.form.material_type.id)
                .then(result => {
                    console.log('Material Item :', result);
                    this.add_child_job_item.material_items = result;
                }).catch(err => {
                alert(err)
            })
        },
        //Search Item Of Type By name
        searchMaterialItemsOfType(search_name) {
            // this.add_child_job_item.isLoading = true;
            materialItemService.searchItemsOfTypeByName(this.add_child_job_item.form.material_type.id, search_name)
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
            console.log('Material Item Custom Label', item);
            if (item.approved_global_details) {
                return item.approved_global_details.name;
            }
        },
        myEventBus(){

        }
    },
    watch:{
        //หน้าใช้งานใน porlor 4 ราคาต่างๆเป็นราคา ประจำตำบล แต่ข้อมูลที่ดึงมาจาก DB จะดึงราคาส่วนกลางมาแสดง
        //หากราคาส่วนกลางไม่ตรงกับราคาประจำตำบลนั้นๆ ผู้ใช้สามารถแก้ไขและปรับปรุงได้
        'add_child_job_item.form.material_item'(item){
          console.log('Add Child Job Item Selected Item :',item);
          this.add_child_job_item.form.local_price=item.approved_global_details.global_price;
          this.add_child_job_item.form.local_wage=item.approved_global_details.global_wage;
          this.add_child_job_item.form.unit=item.approved_global_details.unit;
        }
    }
};