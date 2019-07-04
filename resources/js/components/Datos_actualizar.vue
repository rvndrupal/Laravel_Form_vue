<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <h1>Actualizar datos</h1>
            </ol>
            <div class="container-fluid espacio"  v-if="insertar == 1">

                <form action="" >

                    <section v-if="paso == 1">
                        <h3>Paso uno</h3>

                        <div class="form-group">
                            <label class="">Nombre(*)</label>
                            <div class="col-md-3">
                                <input type="text" v-model="nom"   class="form-control" placeholder="Nombre">
                                <span v-for="e in errores" class="errores">{{ e }}</span>
                                 <span v-if="errorSer.nom" class="text-error">{{ errorSer.nom[0] }}</span>
                            </div>

                        </div>

                    </section>

                    <section v-if="paso == 2">
                        <h3>Paso dos</h3>

                        <div class="form-group">
                            <label class="">Apellido Paterno(*)</label><br>
                            <div class="col-md-3">
                                <input type="text" v-model="ap"  class="form-control" placeholder="Apellido paterno">
                                 <span v-for="e in errores" class="errores">{{ e }}</span>
                                  <span v-if="errorSer.ap" class="text-error">{{ errorSer.ap[0] }}</span>
                            </div>
                        </div>

                    </section>

                    <section v-if="paso == 3">
                        <h3>Paso tres</h3>

                         <div class="form-group">
                            <label class="" >Apellido Materno(*)</label>
                            <div class="col-md-3">
                                <input type="text"  v-model="am"  class="form-control" placeholder="Apellido materno">
                                 <span v-for="e in errores" class="errores">{{ e }}</span>
                                  <span v-if="errorSer.am" class="text-error">{{ errorSer.am[0] }}</span>
                            </div>
                        </div>

                    </section>

                     <button class="btn btn-primary"
                     v-if="paso != 1"
                     @click.prevent="anteriorPaso">Atras</button>


                    <!-- <button class="btn btn-primary"
                     v-if="paso != totalPasos"
                     @click.prevent="nextPaso">Siguiente</button> -->

                    <button class="btn btn-primary"
                     v-if="paso != totalPasos"
                     @click.prevent="nextPaso">Siguiente</button>



                     <button class="btn btn-primary"
                     v-if="am"
                     @click="registrarDatos">Guardar</button>

                </form >



            </div>

        </main>
</template>

<script>
  export default {

      data: function(){
          return{
            nom : '',
            ap : '',
            am : '',
            totalPasos: 3,
            paso: 1,
            errores:[],
            insertar: 1,
            errorSer: [],
          }
      },

      methods:{
          nextPaso:function(){

              if(this.paso == 1){
                  if(!this.nom){
                      this.errores="El campo nombre es obligatorio";
                      return false;
                  }
                  this.errores="";
              }

               if(this.paso == 2){
                  if(!this.ap){
                      this.errores="El campo Apellido paterno es obligatorio";
                      return false;
                  }
                   this.errores="";
              }



              this.paso++;
          },

          anteriorPaso:function(){
              this.paso--;
          },

          Add:function(){

              if(this.paso == 3){
                  if(!this.am){
                      this.errores="El campo Apellido materno es obligatorio";
                      return false;
                  }

                   this.errores="";
              }

          },


            registrarDatos:function(){


                this.errores="";
                this.errorSer=[]

                let me = this;

                axios.post('datos/registrar',{
                    'nom': this.nom,
                    'ap': this.ap,
                    'am': this.am
                }).then(function (response) {

                   console.log(response);

                }).catch(error => {
                    if(error.response.status == 422)
                    {
                        this.errorSer=error.response.data.errors


                    }
                });

            },

            actualizarDatos(){
                 this.errorSer=[]
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



      },//methods




  }//export

</script>

<style>

.errores{
    color: red;
    font-size: 14px;
}

.espacio{
   margin: 0px 0px 60px 0px;
}

</style>
