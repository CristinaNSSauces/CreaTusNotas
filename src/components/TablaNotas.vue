<template>
<div class="tabla_notas">
    <button type="button" @click="crearNota">Crear Nota</button>
    <table id="notas" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Fecha Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="nota, index in notas" :key="index">
                <td>{{nota.titulo}}</td>
                <td>{{nota.descripcion}}</td>
                <td>{{nota.estado}}</td>
                <td>{{nota.fecha_vencimiento}}</td>
                <td>
                    <button v-bind:id="nota.id" @click="editarNota(nota.id)">Editar</button>
                    <button v-bind:id="nota.id" @click="eliminarNota(nota.id)">Eliminar</button>
                </td> 
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-dt/css/jquery.dataTables.css';
import Swal from 'sweetalert2';
import axios from "axios";
export default {
    name: 'TablaNotas',
    data: () => ({
        notas: []
    }),
    updated: function () {
        this.$nextTick(function () {
            $('#notas').DataTable({
                'destroy'      :true,
                'stateSave'   : true,
                }).draw();
        })
    },
    mounted(){
        this.cargarDatos();
    },
    methods: {
        crearNota(){
            this.$router.push('CrearNota');
        },
        editarNota(id){
            sessionStorage.setItem('id', id);
            this.$router.push('editarNota');
        },
        eliminarNota(id){
            Swal.fire({
                title: '¿Seguro que deseas eliminar esta nota?',
                text: "Eliminarás esta nota de forma permanente y definitiva!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed)
                {
                    let oParametros = {
                        "method": "deleteNota",
                        "data": {
                            "id": id
                        }
                    };
                    axios({
                        // establece el metodo de conexion que es 'post'
                        method: 'post',
                        // establece la url a la que se va a conectar
                        url: 'http://creatusnotas.infinityfreeapp.com/api.php',
                        // establece los parametros que se van a pasar a la API
                        data: oParametros
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
                                    title: 'Tu nota ha sido eliminada',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                // this.cargarDatos();
                                // this.$nextTick(function () {
                                //     $('#notas').DataTable({
                                //         'destroy'      :true,
                                //         'stateSave'   : true,
                                //         }).draw();
                                // })
                                this.$router.go();
                            }
                        }
                    );
                }
            })
        },
        cargarDatos: function(){
            let oParametros = {
                "method": "getNotas"
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
                    this.notas = response.data.data;
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
</style>