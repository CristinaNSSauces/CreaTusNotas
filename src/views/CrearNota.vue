<template>
  <div class="home">
    <FormularioNota/>
  </div>
</template>

<script>
// @ is an alias to /src
import FormularioNota from '@/components/FormularioNota.vue';

export default {
  name: 'Home',
  components: {
    FormularioNota
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
