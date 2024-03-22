<template>
  <v-footer app class="custom-footer" dark>
    <v-container>
      <div>&copy; {{ new Date().getFullYear() }} Contact Pro</div>
    </v-container>
  </v-footer>
</template>

<script>
export default {};
</script>

<style scoped>
.custom-footer {
  background: linear-gradient(45deg, #3a9ddb, #3b82f6);
  color: white;
  text-align: center;
  padding: 10px 0;
}
</style>
