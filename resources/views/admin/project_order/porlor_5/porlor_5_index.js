import Porlor5Service from '../../../../assets/js/services/project_order/porlor_5/porlor_5_service';

let porlor5Service = new Porlor5Service();
export const Porlor5Index = {
    data() {
        return {
            porlor5: {
                is_loading: false,
                parts: '',
                project: '',
                project_order: ''
            }

        }
    },
    methods: {
        beforeOpenPorlor5Modal(data) {
            this.porlor5.project_order = data.params.order;

        },
        openedPorlor5Modal() {
            this.porlor5.is_loading = true;
            Promise.all([
                this.porlor5_getPorlor5()
            ]).then(() => {
                this.porlor5.is_loading = false;
            }).catch(err => {
                alert(err)
            });
        },
        closePorlor5Modal() {
            this.$modal.hide('porlor-5-modal')
        },
        //porlor5
        //-- Get Porlor Items
        porlor5_getPorlor5() {
            porlor5Service.getPorlor5(this.porlor5.project_order.id)
                .then(result => {
                    console.log(result);
                    this.porlor5.project = result;
                    this.porlor5.is_loading = false;
                }).catch(err => {
                alert(err)
                this.porlor5.is_loading = false;
            })
        },
        //-- move to Previous Page
        porlor5_moveToPreviousPage(porlor4) {
            this.porlor5.is_loading = true;
            porlor5Service.moveToPreviousPage(porlor4.project_order_id, porlor4.id)
                .then(result => {
                    this.porlor5_getPorlor5();
                }).catch(err => {
                    alert(err);
                    this.porlor5.is_loading = false;
                })
        },
        //-- Move to next Page
        porlor5_moveToNextPage(porlor4) {
            this.porlor5.is_loading = true;
            porlor5Service.moveToNextPage(porlor4.project_order_id, porlor4.id)
                .then(result => {
                    this.porlor5_getPorlor5();
                }).catch(err => {
                    alert(err);
                    this.porlor5.is_loading = false;
                })
        }
    }
};