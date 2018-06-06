import Porlor6Service from '../../../../assets/js/services/project_order/porlor_6/porlor_6_service';

let porlor6Service = new Porlor6Service();
export const Porlor6Index = {
    data() {
        return {
            porlor6: {
                is_loading: false,
                project: '',
                project_order: ''
            }

        }
    },
    methods: {
        beforeOpenPorlor6Modal(data) {
            this.porlor6.project_order = data.params.order;

        },
        openedPorlor6Modal() {
            this.porlor6.is_loading = true;
            Promise.all([
                this.porlor6_getPorlor6()
            ]).then(() => {
                this.porlor6.is_loading = false;
            }).catch(err => {
                alert(err)
            });
        },
        closePorlor6Modal() {
            this.$modal.hide('porlor-6-modal')
        },
        //porlor6
        //-- Get Porlor Items
        porlor6_getPorlor6() {
            porlor6Service.getPorlor6(this.porlor6.project_order.id)
                .then(result => {
                    console.log('Porlor 6 : ',result);
                    this.porlor6.project = result;
                    this.porlor6.is_loading = false;
                }).catch(err => {
                alert(err)
                this.porlor6.is_loading = false;
            })
        }
    }
};