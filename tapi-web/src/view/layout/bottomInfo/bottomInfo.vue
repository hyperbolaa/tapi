<template>
  <div class="bottom-info">
    <div>
      <span>Copyright &copy; </span>
      <span>
        <el-link href="https://www.baidu.com" target="_blank">永夜剧作家</el-link>
      </span>
    </div>
  </div>
</template>
<script>
export default {
  name: 'BottomInfo',
};
</script>
<style lang="scss">
.bottom-info {
  color: #888;
  height: 30px;
  line-height: 30px;
  a {
    color: #888;
  }
  div {
    display: flex;
    justify-content: center;
    span{
      margin: 0 3px;
    }
  }
}
</style>
