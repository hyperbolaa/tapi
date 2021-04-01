<template>
  <div class="cont-team">
    <el-row :gutter="10" style="padding-top: 0;">
      <el-col :span="4">
        <SystemAside />
      </el-col>
      <el-col :span="20">
        <div class="main-right">
          <router-view />
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import SystemAside from '@/view/system/aside/index';

export default {
  name: 'System',
  components: {
    SystemAside,
  },
};
</script>
<style lang="scss">

</style>
