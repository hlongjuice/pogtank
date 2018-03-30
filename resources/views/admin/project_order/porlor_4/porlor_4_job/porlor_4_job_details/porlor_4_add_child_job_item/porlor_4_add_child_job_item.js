import MaterialTypeService from '../../../../../../../assets/js/services/material/material_type_service';
import MaterialItemService from '../../../../../../../assets/js/services/material/material_item_service';
import Porlor4JobService from '../../../../../../../assets/js/services/project_order/porlor_4_job_service';
let porlor4JobService = new Porlor4JobService();
let materialItemService = new MaterialItemService();
let materialTypeService = new MaterialTypeService();
export const Porlor4AddChildJobItem = {
    data(){
        return {
            add_child_job_item:{
                isLoading:false,
                leaf_jobs:[],
                material_types:[],
                material_items:[],
                form:{
                    parent:'',
                    material_type:'',
                    material_item:'',
                    material_name:''
                }
            }
        }
    },
    methods:{
        beforeOpenAddChildJobItemModal(event){
            this.addChildJobItemResetData();
            console.log('Add Child Job Item Event :',event);
            Promise.all([
                //Get Material Types
                materialTypeService.getMaterialTypeTree()
                    .then(result=>{
                        this.add_child_job_item.material_types = result;
                        console.log('Material Types : ',this.materialTypes);
                    }).catch(err=>{alert(err)}),
                //Get All Leaf Jobs
                porlor4JobService.getAllLeafJobs(this.porlor4.id,this.root_job.id)
                    .then(result=>{
                        this.add_child_job_item.leaf_jobs=result;
                        console.log('Leaf Jobs :',this.add_child_job_item.leaf_jobs);
                    })

            ]).then()
                .catch();
        },
        addChildJobItemResetData(){
            this.add_child_job_item={
                isLoading:false,
                    leaf_jobs:[],
                    material_types:[],
                    material_items:[],
                    form:{
                    parent:'',
                        material_type:'',
                        material_item:'',
                        material_name:''
                }
            }
        },
        closeAddChildJobItemModal(){
            this.$modal.hide('porlor-4-add-child-job-item-modal')
        },
        getMaterialTypes(){

        },
        //Get Items OF Type
        getMaterialItemsOfType(){
          materialItemService.getItemsOfType(this.add_child_job_item.form.material_type.id)
              .then(result=>{
                  console.log('Material Item :',result);
                  this.add_child_job_item.material_items=result;
              }).catch(err=>{alert(err)})
        },
        //Search Item Of Type By name
        searchMaterialItemsOfType(search_name){
            this.add_child_job_item.isLoading=true;
            materialItemService.searchItemsOfTypeByName(this.add_child_job_item.form.material_type.id,search_name)
                .then(result=>{
                    console.log('Search Material Items :',result);
                   this.add_child_job_item.material_items=result;
                   this.add_child_job_item.isLoading=false;
                }).catch(err=>{alert(err)})
        },
        childJobCustomLabel(item){
            return item.job_order_number+' '+ item.name;
        },
        materialItemCustomLabel(item){
            console.log('Material Item Custom Label',item);
            if(item.approved_global_details){
                return item.approved_global_details.name;
            }
        }
    }
};