import WebUrlService from '../../../../assets/js/services/webUrl';
import MaterialItemService from '../../../../assets/js/services/material/material_item_service';

let materialItemService = new MaterialItemService();
let webUrlService = new WebUrlService();
new Vue({
    el: '#material-item-index',
    data: {
        approvedItems: '',
        waitingItems: '',
        selected_items: {
            approved_items: [],
            waiting_items: []
        },
        chk_all_approved_items: false,
        chk_all_waiting_items:false,
        is_loading: false
    },
    mounted() {
        this.initialData();
    },
    methods: {
        initialData() {
            this.is_loading = true;
            Promise.all([
                this.getApprovedItems(),
                this.getWaitingItems()
            ]).then(() => {
                setTimeout(()=>{
                    this.is_loading = false;
                },500)
            })
                .catch(err => {
                    alert(err);
                    this.is_loading = false;
                });
        },
        getApprovedItems(page) {
            //clear All Select Approved Items
            this.selected_items.approved_items.splice(0);
            this.chk_all_approved_items=false;
            if(page==null){
                page=1;
            }
            materialItemService.getApprovedItemsByPage(page)
                .then(result => {
                    this.approvedItems = result;
                    console.log('Get Items By Page Results :', result)
                })
                .catch(err => {
                    alert(err)
                })
        },
        getWaitingItems() {
            materialItemService.getWaitingItems()
                .then(result => {
                    this.waitingItems = result;
                }).catch(err => {
                alert(err)
            })
        },
        openMaterialItemEdit(item_id) {
            this.is_loading = true;
            console.log('Window Location :', window.location);
            console.log('Get Route :', webUrlService.getRoute('/edit/'));
            window.location = webUrlService.getRoute('/admin/materials/items/edit/' + item_id);
        },
        //Select All Approved Items
        selectAllApprovedItems() {
            this.selected_items.approved_items.splice(0);
            console.log('Select All', this.chk_all_approved_items);
            if (this.chk_all_approved_items) {
                this.approvedItems.data.forEach(item => {
                    this.selected_items.approved_items.push(item)
                })
            }
            console.log('Select All 2 :', this.chk_all_approved_items)
        },
        //Select All Waiting Items
        selectAllWaitingItems() {
            this.selected_items.waiting_items.splice(0);
            if (this.chk_all_waiting_items) {
                this.waitingItems.forEach(item => {
                    this.selected_items.waiting_items.push(item.id)
                })
            }
        },
        deleteSingleApprovedItem(item) {
            this.selected_items.approved_items.splice(0);
            this.selected_items.approved_items.push(item);
            this.deleteApprovedItems();
        },
        deleteApprovedItems() {
            if (this.selected_items.approved_items.length === 0) {
                alert('กรุณาเลือกรายการที่ต้องการลบ')
            } else {
                let item_names = this.selected_items.approved_items.map(item=>{
                   return item.approved_global_details.name;
                }).join("<br />");
                console.log('Items Names : ',item_names);
                this.$dialog.confirm('ยืนยันการลบรายการ <br>' +
                    ''+item_names+
                    '' +
                    '')
                    .then(() => {
                        this.is_loading=true;
                        materialItemService.deleteApprovedItem(this.selected_items)
                            .then(result => {
                                this.selected_items.approved_items.splice(0);
                                this.chk_all_approved_items=false;
                                this.initialData();
                            }).catch(err => {
                            alert(err)
                        })
                    })
                    .catch()
            }
        },
        deleteSingleWaitingItem(item){
            this.selected_items.waiting_items.splice(0);
            this.selected_items.waiting_items.push(item.id);
            this.deleteWaitingItems();
        },
        deleteWaitingItems(){
            if (this.selected_items.approved_items.length === 0) {
                alert('กรุณาเลือกรายการที่ต้องการลบ')
            } else {
                this.$dialog.confirm('ยืนยันการลบ')
                    .then(() => {
                        this.is_loading=true;
                        materialItemService.deleteWaitingItem(this.selected_items)
                            .then(result => {
                                this.selected_items.approved_items.splice(0);
                                this.initialData();
                            }).catch(err => {
                            alert(err)
                        })
                    })
                    .catch()
            }
        }
    }
});