//Custom Error Message
const dict = {
    custom: {
        typeName: {required: 'ชื่อหมวดหมู่'},
        parentTypeID: {required: 'ลำดับหมวดหมู่'},
        codePrefix: {required: 'รหัสหมวดหมู่'}
    }
};
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
    //Method
    methods: {
        validateForm: function (scope, ev) {
            this.$validator.validateAll(scope)
                .then(result => {
                    if (result) {
                        axios.post('/admin/materials/types', vm.form)
                            .then(result => {
                                window.location=indexRoute;
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
    created:function(){
    }
});
