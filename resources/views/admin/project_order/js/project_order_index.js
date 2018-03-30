import ProjectOrderService from '../../../../assets/js/services/project_order/project_order_service';
import WebUrl from '../../../../assets/js/services/webUrl';
let webUrl=new WebUrl();
let projectOderService = new ProjectOrderService();
new Vue({
    el:'#project-order-index',
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
        }
    }
});