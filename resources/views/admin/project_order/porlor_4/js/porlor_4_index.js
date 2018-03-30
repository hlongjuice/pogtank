import Porlor4Service from '../../../../../assets/js/services/project_order/porlor_4_service';
import {AddNewPartModal} from "./add_part_modal";
import WebUrl from '../../../../../assets/js/services/webUrl';
let webUrl = new WebUrl();
let porlor4Service = new Porlor4Service();
new Vue({
    el:'#porlor-4-index',
    mixins:[AddNewPartModal],
    data:{
        addNewPartStatus:false,
        order_id:orderID,
        showLoading:'',
        project_porlor_4_parts:[],
        project_details:{}
    },
    mounted:function(){
        this.showLoading=true;
        this.initialData();
    },
    methods:{
        initialData(){
            console.log('InitialData Method');
            Promise.all([
                //Project Details
                porlor4Service.getProjectDetails(this.order_id)
                    .then(result=>{
                        this.project_details=result;
                    }).catch(err=>{alert(err)}),
                //Order Parts
                porlor4Service.getAllParts(this.order_id)
                    .then(result=>{
                        console.log('Project Porlor 4 Part :',result);
                        this.project_porlor_4_parts=result;
                    }).catch(err=>{alert(err)})
            ]).then(()=>{
                this.showLoading=false;
            }).catch(err=>{
                alert(err)
            })
        },
        //Refresh Data
        refreshData(){
            console.log('RefreshData method');
            this.showLoading=true;
            this.addNewPartStatus=false;
            //Order Parts
            porlor4Service.getAllParts(this.order_id)
                .then(result=>{
                    this.project_porlor_4_parts=result;
                    this.showLoading=false;
                }).catch(err=>{
                    alert(err);
                    this.showLoading=false;
                })
        },
        //Open Jobs
        openPorlor4JobsPage(id){
            console.log('Porlor 4 ID :',id);
            window.location=webUrl.getRoute('/admin/project_order/porlor_4_id/'+id+'/jobs');
        },
        showAddNewPartModal(){
            // this.addNewPartStatus=false,
            console.log('Show Add New Part Modal');
            this.$modal.show('porlor-4-add-new-part-modal')
        },
        //Before Close Add New Part Modal
        beforeCloseAddNewPartModal(){
            if(this.addNewPartStatus){
                console.log('Refresh');
                this.refreshData();
            }
        },
        closeAddNewPartModal(){
            this.$modal.hide('porlor-4-add-new-part-modal')
        }
    }
});