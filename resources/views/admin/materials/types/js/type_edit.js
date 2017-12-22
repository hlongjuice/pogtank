const dict = {
    custom: {
        typeName: {required: 'ชื่อหมวดหมู่'},
        parentTypeID: {required: 'ลำดับหมวดหมู่'},
        codePrefix: {required: 'รหัสหมวดหมู่'}
    }
};
console.log(oldType);
let vm = new Vue({
        el: '#app',
        //Created
        created: function () {
            this.$validator.localize('en', dict);
        },
        //Data
        data: {
            parentTypes: parentTypeModel,
            form: {
                name: oldType.name,
                parentType: {
                    id: oldType.ancestors[0] ? oldType.ancestors[0].id : 0,
                    name: oldType.ancestors[0] ? oldType.ancestors[0].id : 'หมวดหมู่หลัก'
                },
                details: oldType.details,
                codePrefix: oldType.code_prefix,
                parentTypeID: oldType.ancestors[0] ? oldType.ancestors[0].id : 0
            }
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
