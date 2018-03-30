import MaterialType from '../../../../../assets/js/services/material/material_type_service';
const dict = {
    custom: {
        typeName: {required: 'ชื่อหมวดหมู่'},
        parentTypeID: {required: 'ลำดับหมวดหมู่'},
        codePrefix: {required: 'รหัสหมวดหมู่'}
    }
};
let path =window.location.pathname;
let typeID = path.split("/").slice(-1);
let materialType = new MaterialType();
let oldType={};
let vm = new Vue({
        el: '#material-type-edit',
        //Created
        created: function () {
            this.$validator.localize('en', dict);
        },
        //Data
        data: {
            showLoading:'',
            parentTypes:[],
            form: {
                name: '',
                parentType: {
                    id:'',
                    name: ''
                },
                details: '',
                codePrefix: '',
                parentTypeID: ''
            }
        },
        mounted:function(){
            this.showLoading=true;

            Promise.all([
                //Get Old Types
               materialType.getMaterialType(typeID)
                   .then(oldType=>{
                       console.log(oldType);
                       vm.form= {
                           name: oldType.name,
                           parentType: {
                               id: oldType.ancestors[0] ? oldType.ancestors[0].id : 0,
                               name: oldType.ancestors[0] ? oldType.ancestors[0].name : 'หมวดหมู่หลัก'
                           },
                           details: oldType.details,
                           codePrefix: oldType.code_prefix,
                           parentTypeID: oldType.ancestors[0] ? oldType.ancestors[0].id : 0
                       };
                   }).catch(err=>{
                       console.log(err)
               }),
                //Get all Parent and Sibling Types
                materialType.getMaterialParentSiblingTypes(typeID)
                    .then(result=>{
                        vm.parentTypes=result;
                        console.log(result);
                    }).catch(err=>{
                        console.log(err)
                })
            ]).then(()=>{
                vm.showLoading=false;
            });
        },
        methods: {
            validateForm: function (scope) {
                this.$validator.validateAll(scope)
                    .then(result => {
                        if (result) {
                            axios.put('/admin/materials/types/' + oldType.id, vm.form)
                                .then(result => {
                                    window.location=indexRoute;
                                }).catch(err => {
                                console.log(err);
                                alert('ไม่สามารถเพิ่มข้อมูลได้กรุณารองใหม่อีกครั้ง');
                            })
                        }
                    })
            }
        },
        watch: {
            'form.parentType': function () {
                this.form.parentTypeID = this.form.parentType.id;
            }
        },
    })
;
