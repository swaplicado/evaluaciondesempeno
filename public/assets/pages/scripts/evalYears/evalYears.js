var vm = new Vue({
    el: '#evalYears',
    data: {
        years: oData.years,
        Year: null,
        Status: null,
        idYear: null
    },
    mounted() {

    },
    methods: {
        setYear(id, year, status){
            this.Year = year;
            this.Status = status;
            this.idYear = id;
        }
    }
});