<template>
  <div class="user-profile">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>个人信息</span>
      </div>
      <div class="text item">
        <el-form label-position="left" label-width="180px">
          <el-form-item label="用户ID">
            <span>{{ userInfo.name }}</span>
          </el-form-item>
          <el-form-item label="用户名">
            <span>{{ userInfo.name }}</span>
          </el-form-item>
          <el-form-item label="Email">
            <span>{{ userInfo.name }}</span>
          </el-form-item>
          <el-form-item label="角色">
            <span>{{ userInfo.name }}</span>
          </el-form-item>
          <el-form-item label="创建账号时间">
            <span>{{ userInfo.name }}</span>
          </el-form-item>
          <el-form-item label="更新账号时间">
            <span>{{ userInfo.name }}</span>
          </el-form-item>
        </el-form>
      </div>
    </el-card>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
  name: 'UserProfile',
  data() {
    return {
    };
  },
  computed: {
    ...mapGetters('user', ['userInfo']),
  },
};
</script>
<style lang="scss">
.user-profile .el-card__body{
  padding-left: 160px;
}
</style>
