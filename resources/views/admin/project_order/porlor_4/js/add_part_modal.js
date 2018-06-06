import Porlor4PartService from '../../../../../assets/js/services/project_order/porlor_4_part_service';
import Porlor4Service from '../../../../../assets/js/services/project_order/porlor_4_service';
let porlor4Service = new Porlor4Service();
let porlor4PartService = new Porlor4PartService();
export const AddNewPartModal={
    data:function(){
        return {
            parts:[],
            form:{
                part:''
            }
        }
    },
    methods:{

        beforeOpenAddNewPartModal(){
            this.addNewPartStatus=false;
            this.form={
              part:''
            };
            this.showLoading=true;
            // porlor4PartService.getAll()
            //     .then(result=>{
            //         console.log('Get All Part :',result);
            //        this.parts=result.filter(part=>{
            //             let project_porlor_4_part= this.project_porlor_4_parts.find(item=>{
            //               return item.part_id === part.id;
            //            });
            //             // If already exist part return 0
            //             if(project_porlor_4_part){
            //                 return 0; // หมายถึงมีการใช้งาน part นี้แล้ว
            //             }else{
            //                 return 1; // หาก project porlor 4 part เป็น null คือ part นี้ยังไม่ได้ใช้งาน
            //             }
            //         });
            //         console.log('This part After filter :',this.parts);
            //         // this.parts=result;
            //         this.showLoading=false;
            //     }).catch(err=>{alert(err)});
            porlor4PartService.getAvailableParts(this.project_details.id)
                .then(result=>{
                    this.parts=result;
                    this.showLoading=false;
                    console.log('Available Parts are :',result)
                }).catch(err=>{
                    alert(err);
                this.showLoading=false;
                })
        },
        //Add Part
        addPart(){
            porlor4Service.addNewPart(this.order_id,this.form)
                .then(result=>{
                    this.addNewPartStatus=true;
                    this.closeAddNewPartModal();
                }).catch(err=>{
                    alert(err)
            })
        }
    }
};