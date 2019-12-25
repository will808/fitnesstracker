<template>

</template>

<script>
export default {
  created() {
      
      
    this.$store.dispatch('deleteToken')
      .then(response => {
        this.$router.push("/")
      })
  }
}
</script>