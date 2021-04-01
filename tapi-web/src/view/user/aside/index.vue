<template>
  <div class="main-left">
    <el-card class="box-card">
      <el-menu
        :default-active="active"
        class="el-menu-vertical"
        text-color="rgb(191, 203, 217)"
        @select="selectMenuItem"
      >
        <el-menu-item :key="1" index="/console/user/profile">
          <i :class="'el-icon-user'" /><span slot="title">个人信息</span>
        </el-menu-item>
        <el-menu-item :key="2" index="/console/user/password">
          <i :class="'el-icon-knife-fork'" /><span slot="title">修改密码</span>
        </el-menu-item>
      </el-menu>
    </el-card>
  </div>
</template>

<script>
export default {
  name: 'UserAside',
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
