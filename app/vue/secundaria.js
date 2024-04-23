var app = new Vue({
    el: '#app',
    data: {
      alumnos: [],
      alumno: [],
    }, //fin data

    created: function () {
        console.log('Created...');
        this.getAlumnos();
	console.log("getAlumnos ejecutado");
    }, //fin created
    methods: {
        getAlumnos: function () {
            const URL = 'https://cbtis169.net/Secundaria/getAlumnos';
	    console.log(URL);				
            fetch(URL)
                .then(response => response.json())
                .then(data => {
                    this.alumnos= data;
                    console.log("Alumnos[]: ",this.alumnos);
                });
        },

        getAlumno: function (id) {
            const URL = 'https://cbtis169.net/Secundaria/getAlumnos/'+id;
            fetch(URL)
                .then(response => response.json())
                .then(data => {
                    this.alumno= data;
                    console.log("Alumno[]: ",this.alumno);
                });
        },


    } //fin metodos
}) //fin vue