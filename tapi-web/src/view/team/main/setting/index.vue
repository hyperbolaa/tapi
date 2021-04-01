<template>
  <div>
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="团队名称" prop="name">
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item label="团队简介">
        <el-input v-model="form.desc" type="textarea" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">保存</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { store } from '@/store';
import { updateTeam } from '@/api/team';

export default {
  name: 'TeamSetting',
  data() {
    return {
      teamInfo: {},
      form: {
        id: 0,
        name: '',
        desc: '',
      },
      rules: {
        name: [
          { required: true, message: '请输入团队名称', trigger: 'blur' },
        ],
      },
    };
  },
  watch: {
    $route() {
      this.initData();
    },
  },
  created() {
    this.initData();
  },
  methods: {
    initData(){
      this.teamInfo = store.getters['team/teamInfo'];
      for (const key in this.form) {
        this.form[key] = this.teamInfo[key];
      }
    },
    onSubmit() {
      this.$refs.form.validate(async valid => {
        if (valid) {
          const res = await updateTeam(this.form);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '编辑成功!' });
          }
        }
      });
    },
  },
};
</script>

<style lang="scss">

</style>
