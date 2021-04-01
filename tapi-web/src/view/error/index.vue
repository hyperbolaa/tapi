<template>
  <div>
    <div class="big">
      <div class="inner">
        <img src="@/assets/404.png" style="height: 400px;">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Error404',
};
</script>

<style lang="scss">
    .big{
        width: 100%;
        height: calc(100vh - 220px);
        background-color: rgb(244,244,244);
        position: relative;
    }
    .inner{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
