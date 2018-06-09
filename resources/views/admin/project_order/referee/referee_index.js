import ProjectRefereeService from '../../../../assets/js/services/project_order/project_referee_service';
let projectRefereeService = new ProjectRefereeService();
export const ProjectReferee = {
    data() {
        return {
            project_referee: {
                is_loading: false,
                is_scrollable: true,
                project_order: '',
                referees: [],
                select_all_referees:false,
                form:{
                    selected_referees:[]
                }
            }
        }
    },
    methods: {
        beforeOpenProjectRefereeModal(data) {
            this.projectReferee_resetData();
            this.project_referee.project_order = data.params.order;
        },
        openedProjectRefereeModal() {
            this.project_referee.is_loading = true;
            Promise.all([
                this.projectReferee_getReferees()
            ]).then(() => {
                setTimeout(()=>{
                    this.project_referee.is_loading = false;
                },300)
            }).catch(err => {
                alert(err);
                this.project_referee.is_loading = false;
            });
        },
        beforeCloseProjectRefereeAddModal(data) {
            console.log('Before Close Project Referee Add Modal Data :',data);
            this.project_referee.is_scrollable = true;
            if(data.params.is_added){
                this.projectReferee_getReferees();
            }
        },
        beforeCloseProjectRefereeEditModal(data) {
            this.project_referee.is_scrollable = true;
            if(data.params.is_updated){
                this.projectReferee_getReferees();
            }
        },
        closeProjectRefereeModal() {
            this.$modal.hide('project-referee-modal')
        },
        openProjectRefereeAddModal() {
            this.project_referee.is_scrollable = false;
            this.$modal.show('project-referee-add-modal', {
                order: this.project_referee.project_order
            })
        },
        openProjectRefereeEditModal(referee) {
            this.project_referee.is_scrollable=false;
            this.$modal.show('project-referee-edit-modal',{
                order:this.project_referee.project_order,
                referee:referee
            },{draggable: true})
        },
        //Project Referee Methods
        //-- Add New Referee
        //-- Get Porlor Items
        projectReferee_getReferees() {
            console.log('Get Referees');
            this.project_referee.is_loading = true;
            projectRefereeService.getReferees(this.project_referee.project_order.id)
                .then(result => {
                    console.log(result);
                    this.project_referee.referees=result;
                    this.project_referee.is_loading = false;
                })
                .catch(err => {
                    alert(err);
                    this.project_referee.is_loading = false;
                })
        },
        //-- Delete Referee
        projectReferee_deleteReferee(referee) {
            this.project_referee.form.selected_referees.splice(0);
            this.project_referee.select_all_referees=false;
            this.project_referee.form.selected_referees.push(referee);
            this.projectReferee_deleteMultipleReferees();

        },
        //-- Delete Multiple Referees
        projectReferee_deleteMultipleReferees(){
            let referee_names = this.project_referee.form.selected_referees.map(referee=>{
                return referee.name;
            }).join("<br />");
            this.$dialog.confirm('ยืนยันการลบรายการ <br>' +
                ''+referee_names)
                .then(()=>{
                    projectRefereeService.deleteReferees(this.project_referee.project_order.id,this.project_referee.form)
                        .then(result=>{
                            this.projectReferee_resetData();
                            this.projectReferee_getReferees();
                        }).catch(err=>{
                        alert(err)
                    })
                })
                .catch();
        },
        projectReferee_resetData() {
            console.log('Reset Referee Data');
            this.project_referee.is_loading=false;
            this.project_referee.is_scrollable=true;
            this.project_referee.select_all_referees=false;
            this.project_referee.referees=[];
        },
        projectReferee_selectAllReferees(){
            this.project_referee.form.selected_referees.splice(0);
            if(this.project_referee.select_all_referees){
                this.project_referee.referees.forEach(referee=>{
                    this.project_referee.form.selected_referees.push(referee)
                })
            }

        }
    }
};