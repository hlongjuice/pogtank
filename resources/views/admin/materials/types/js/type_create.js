import MaterialType from '../../../../../assets/js/services/material/material_type_service'
import WebUrl from '../../../../../assets/js/services/webUrl';
//Custom Error Message
const dict = {
    custom: {
        typeName: {required: 'ชื่อหมวดหมู่'},
        parentTypeID: {required: 'ลำดับหมวดหมู่'},
        codePrefix: {required: 'รหัสหมวดหมู่'}
    }
};
let webUrl=new WebUrl();
let indexRoute= webUrl.getRoute('/admin/materials/types/submitted');
let materialTypes = new MaterialType();
let vm = new Vue({
    el: '#material-type-create',
    //Created
    created: function () {
        this.$validator.localize('en', dict);
    },
    //Data
    data: {
        showLoading: '',
        parentTypes: [],
        form: {
            typeName: '',
            parentType: {
                id: 0,
                name: 'หมวดหมู่หลัก'
            },
            details: '',
            codePrefix: '',
            parentTypeID: 0
        }
    },
    //End Data
    mounted: function () {
        this.showLoading = true;
        materialTypes.getMaterialParentTypes()
            .then(result => {
                vm.parentTypes = result;
                this.showLoading = false;
            }).catch(err => {
            console.log(err);
            this.showLoading = false;
        })
    },
    //Method
    methods: {
        validateForm: function (scope, ev) {
            this.$validator.validateAll(scope)
                .then(result => {
                    if (result) {
                        axios.post('/admin/materials/types', vm.form)
                            .then(result => {
                                window.location = indexRoute;
                            }).catch(err => {
                            alert("ไม่สามารถเพิ่มข้อมูลได้ลองใหม่อีกครั้ง");
                            console.log(err);
                        })
                    } else {
                        alert('Error');
                    }
                })
        }
    },
    watch: {
        'form.parentType': function () {
            this.form.parentTypeID = this.form.parentType.id;
        }
    },
    created: function () {
    }
});
