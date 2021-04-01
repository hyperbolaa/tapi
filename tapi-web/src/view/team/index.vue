<template>
  <div class="team-cont">
    <el-row :gutter="10" style="padding-top: 0;">
      <el-col :span="4">
        <team-aside />
      </el-col>
      <el-col :span="20">
        <team-main />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import TeamAside from '@/view/team/aside/index';
import TeamMain from '@/view/team/main/index';

export default {
  name: 'Team',
  components: {
    TeamAside,
    TeamMain,
  },
  data() {
    return {
    };
  },
};
</script>
<style lang="scss">

</style>
