import Porlor4PartService from '../../../../assets/js/services/project_order/porlor_4_part_service';
import {AddNewPartModal} from "./porlor_4_part_add_new_part_modal";
let porlor4PartService = new Porlor4PartService();
new Vue({
    el: '#porlor-4-part-index',
    mixins:[AddNewPartModal],
    data: {
        addNewPartStatus:false,
        showLoading: '',
        parts: []
    },
    mounted: function () {
        this.showLoading = true;
        this.initialData();
    },
    methods: {
        initialData() {
            porlor4PartService.getAll()
                .then(result => {
                    this.parts = result;
                    this.showLoading=false;
                }).catch(err=>{
                    alert(err);
                    this.showLoading=false;
                })
        },
        refreshData(){
            this.addNewPartStatus=false;
            this.showLoading=true;
            porlor4PartService.getAll()
                .then(result => {
                    this.parts = result;
                    this.showLoading=false;
                }).catch(err=>{
                alert(err);
                this.showLoading=false;
            })
        },
        showAddNewPartModal(){
            this.$modal.show('porlor-4-part-add-new-part-modal');
        },
        beforeCloseAddNewPartModal(){
            if(this.addNewPartStatus){
                this.refreshData();
            }
        }

    }
});