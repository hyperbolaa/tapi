<template>
  <div class="user-profile">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>修改密码</span>
      </div>
      <el-form ref="modifyPwdForm" :model="pwdModify" :rules="rules" label-width="80px">
        <el-form-item :minlength="6" label="原密码" prop="password">
          <el-input v-model="pwdModify.password" show-password />
        </el-form-item>
        <el-form-item :minlength="6" label="新密码" prop="newPassword">
          <el-input v-model="pwdModify.newPassword" show-password />
        </el-form-item>
        <el-form-item :minlength="6" label="确认密码" prop="confirmPassword">
          <el-input v-model="pwdModify.confirmPassword" show-password />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="savePassword">确 定</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { changePassword } from '@/api/user';

export default {
  name: 'UserProfile',
  data() {
    return {
      pwdModify: {},
      rules: {
        password: [
          { required: true, message: '请输入密码', trigger: 'blur' },
          { min: 6, message: '最少6个字符', trigger: 'blur' },
          { max: 20, message: '最多20个字符', trigger: 'blur' },
        ],
        newPassword: [
          { required: true, message: '请输入新密码', trigger: 'blur' },
          { min: 6, message: '最少6个字符', trigger: 'blur' },
          { max: 20, message: '最多20个字符', trigger: 'blur' },
        ],
        confirmPassword: [
          { required: true, message: '请输入确认密码', trigger: 'blur' },
          {
            validator: (rule, value, callback) => {
              if (value !== this.pwdModify.newPassword) {
                callback(new Error('两次密码不一致'));
              } else {
                callback();
              }
            },
            trigger: 'blur',
          },
        ],
      },
      value: '',
    };
  },
  computed: {
    ...mapGetters('user', ['userInfo']),
  },
  methods: {
    savePassword() {
      this.$refs.modifyPwdForm.validate(async(valid) => {
        if (valid) {
          const res = await changePassword({
            uuid: this.userInfo.uuid,
            password: this.pwdModify.password,
            newPassword: this.pwdModify.newPassword,
            confirmPassword: this.pwdModify.confirmPassword,
          });
          if (res.code === '000000'){
            this.$message({ type: 'success', message: '修改密码成功!' });
          }
        } else {
          return false;
        }
      });
    },
  },
};
</script>
<style lang="scss">
.user-profile .el-card__body{
  padding-left: 160px;
}
</style>
