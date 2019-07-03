<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <h1>Formulario de datos</h1>
            </ol>
            <div class="container-fluid">

                <form action="">

                    <section v-if="paso == 1">
                        <h3>Paso uno</h3>

                        <div class="form-group">
                            <label class="" >Nombre(*)</label>
                            <div class="col-md-3">
                                <input type="text" v-model="nom"  class="form-control" placeholder="Nombre">
                                <span v-for="e in errores" class="errores">{{ e }}</span>
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
                            </div>
                        </div>

                    </section>

                    <section v-if="paso == 3">
                        <h3>Paso tres</h3>

                         <div class="form-group">
                            <label class="" >Apellido Materno(*)</label>
                            <div class="col-md-3">
                                <input type="text"  v-model="am" class="form-control" placeholder="Apellido materno">
                                 <span v-for="e in errores" class="errores">{{ e }}</span>
                            </div>
                        </div>

                    </section>

                     <button class="btn btn-primary"
                     v-if="paso != 1"
                     @click.prevent="anteriorPaso">Atras</button>

                    <button class="btn btn-primary"
                     v-if="paso != totalPasos"
                     @click.prevent="nextPaso">Siguiente</button>

                     <button class="btn btn-primary"
                     v-if="paso == 3"
                     @click.prevent="Add">Guardar</button>




                </form>



            </div>

        </main>
</template>

<script>
  export default {

      data: function(){
          return{
            nom:"",
            ap:"",
            am:"",
            totalPasos: 3,
            paso: 1,
            errores:[]
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
              alert("Tus datos son:" + this.nom +" " + this.ap +" " + this.am);
          }
      }


  }//export

</script>

<style>

.errores{
    color: red;
    font-size: 12px;
}

</style>
