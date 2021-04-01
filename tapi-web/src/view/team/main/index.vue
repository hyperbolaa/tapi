<template>
  <div class="main-right">
    <el-tabs class="role-box" type="border-card">
      <el-tab-pane label="项目列表">
        <TeamProject ref="project" />
      </el-tab-pane>
      <el-tab-pane label="成员列表">
        <TeamMember ref="member" />
      </el-tab-pane>
      <el-tab-pane label="团队动态">
        <TeamTrend ref="trend" />
      </el-tab-pane>
      <el-tab-pane label="团队设置">
        <TeamSetting ref="setting" />
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import TeamProject from '@/view/team/main/project';
import TeamMember from '@/view/team/main/member';
import TeamTrend from '@/view/team/main/trend';
import TeamSetting from '@/view/team/main/setting';

export default {
  name: 'TeamMain',
  components: {
    TeamProject,
    TeamMember,
    TeamTrend,
    TeamSetting,
  },
  data() {
    return {
    };
  },
  created() {
    console.log('team-main');
  },
};
</script>
<style lang="scss">

</style>
