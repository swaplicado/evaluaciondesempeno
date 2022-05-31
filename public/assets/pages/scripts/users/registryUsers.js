var app = new Vue({
    el: '#appRegister',
    data: {
        lDepartments: oData.lDepartments,
        allJobs: oData.lJobs,
        selDept: null,
        lJobs: []
    },
    mounted() {
        
    },
    methods: {
        setJobs() {
            this.lJobs = this.allJobs.filter(({ department_id }) => department_id === this.selDept);
        }
    }
});