<template>
  <div class="info-cont">
    <el-form ref="pjForm" :model="pjForm" label-width="100px">
      <el-form-item label="项目ID: ">
        <span>{{ pjForm.id }}</span>
      </el-form-item>
      <el-form-item label="项目名称: ">
        <el-input v-model="pjForm.name" />
      </el-form-item>
      <el-form-item label="所属团队: ">
        <el-select v-model="pjForm.tid">
          <el-option
            v-for="item in teamOptions"
            :key="item.id"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="接口基本路径: ">
        <el-input v-model="pjForm.path" />
      </el-form-item>
      <el-form-item label="描述: ">
        <el-input v-model="pjForm.desc" type="textarea" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="doSubmit">保存</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { getMyTeams } from '@/api/team';
import { updateProject } from '@/api/project';

export default {
  name: 'ProjectInfo',
  data() {
    return {
      pjForm: {},
      teamOptions: [],
      rules: {
        name: [
          { required: true, message: '请输入项目名称', trigger: 'blur' },
        ],
      },
    };
  },
  computed: {
    ...mapGetters('project', ['projectInfo']),
  },
  created() {
    this.getTeamList();
    this.pjForm = JSON.parse(JSON.stringify(this.projectInfo));// 个方法是完全复制了一个新的对象
  },
  methods: {
    async getTeamList(){
      const teamListRes = await getMyTeams();
      this.teamOptions = teamListRes.data;
    },
    // 提交数据
    async doSubmit() {
      this.$refs.pjForm.validate(async valid => {
        if (valid) {
          const res = await updateProject(this.pjForm);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '更新成功!' });
          }
        }
      });
    },
  },
};
</script>

<style lang="scss">

</style>
