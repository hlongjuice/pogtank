import RefereeRankService from '../../../../../assets/js/services/referee/referee_rank_service';
import ProjectRefereeService from '../../../../../assets/js/services/project_order/project_referee_service';

let projectRefereeService = new ProjectRefereeService();
let refereeRankService = new RefereeRankService();
export const ProjectRefereeEditModal = {
    data() {
        return {
            project_referee_edit: {
                is_loading: false,
                is_updated: false,
                ranks: '',
                project_order: '',
                form: {
                    referee: ''
                }
            }
        }
    },
    methods: {
        beforeOpenProjectRefereeEditModal(data) {
            console.log('Edit Modal Params:',data);
            this.projectRefereeEdit_resetData();
            this.project_referee_edit.project_order = data.params.order;
            this.project_referee_edit.form.referee = data.params.referee;
            console.log('Before Open Project Referee Edit Data :', this.project_referee_edit);
        },
        openedProjectRefereeEditModal() {
            this.project_referee_edit.is_loading = true;
            //Clear Data
            Promise.all([
                //Get Referee Ranks
                this.projectRefereeEdit_getRefereeRanks()
            ]).then(() => {
                this.project_referee_edit.is_loading = false;
            }).catch(() => {
                this.project_referee_edit.is_loading = false;
            })
        },
        closeProjectRefereeEditModal() {
            this.$modal.hide('project-referee-edit-modal', {
                is_updated: this.project_referee_edit.is_updated
            })
        },
        //Project Referee Add Modal
        //Get Referee Ranks
        projectRefereeEdit_getRefereeRanks() {
            refereeRankService.getRefereeRanks()
                .then(result => {
                    this.project_referee_edit.ranks = result;
                    console.log('Referee Ranks are :', result);
                }).catch(err => {
                alert(err);
            })
        },
        //Reset Data
        projectRefereeEdit_resetData() {
            this.project_referee_edit.is_loading = false;
            this.project_referee_edit.is_updated = false;
            this.project_referee_edit.form.referee = '';
        },
        //Update Referee
        projectRefereeEdit_updateReferee(scope,event) {
            this.$validator.validateAll(scope)
                .then(result => {
                    if (result) {
                        this.project_referee_edit.is_loading = true;
                        projectRefereeService.updateReferee(this.project_referee_edit.project_order.id, this.project_referee_edit.form)
                            .then(result => {
                                this.project_referee_edit.is_updated = true;
                                this.closeProjectRefereeEditModal();
                            })
                            .catch(err => {
                                alert(err);
                                this.project_referee_edit.is_loading=false;
                            })
                    }
                })
        }
    }
};