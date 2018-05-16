import Porlor4Service from '../../../../../assets/js/services/project_order/porlor_4_service';
import {AddNewPartModal} from "./add_part_modal";
import WebUrl from '../../../../../assets/js/services/webUrl';
import {EditPartModal} from "../edit_part_modal";

let webUrl = new WebUrl();
let porlor4Service = new Porlor4Service();
new Vue({
    el:'#porlor-4-index',
    mixins:[
        AddNewPartModal,
        EditPartModal
    ],
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
                    }).catch(err=>{

                    }),
                //Order Parts
                porlor4Service.getAllParts(this.order_id)
                    .then(result=>{
                        console.log('Project Porlor 4 Part :',result);
                        this.project_porlor_4_parts=result;
                    }).catch(err=>{
                    })
            ]).then(()=>{
                this.showLoading=false;
            }).catch(err=>{
                this.$dialog.confirm('การโหลดข้อมูลผิดพลาด ลองใหม่อีกครั้ง')
                    .then(()=>{
                        location.reload();
                    }).catch(()=>{

                })
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
        //Porlor 4 Delete Part
        porlor4_deletePart(item){
            this.$dialog.confirm('' +
                '<p>ยืนยันการลบ</p>' +
                '<h4 class="text-danger">'+item.part.name+'</h4>' +
                '<p>**การลบนี้จะลบงานย่อยทั้งหมดในหมวดหมู่ </p>'
            )
                .then(()=>{
                    this.showLoading=true;
                    porlor4Service.deletePart(item.id)
                        .then(result=>{
                            this.showLoading=false;
                            this.refreshData();
                        }).catch(err=>{alert(err)})
                })
                .catch();
        },
        //Open Jobs
        openPorlor4JobsPage(id){
            console.log('Porlor 4 ID :',id);
            window.location=webUrl.getRoute('/admin/project_order/porlor_4_id/'+id+'/jobs');
        },
        //Open Edit Part
        openEditPartModal(item){
            this.$modal.show('porlor-4-edit-part-modal',{
                item:item
            })
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
        },
        beforeCloseEditPartModal(data){
            if(data.params.is_updated){
                this.refreshData();
            }
        }
    }
});