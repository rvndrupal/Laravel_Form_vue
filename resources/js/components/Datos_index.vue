<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <h1>Tabla Datos</h1>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Datos
                        <button type="button" @click="abrirModal('datos','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nom">Nombre</option>
                                      <option value="ap">Apellido paterno</option>
                                      <option value="am">Apellido materno</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarDatos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarDatos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Apellido paterno</th>
                                    <th>Apellido materno</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="datos in arrayDatos" :key="datos.id">
                                    <td>
                                        <button type="button" @click="abrirModal('datos','actualizar',datos)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="datos.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDatos(datos.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarDatos(datos.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="datos.nom"></td>
                                    <td v-text="datos.ap"></td>
                                    <td v-text="datos.am"></td>
                                    <td>
                                        <div v-if="datos.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre(*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nom" class="form-control" placeholder="Nombre de categoría">
                                        <span v-if="errorSer.nom" class="text-error">{{ errorSer.nom[0] }}</span>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Apellido Paterno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ap" class="form-control" placeholder="Ingrese descripción">
                                        <span v-if="errorSer.ap" class="text-error">{{ errorSer.ap[0] }}</span>
                                    </div>

                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Apellido Materno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="am" class="form-control" placeholder="Ingrese descripción">
                                         <span v-if="errorSer.am" class="text-error">{{ errorSer.am[0] }}</span>
                                    </div>

                                </div>
                                <div v-show="errorDatos" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjDatos" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarDatos()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDatos()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                datos_id: 0,
                nom : '',
                ap : '',
                am : '',
                arrayDatos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorDatos : 0,
                errorMostrarMsjDatos : [],
                errorSer: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nom',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods : {
            listarDatos (page,buscar,criterio){
                let me=this;
                var url='datos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDatos = respuesta.datos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open('categoria/listarPdf','_blank');
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarCategoria(page,buscar,criterio);
            },
            registrarDatos(){
                this.errorSer=[]
                if (this.validarDatos()){
                    return;
                }

                let me = this;

                axios.post('datos/registrar',{
                    'nom': this.nom,
                    'ap': this.ap,
                    'am': this.am
                }).then(function (response) {
                    console.log(response);
                    me.cerrarModal();
                    me.listarDatos(1,'','nom');
                }).catch(error => {
                    if(error.response.status == 422)
                    {
                        this.errorSer=error.response.data.errors
                        alert(errorSer);

                    }
                });
            },
            actualizarDatos(){
                 this.errorSer=[]
               if (this.validarDatos()){
                    return;
                }

                let me = this;

                axios.put('datos/actualizar',{
                    'nom': this.nom,
                    'ap': this.ap,
                    'am': this.am,
                    'id': this.datos_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarDatos(1,'','nom');
                }).catch(error => {
                    if(error.response.status == 422)
                    {
                        this.errorSer=error.response.data.errors
                        alert(errorSer);

                    }
                });
            },
            desactivarDatos(id){
               swal({
                title: 'Esta seguro de desactivar esta categoría?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('datos/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarDatos(1,'','nom');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
                })
            },
            activarDatos(id){
               swal({
                title: 'Esta seguro de activar esta categoría?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('datos/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarDatos(1,'','nom');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
                })
            },
            validarDatos(){
                this.errorDatos=0;
                this.errorMostrarMsjDatos =[];

                // if (!this.nom) this.errorMostrarMsjDatos.push("El nombre  no puede estar vacío.");
                // if (!this.descripcion) this.errorMostrarMsjDatos.push("La descripción de la categoría no puede estar vacío.");

                if (this.errorMostrarMsjDatos.length) this.errorDatos = 1;

                return this.errorDatos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nom='';
                this.ap='';
                this.am='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "datos":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Datosss';
                                this.nom= '';
                                this.ap = '';
                                this.am = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Datos';
                                this.tipoAccion=2;
                                this.datos_id=data['id'];
                                this.nom = data['nom'];
                                this.ap = data['ap'];
                                this.am = data['am'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarDatos(1,this.buscar,this.criterio);
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
