<template>
<div class="container-form">
    <form name="form-nota" method="get" class="formulario">
        <fieldset>
            <label for="Titulo">Titulo</label>
            <input type="text" id="Titulo" name="Titulo" v-model="titulo">
            <br>
            <label for="Descripcion">Descripcion</label>
            <textarea id="Descripcion" name="Descripcion" v-model="descripcion"></textarea>
            <br>
            <label for="Estado">Estado</label>
            <select id="Estado" name="Estado" v-model="estado">
            <option value="sin comenzar">sin comenzar</option>
            <option value="en curso">en curso</option>
            <option value="finalizada">finalizada</option>
            </select>
            <br>
            <label for="Fecha de vencimiento">Fecha de vencimiento</label>
            <input type="date" v-model="fecha_vencimiento">
            <br>
            <button type="button" name="enviar" @click="crearNota">Crear Nota</button>
            <br>
            <button type="button" name="cancelar" @click="$router.push('/')">Volver</button>
        </fieldset>
    </form>
</div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from "axios";
export default {
    name: 'FormularioNota',
    data: () => ({
        titulo: '',
        descripcion: '',
        estado: 'sin comenzar',
        fecha_vencimiento: ''
    }),
    methods: {
        verDatos: function(){
            let oParametros = {
                "method": "insertNota",
                "data": {
                    "titulo": this.titulo,
                    "descripcion" : this.descripcion,
                    "estado": this.estado,
                    "fecha_vencimiento": this.fecha_vencimiento
                }
            };
            console.log(oParametros);
            Swal.fire('Oops...', 'Something went wrong!', 'error');
        },
        crearNota: function(){
            let oParametros = {
                "method": "insertNota",
                "data": {
                    "titulo": this.titulo,
                    "descripcion" : this.descripcion,
                    "estado": this.estado,
                    "fecha_vencimiento": this.fecha_vencimiento
                }
            };
            axios({
                // establece el metodo de conexion que es 'post'
                method: 'post',
                // establece la url a la que se va a conectar
                url: 'http://creatusnotas.infinityfreeapp.com/api.php',
                // establece los parametros que se van a pasar a la API
                data: oParametros
            // cuando se ha resuelto la promesa
            }).then(
                // en el caso de que se haya ejecutado con exito
                (response) => {
                    console.log(response.data.status);
                    if(response.data.status != "ok")
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error ',
                            text: response.data.description
                        });
                    }
                    else
                    {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Tu nota ha sido creada',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.$router.push('/');
                    }
                }
            );
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
*{
  font-family: 'Roboto', sans-serif;
}
.container-form{
    width: 100%;
    height: 100%;
    display:flex;
    justify-content: center;
    align-items: center;
}
.formulario{
    width: 25%;
}
.formulario fieldset{
    font-size: 1.3rem;
    width: 100%;
    height: 100%;
    display:flex;
    flex-flow: column;
    align-items: left;
    justify-content: left;
}
.formulario input, .formulario select, .formulario button{
    font-size: 1.1rem;
}
</style>