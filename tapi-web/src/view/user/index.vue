<template>
  <div class="cont-team">
    <el-row :gutter="10" style="padding-top: 0;">
      <el-col :span="4">
        <UserAside />
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
import UserAside from '@/view/user/aside/index';

export default {
  name: 'User',
  components: {
    UserAside,
  },
};
</script>
<style lang="scss">

</style>
