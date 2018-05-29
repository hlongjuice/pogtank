import WebUrlService  from '../../../../assets/js/services/webUrl';
import MaterialItemService from '../../../../assets/js/services/material/material_item_service';
let materialItemService = new MaterialItemService();
let webUrlService = new WebUrlService();
new Vue({
   el:'material-item-index',
   data:{
       approvedItems:'',
       waitingItems:'',
       is_loading:false
   },
    mounted(){

    },
    methods:{
        initialData(){
            this.is_loading=true;
            Promise.all([
                this.getItems(),
                this.getWaitingItems()
            ]).then(()=>{
                this.is_loading=false;
            })
                .catch(err=>{
                    alert(err)
                    this.is_loading=false;
                });
        },
        getApprovedItems(){
            materialItemService.getItems()
                .then(result=>{
                    this.approvedItems=result;
                })
                .catch(err=>{alert(err)})
        },
        getWaitingItems(){
            materialItemService.getWaitingItems()
                .then(result=>{
                    this.waitingItems =result;
                }).catch(err=>{alert(err)})
        }
    }
});