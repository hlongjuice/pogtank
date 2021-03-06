import ProjectOrderService from '../../../../assets/js/services/project_order/project_order_service';
import Porlor4ExportService from '../../../../assets/js/services/project_order/porlor_4_export_service';
import Porlor5ExportService from '../../../../assets/js/services/project_order/porlor_5/porlor_5_export_service';
import Porlor6ExportService from '../../../../assets/js/services/project_order/porlor_6/porlor_6_export_service';
import WebUrl from '../../../../assets/js/services/webUrl';
import {ProjectOrderEditModal} from '../project_order_edit';
import {Porlor5Index} from "../porlor_5/porlor_5_index";
import {Porlor6Index} from "../porlor_6/porlor_6_index";
import {ProjectReferee} from "../referee/referee_index";
import {ProjectRefereeAddModal} from "../referee/add_referee/add_referee";
import {ProjectRefereeEditModal} from "../referee/edit_referee/edit_referee";


let webUrl = new WebUrl();
let projectOderService = new ProjectOrderService();
let porlor4ExportService = new Porlor4ExportService();
let porlor5ExportService = new Porlor5ExportService();
let porlor6ExportService = new Porlor6ExportService();
new Vue({
    el: '#project-order-index',
    mixins: [
        ProjectOrderEditModal,
        Porlor5Index,
        Porlor6Index,
        ProjectReferee,
        ProjectRefereeAddModal,
        ProjectRefereeEditModal
    ],
    data: {
        showLoading: '',
        orders: {}
    },
    mounted: function () {
        this.showLoading = true;
        this.initialData();
    },
    methods: {
        initialData() {
            Promise.all([
                //Get All Project Orders
                projectOderService.getAllProjectOrders()
                    .then(result => {
                        this.orders = result;
                    }).catch(err => {
                    alert(err)
                })
            ]).then(() => {
                this.showLoading = false;
            })
                .catch()
        },
        getSelectedProductPage() {

        },
        //Open Porlor 4
        openPorlor4Page(order) {
            window.location = webUrl.getRoute('/admin/project_order/' + order.id + '/porlor_4');
        },
        //Open Project Order Edit Modal
        openProjectOrderEditModal(order) {
            this.$modal.show('project-order-edit-modal', {
                order: order
            })
        },
        //Open Porlor 5
        openPorlor5Modal(order){
          this.$modal.show('porlor-5-modal',{
              order:order
          })
        }, //Open Porlor 6
        openPorlor6Modal(order){
          this.$modal.show('porlor-6-modal',{
              order:order
          })
        },
        //Open Project Referee
        openProjectReferee(order){
          this.$modal.show('project-referee-modal',{
              order:order
          })
        },
        getAllProjectOrder() {
            projectOderService.getAllProjectOrders()
                .then(result => {
                    if (this.showLoading === true) {
                        this.showLoading = false;
                    }
                    this.orders = result;
                }).catch(err => {
                alert(err)
            })
        },
        beforeCloseProjectOrderEditModal(data) {
            if (data.params.is_updated) {
                this.getAllProjectOrder();
            }
        },
        //Before Close Porlor 5
        beforeClosePorlor5Modal(){

        },  //Before Close Porlor 6
        beforeClosePorlor6Modal(){

        },
        //Before Close Project Referee Modal
        beforeCloseProjectRefereeModal(){

        },
        //Delete Project
        deleteProject(order) {
            this.$dialog.confirm('ยืนยันการลบ')
                .then(() => {
                    this.showLoading = true;
                    projectOderService.deleteProject(order.id)
                        .then(result => {
                            this.getAllProjectOrder();
                        }).catch(err => {
                        alert(err)
                    })
                })
                .catch();
        },
        //Export Porlor 4
        exportPorlor4Excel(order_id){
            porlor4ExportService.exportExcelByProjectOrderID(order_id);
        },
        //Export Porlor 5
        exportPorlor5Excel(order_id){
            porlor5ExportService.exportExcel(order_id);
        },
        //Export Porlor 6
        exportPorlor6Excel(order_id){
            porlor6ExportService.exportExcel(order_id);
        }

    }
});