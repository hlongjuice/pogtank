import MaterialItemService from '../../../../../assets/js/services/material/material_item_service';
import MaterialTypeService from '../../../../../assets/js/services/material/material_type_service';
import City from '../../../../../assets/js/services/city';
import {AddModal} from './item_edit_add_modal';
import {EditModal} from './item_edit_edit_modal';
const dict = {
    custom: {
        materialName: {required: 'ชื่อสินค้า'},
        materialTypeID: {required: 'ประเภท'},
        materialUnit: {required: 'หน่วย'}
    }
};
let materialItemService = new MaterialItemService();
let materialTypeService = new MaterialTypeService();
let path = window.location.pathname;
let materialID = path.split("/").slice(-1);
let cityService = new City();
//Initial Data
let vm = new Vue({
    el: '#material-item-edit',
    mixins:[AddModal,EditModal],
    data: {
        addStatus:false,
        updateStatus:false,
        showLoading: '',
        material: {},
        waitingItemNumber: 0,
        item: '',
        materialTypes: [],
        provinces: [],
        //Global Details
        approvedGlobalDetails: {},
        waitingGlobalDetails: {},
        waitingLocalPrices: {},
        approvedLocalPrices: {},
        displayStatus: [],
        checkedWaitingLocalPrices: [],
        form: {
            material_id:'',
            cities: [{
                province: '',
                amphoe: '',
                district: '',
                amphoes: [],
                districts: [],
                localCost: 0,
                localPrice: 0,
                wage: 0
            }]
        },
    },
    mounted: function () {
        this.showLoading = true;
        this.initialData();
    },
//Methods
    methods: {
        //Initial Data
        initialData: function () {
            Promise.all([
                //Get Province
                cityService.getProvinces()
                    .then(result => {
                        vm.provinces = result;
                    }).catch(err => {
                }),
                //Get Material Types
                materialTypeService.getMaterialTypeTree()
                    .then(result => {
                        this.materialTypes = result;
                    })
                    .catch(err => {
                        alert(err)
                    }),
                //Get Material Item ที่ต้องการแก้ไข
                materialItemService.getItem(materialID)
                    .then(result => {
                        this.material = result;
                        console.log(this.material);
                    }).catch(err => {
                    console.log(err);
                    alert(err);
                }),
                //Get Approved Local Price
                materialItemService.getApprovedLocalPrice(materialID)
                    .then(result => {
                        this.approvedLocalPrices = result;
                    }).catch(err => {
                    alert(err)
                }),
                materialItemService.getWaitingLocalPrices(materialID)
                    .then(result => {
                        this.waitingLocalPrices = result
                    }).catch(err => {
                    alert(err)
                })

            ]).then(() => {
                this.showLoading = false;
            });
            // Set config defaults when creating the instance
            this.$validator.localize('en', dict);
            this.displayStatus.push(false);
            console.log(this.$validator)
        },
        refreshData: function () {
            this.showLoading=true;
            this.addStatus=false;
            this.updateStatus=false;
            this.resetFormData();
            console.log('Form After Refresh',this.form);
            Promise.all([
                //Get Material Item ที่ต้องการแก้ไข
                materialItemService.getItem(materialID)
                    .then(result => {
                        this.material = result;
                    }).catch(err => {
                    console.log(err);
                    alert(err);
                }),
                //Get Approved Local Price
                materialItemService.getApprovedLocalPrice(materialID)
                    .then(result => {
                        this.approvedLocalPrices = result;
                    }).catch(err => {
                    alert(err)
                }),
                materialItemService.getWaitingLocalPrices(materialID)
                    .then(result => {
                        this.waitingLocalPrices = result
                    }).catch(err => {
                    alert(err)
                })

            ]).then(() => {
                this.showLoading = false;
            });
        },
        resetFormData:function(){
            this.form= {
                material_id:'',
                cities: [{
                    province: '',
                    amphoe: '',
                    district: '',
                    amphoes: [],
                    districts: [],
                    localCost: 0,
                    localPrice: 0,
                    wage: 0
                }]
            };
        },
        //Modal
        showAddLocalPriceModal: function () {
            console.log('Parent Master',vm);
            this.$modal.show('add-local-price-modal')
        },
        showEditLocalPriceModal:function(item,status){
            console.log('Edit Item',item);
            let data ={};
            if(status ==='approved'){
                data = item.approved_price;
            }else if (status ==='waiting'){
                data = item.waiting_price;
            }
            this.$modal.show('edit-local-price-modal',{
                local_price:data
            });
        },
        beforeClose: function (event) {
            console.log('Form',this.form);
            this.resetFormData();
            if(this.addStatus || this.updateStatus){
                this.refreshData();
            }
        },
        // -- Form Validation
        validateForm: function (scope, ev) {
            console.log(vm.form.materialID);
            vm.form._method='PUT';
            this.$validator.validateAll(scope)
                .then(function (result) {
                    let errMassage = 'กรุณาระบุ ';
                    if (result) {
                        axios.post('/admin/materials/items/' + vm.form.materialID, vm.form)
                            .then((result) => {
                                console.log(result);
                                // window.location = indexRoute + '/updated'
                            });
                        return;
                    }

                    vm.$validator.errors.items.forEach(error => {
                        errMassage = errMassage + error.msg + ', ';
                    });
                    alert(errMassage);
                    ev.preventDefault();
                });
        },
        // -- Get Amphoe
        getAmphoes: function (index) {
            this.form.cities[index].amphoe = ''; // clear old amphoe
            this.form.cities[index].district = '';//clear old district
            this.form.cities[index].districts.splice(0); // clear district array
            this.form.cities[index].amphoes = this.form.cities[index].province.amphoes;
        },
        // -- Get District
        getDistricts: function (index) {
            this.form.cities[index].district = ''; // clear old district
            cityService.getDistricts(this.form.cities[index].amphoe.id)
                .then(result => {
                    vm.form.cities[index].districts = result;
                }).catch(err => {
                alert(err);
            });
        },
        getWaitingLocalPriceResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            axios.get(this.waitingLocalPriceUrl + '?page=' + page)
                .then(result => {
                    vm.waitingLocalPrices = result.data;
                }).catch(err => {
                console.log(err);
            })
        },
        getApprovedLocalPricesResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            axios.get(this.waitingLocalPriceUrl + '?page=' + page)
                .then(result => {
                    vm.waitingLocalPrices = result.data;
                }).catch(err => {
                console.log(err);
            })
        },
        deleteLocalPrice: function (item) {
            console.log('Delete Local Price Item',item);
            if (confirm('ยืนยันการลบ')) {
                materialItemService.deleteLocalPrice(item.approved_price.local_price_id)
                    .then(()=>{
                        this.refreshData();
                        toastr.success('การลบเสร็จสมบูรณ์');
                    }).catch(err=>{alert(err)})
            }
        },
        deleteWaitingGlobalDetails: function (item) {
            let deleteMethod = {
              '_method':'DELETE'
            };
            if (confirm('ยืนยันการลบ')) {
                axios.post('/admin/materials/items/' + item.material_id + '/waiting_global_details/'
                    + item.id,deleteMethod)
                    .then((result) => {
                        console.log(result);
                        this.waitingGlobalDetails = null;
                        this.decreaseWaitingItemNumber(1);
                    }).catch(err => {
                    console.log(err);
                });
            }
        },
        deleteWaitingLocalPrice: function (item) {
            console.log('Delete Waiting Local Price Item :',item);
            if (confirm('ยืนยันการลบ')) {
                materialItemService.deleteWaitingLocalPrice(item.waiting_price.id)
                    .then(()=>{
                        this.refreshData();
                        toastr.success('การลบเสร็จสมบูรณ์')
                    }).catch(err=>{alert(err)})
            }
        },
        deleteMultipleWaitingLocalPrices: function () {
            if (confirm('ยืนยันการลบ')) {
                let items = {
                    'waitingLocalPriceIDs': this.checkedWaitingLocalPrices.map(item => {
                        return item.id
                    }),
                    '_method':'DELETE'
                };
                axios.post('/admin/materials/items/local_price/'
                    + this.material.id + '/waiting_local_prices',items)
                    .then((result) => {
                        this.getWaitingLocalPrices();
                        this.decreaseWaitingItemNumber(1);
                        toastr.success('การลบเสร็จสมบูรณ์');
                    }).catch(err => {
                    console.log(err);
                });
                console.log(items)
            }
        },
        decreaseWaitingItemNumber: function (number) {
            this.waitingItemNumber -= number;
        },
        //Approved Global Details ใช้สำหรับอนุมติรายการ รายละเอียดทั่วไป
        updateGlobalDetailsStatus: function (item) {
            let inputs = {
                'publishedStatus': 'approved',
                'materialID': item.material_id,
                '_method':'PUT'
            };
            if (confirm('ยืนยันการอนุมัติ')) {
                axios.post('/admin/materials/items/update_global_details_status/'
                    + item.id, inputs)
                    .then(result => {
                        console.log(result);
                        this.refreshData();
                        toastr.success('การอนุมัติเสร็จสมบูรณ์');
                        this.waitingGlobalDetails = null;
                        this.decreaseWaitingItemNumber(1);
                    }).catch(err => {
                    console.log(err)
                })
            }
        },
        //ใช้อนุมัติ local price
        updateLocalPriceStatus: function () {
            if (confirm('ยืนยันการอนุมัติ')) {
                let items = {
                    'waitingLocalPriceIDs': this.checkedWaitingLocalPrices.map(item => {
                        return item.id
                    }),
                    'publishedStatus': 'approved',
                    '_method':'PUT'
                };
                axios.post('admin/materials/items/' + this.material.id + '/update_local_price', items)
                    .then((result) => {
                        console.log(result);
                        this.refreshData();
                        toastr.success('การอนุมัติเสร็จสมบูรณ์');
                    }).catch(err => {
                    console.log(err);
                });
            }
        },
        //Update Global Details Value
        updateGlobalDetails: function () {
            console.log('In Global Details', vm.approvedGlobalDetails);
            materialItemService.updateGlobalDetails(vm.approvedGlobalDetails)
                .then(result => {
                    toastr.success('อัพเดทเสร็จสมบูรณ์');
                    this.refreshData();
                    console.log('Updated Global Details')
                }).catch(err => {
                console.log(err)
            })
        }
    },
    watch: {
        'form.materialType': function () {
            this.form.materialTypeID = this.form.materialType.id;
        },
        material: function () {
            console.log('In Watch Material:', this.material);
            let count = 0;
            if (this.material.waiting_global_details) {
                count++;
            }
            this.approvedGlobalDetails = this.material.approved_global_details;
            this.waitingGlobalDetails = this.material.waiting_global_details;
            this.waitingItemNumber = count + this.material.waiting_local_prices.length;
        }
    },
});
console.log('Master',vm);

