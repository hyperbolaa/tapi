<template>
  <div class="cont-project">
    <div class="main-right">
      <el-tabs class="role-box" type="border-card">
        <el-tab-pane label="项目设置">
          <ProjectInfo ref="info" />
        </el-tab-pane>
        <el-tab-pane label="环境配置">
          <ProjectEnv ref="envs" />
        </el-tab-pane>
        <el-tab-pane label="标签配置">
          <ProjectTag ref="tags" />
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>

<script>
import ProjectInfo from '@/view/project/setting/info';
import ProjectEnv from '@/view/project/setting/env';
import ProjectTag from '@/view/project/setting/tag';

export default {
  name: 'ProjectSetting',
  components: {
    ProjectInfo,
    ProjectEnv,
    ProjectTag,
  },
  data() {
    return {
    };
  },

};
</script>
<style lang="scss">
.el-menu-vertical-demo{
  border: none;
}
</style>
