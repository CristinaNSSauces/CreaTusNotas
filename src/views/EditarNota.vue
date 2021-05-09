<template>
  <div class="home">
    <FormularioEditarNota/>
  </div>
</template>

<script>
// @ is an alias to /src
import FormularioEditarNota from '@/components/FormularioEditarNota.vue';

export default {
  name: 'EditarNota',
  components: {
    FormularioEditarNota
  }
}
</script>

<style scoped>
  .home{
    width:100%;
    height:55%;
    display: flex;
    justify-content: center;
  }
</style>