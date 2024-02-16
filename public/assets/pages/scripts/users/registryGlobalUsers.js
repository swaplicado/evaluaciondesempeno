var app = new Vue({
    el: '#appRegister',
    data: {
        lDepartments: oData.lDepartments,
        allJobs: oData.lJobs,
        lColab: oData.lColab,
        selCol: null,
        selDept: null,
        lJobs: [],
        isDisabled : true
    },
    mounted() {
        
    },
    methods: {
        setJobs() {
            this.lJobs = this.allJobs.filter(({ department_id }) => department_id === this.selDept);
            document.getElementById('job').removeAttribute('disabled');
        }
    }
});