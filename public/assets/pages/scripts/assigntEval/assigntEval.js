var vm = new Vue({
    data: {
      selected: null,
      selectedEval: null,
      eval: [{id: '', text: ''}],
      users: oData.Users,
      lEval: null
    },
    mounted() {
      let self = this;

      // inicializas select2
      var opciones = [];
      opciones.push({id: '', text: ''});
      for(var i = 0; i<self.users.length; i++){
            opciones.push({id: self.users[i].id, text: self.users[i].full_name});
      }
      
      $('#miSelect')
        .select2({ 
            placeholder: 'Selecciona evaluador',
            data: opciones, // cargas los datos en vez de usar el loop
         })
         // nos hookeamos en el evento tal y como puedes leer en su documentación
         .on('select2:select', function () {
             var value = $("#miSelect").select2('data');
          // nos devuelve un array
          
          // ahora simplemente asignamos el valor a tu variable selected de VUE
          self.selected = value[0].id;
          self.eval = value;
          console.log(self.eval);
            var arr = [];
            for(var i = 0; i<opciones.length; i++){
                if(opciones[i].id != self.selected){
                    arr.push({id: opciones[i].id, text: opciones[i].text});
                }
            }
            $('#evalSelect').empty();
            self.lEval = null;

            $('#evalSelect')
            .select2({
                placeholder: 'Selecciona evaluando',
                data: arr, // cargas los datos en vez de usar el loop
            })
            // nos hookeamos en el evento tal y como puedes leer en su documentación
            .on('change', function () {
                self.lEval = $("#evalSelect").select2('data'); 
            })
            
        })
    }
  }).$mount('#assigntEval');