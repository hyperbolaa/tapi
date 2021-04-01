<template>
  <div class="cont-project-api">
    <el-row :gutter="10">
      <el-col :span="6">
        <ColMenu />
      </el-col>
      <el-col :span="18">
        <div class="cont-team">
          <div class="main-right">我是详情</div>
        </div>
      </el-col>
    </el-row>
  </div>

</template>

<script>
import ColMenu from '@/view/project/col/components/menu';

export default {
  name: 'ColDetail',
  components: {
    ColMenu,
  },
  data() {
    return {
      input: '',
    };
  },

};
</script>
<style lang="scss">

</style>
