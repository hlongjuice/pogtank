import Porlor5Service from '../../../../assets/js/services/project_order/porlor_5/porlor_5_service';

let porlor5Service = new Porlor5Service();
export const Porlor5Index = {
    data(){
        return {
            porlor5:{
                is_loading:false,
                parts :'',
                project:'',
                project_order:''
            }

        }
    },
    methods:{
        beforeOpenPorlor5Modal(data){
            this.porlor5.project_order = data.params.order;

        },
        openedPorlor5Modal(){
            this.porlor5.is_loading=true;
            Promise.all([
                porlor5Service.getPorlor5(this.porlor5.project_order.id)
                    .then(result=>{
                        console.log(result);
                        this.porlor5.project = result;
                    }).catch(err=>{
                    alert(err)
                })
            ]).then(()=>{
                this.porlor5.is_loading=false;
            }).catch(err=>{alert(err)});
        },
        closePorlor5Modal(){
            this.$modal.hide('porlor-5-modal')
        }
    }
};