import Porlor5Service from '../../../../assets/js/services/project_order/porlor_5/porlor_5_service';
let porlor5Service = new Porlor5Service();
export const Porlor5Index = {
    data(){
        return {
            porlor_5:{
                project_order :''
            }

        }
    },
    methods:{
        beforeOpenPorlor5Modal(data){
            this.porlor_5.project_order = data.params.order;
            porlor5Service.getPorlor5(this.porlor_5.project_order.id)
                .then(result=>{
                    console.log(result)
                }).catch(err=>{
                    alert(err)
            })
        },
        closePorlor5Modal(){
            this.$modal.hide('porlor-5-modal')
        }
    }
};