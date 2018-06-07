import ProjectOrderService from '../../../../assets/js/services/project_order/project_order_service';
import RefereeService from '../../../../assets/js/services/referee/referee_service';

let projectOrderService = new ProjectOrderService();
let refereeService = new RefereeService();
export const Porlor5Index = {
    data() {
        return {
            project_referee: {
                is_loading: false,
                project_order: '',
                referees: ''
            }

        }
    },
    methods: {
        beforeOpenPorlor5Modal(data) {
            this.project_referee.project_order = data.params.order;
        },
        openedPorlor5Modal() {
            this.project_referee.is_loading = true;
            Promise.all([
                this.projectReferee_getReferees()
            ]).then(() => {
                this.project_referee.is_loading = false;
            }).catch(err => {
                alert(err)
            });
        },
        closeProjectRefereeModal() {
            this.$modal.hide('project-referee-modal')
        },
        //Project Referee Methods
        //-- Get Porlor Items
        projectReferee_getReferees() {
            projectOrderService.getReferees(this.project_referee.project_order.id)
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
        projectReferee_editRefereeModal(referee){
            this.$modal.show('project-referee-edit-modal',{
                referee:referee
            })
        },
        //-- Delete Referee
        projectReferee_deleteReferee(referee){
            
        }
    }
};