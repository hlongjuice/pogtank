import ProjectRefereeService from '../../../../assets/js/services/project_order/project_referee_service';
let projectRefereeService = new ProjectRefereeService();
export const ProjectReferee = {
    data() {
        return {
            project_referee: {
                is_loading: false,
                is_scrollable: true,
                project_order: '',
                referees: '',
                form:{
                    selected_items:[]
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
        beforeCloseProjectRefereeEditModal() {
            this.project_referee.is_scrollable = true;
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
        openProjectRefereeEditModal() {

        },
        //Project Referee Methods
        //-- Add New Referee
        //-- Get Porlor Items
        projectReferee_getReferees() {
            projectRefereeService.getReferees(this.project_referee.project_order.id)
                .then(result => {
                    console.log(result);
                    this.project_referee.referees = result;
                    this.project_referee.is_loading = false;
                })
                .catch(err => {
                    alert(err);
                    this.project_referee.is_loading = false;
                })
        },
        //-- Edit Referee Modal
        projectReferee_editRefereeModal(referee) {
            this.$modal.show('project-referee-edit-modal', {
                referee: referee
            })
        },
        //-- Delete Referee
        projectReferee_deleteReferee(referee) {

        },
        projectReferee_resetData() {
            this.project_referee = {
                is_loading: false,
                is_scrollable: true,
                project_order: '',
                referees: ''
            }
        }
    }
};