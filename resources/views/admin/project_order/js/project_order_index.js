import ProjectOrderService from '../../../../assets/js/services/project_order/project_order_service';
import WebUrl from '../../../../assets/js/services/webUrl';
import {ProjectOrderEditModal} from '../project_order_edit';
let webUrl=new WebUrl();
let projectOderService = new ProjectOrderService();
new Vue({
    el:'#project-order-index',
    mixins:[
      ProjectOrderEditModal
    ],
    data:{
        showLoading:'',
        orders:{}
    },
    mounted:function(){
        this.showLoading=true;
        this.initialData();
    },
    methods:{
        initialData(){
            Promise.all([
                //Get All Project Orders
                projectOderService.getAllProjectOrders()
                    .then(result=>{
                        this.orders=result;
                    }).catch(err=>{alert(err)})
            ]).then(()=>{
                this.showLoading=false;
            })
                .catch()
        },
        getSelectedProductPage(){

        },
        //Open Porlor 4
        openPorlor4Page(order){
            window.location=webUrl.getRoute('/admin/project_order/'+order.id+'/porlor_4');
        },
        //Open Project Order Edit Modal
        openProjectOrderEditModal(order){
          this.$modal.show('project-order-edit-modal',{
              // order:order
             order:order
          })
        },
        getAllProjectOrder(){
            projectOderService.getAllProjectOrders()
                .then(result=>{
                    this.orders=result;
                }).catch(err=>{alert(err)})
        },
        beforeCloseProjectOrderEditModal(data){
            if(data.params.is_updated){
                this.getAllProjectOrder();
            }
        },
        //Delete Project
        deleteProject(order){
            this.$dialog.confirm('ยืนยันการลบ')
                .then(()=>{
                    projectOderService.deleteProject(order.id)
                        .then(result=>{
                            this.getAllProjectOrder();
                        }).catch(err=>{
                        alert(err)
                    })
                })
                .catch();
        }

    }
});