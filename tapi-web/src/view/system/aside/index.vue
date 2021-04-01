<template>
  <div class="main-left">
    <el-card class="box-card">
      <el-menu
        :default-active="active"
        class="el-menu-vertical"
        text-color="rgb(191, 203, 217)"
        @select="selectMenuItem"
      >
        <el-menu-item :key="1" index="/console/system/static">
          <i :class="'el-icon-s-data'" /><span slot="title">数据统计</span>
        </el-menu-item>
        <el-menu-item :key="2" index="/console/system/user">
          <i :class="'el-icon-user'" /><span slot="title">用户管理</span>
        </el-menu-item>
        <el-menu-item :key="3" index="/console/system/notice">
          <i :class="'el-icon-bell'" /><span slot="title">通知公告</span>
        </el-menu-item>
      </el-menu>
    </el-card>
  </div>
</template>

<script>
export default {
  name: 'TeamAside',
  data() {
    return {
      active: '',
    };
  },
  created() {
    this.active = this.$route.path;
  },
  methods: {
    selectMenuItem(index) {
      if (index === this.$route.path) {
        return;
      }
      this.$router.push({ path: index });
    },
  },
};
</script>

<style lang="scss" scoped>
.layout-cont .main-cont .el-menu-vertical {
  height: 400px !important;
  border-right: none;
}
</style>
