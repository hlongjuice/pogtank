import RefereeRankService from '../../../../../assets/js/services/referee/referee_rank_service';
import ProjectRefereeService from '../../../../../assets/js/services/project_order/project_referee_service';
let projectRefereeService = new ProjectRefereeService();
let refereeRankService = new RefereeRankService();
export const ProjectRefereeAddModal = {
    data() {
        return {
            project_referee_add: {
                is_loading: false,
                is_added: false,
                ranks:'',
                project_order: '',
                form:{
                    new_referees: []
                }
            }
        }
    },
    methods: {
        beforeOpenProjectRefereeAddModal(data) {
            this.projectRefereeAdd_resetData();
            this.project_referee_add.project_order = data.params.order;
            console.log('Before Open Project Referee Add Data :',this.project_referee_add);
        },
        openedProjectRefereeAddModal() {
            this.project_referee_add.is_loading=true;
            //Clear Data
            Promise.all([
                //Get Referee Ranks
                this.projectRefereeAdd_getRefereeRanks()
            ]).then(()=>{
                this.project_referee_add.is_loading=false;
            }).catch(()=>{
                this.project_referee_add.is_loading=false;
            })
        },
        closeProjectRefereeAddModal() {
            this.$modal.hide('project-referee-add-modal',{
                is_added:this.project_referee_add.is_added
            })
        },
        //Project Referee Add Modal
        //Reset Data
        projectRefereeAdd_resetData() {
            this.project_referee_add = {
                is_loading: false,
                is_added: false,
                ranks:[],
                project_order: '',
                form:{
                    new_referees: [
                        {
                            project_order_id:'',
                            name:'',
                            rank:''
                        }
                    ]
                }
            }
        },
        //Add New Referees to Database
        projectRefereeAdd_addReferees(scope, event) {
            this.project_referee_add.is_loading = true;
            this.$validator.validateAll(scope)
                .then(result => {
                    if (result) {
                        projectRefereeService.addReferees(this.project_referee_add.project_order.id, this.project_referee_add.form)
                            .then(result => {
                                this.project_referee_add.is_added=true;
                                this.closeProjectRefereeAddModal();
                            }).catch(err => {
                            alert(err)
                        })
                    }
                });
        },
        //Add Referee Input
        projectRefereeAdd_addRefereeInput(){
            let new_referee_input = {
                    project_order_id:'',
                    prefix:'',
                    name:'',
                    rank:''
                };
            this.project_referee_add.form.new_referees.push(new_referee_input);
        },
        //Get Referee Ranks
        projectRefereeAdd_getRefereeRanks(){
          refereeRankService.getRefereeRanks()
              .then(result=>{
                    this.project_referee_add.ranks = result;
                    console.log('Referee Ranks are :',result);
              }).catch(err=>{
                  alert(err);
          })
        },
        //Remove Referee Input
        projectRefereeAdd_removeRefereeInput(index){
            this.project_referee_add.form.new_referees.splice(index,1);
        }
    }
};