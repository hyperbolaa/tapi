<template>
  <div class="team-cont-left">
    <el-card class="box-card">
      <div>
        <div class="title" style="margin-bottom: 20px;">
          <span>{{ teamInfo.name }}</span>
          <el-button style="float: right;padding: 0;" type="text" @click="addTeam">添加团队</el-button>
        </div>
        <div class="desc" style="margin-bottom: 20px;background-color: silver;">
          <p>简介：{{ teamInfo.desc }}</p>
        </div>
      </div>
      <div>
        <el-scrollbar>
          <transition :duration="{ enter: 800, leave: 100 }" mode="out-in" name="el-fade-in-linear">
            <el-menu
              :default-active="active"
              class="el-menu-vertical"
              text-color="rgb(191, 203, 217)"
              @select="selectMenuItem"
            >
              <template v-for="item in teamList">
                <el-menu-item :key="item.id" :index="'/console/team/' + item.id.toString()" :route="{parameters:item.parameters}">
                  <i :class="'el-icon-school'" />
                  <span slot="title">{{ item.name }}</span>
                </el-menu-item>
              </template>
            </el-menu>
          </transition>
        </el-scrollbar>
      </div>
    </el-card>

    <el-dialog :visible.sync="dialogVisible" custom-class="user-dialog" title="添加团队">
      <el-form ref="teamForm" :rules="rules" :model="teamForm">
        <el-form-item label="团队名" label-width="100px" prop="name">
          <el-input v-model="teamForm.name" placeholder="请输入团队名称" />
        </el-form-item>
        <el-form-item label="简介" label-width="100px">
          <el-input v-model="teamForm.desc" type="textarea" placeholder="请输入团队简介" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitTeam">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getMyTeams, createTeam } from '@/api/team';
import { store } from '@/store';

export default {
  name: 'TeamAside',
  data() {
    return {
      tid: 0,
      active: '',
      teamInfo: {},
      teamList: [],
      dialogVisible: false,
      teamForm: {
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
  created() {
    const teamInfo = store.getters['team/teamInfo'];
    this.teamInfo = teamInfo;
    this.tid = teamInfo.id;
    this.getTeamList();
  },
  methods: {
    teamActive(){
      this.active = this.$route.path;
    },
    async getTeamList(){
      const teamListRes = await getMyTeams();
      this.teamList = teamListRes.data;
      this.teamActive();
    },
    selectMenuItem(index) {
      if (index === this.$route.path) {
        return;
      }
      this.$router.push({ path: index });
    },
    addTeam(){
      this.resetForm();
      this.dialogVisible = true;
    },
    // 提交数据
    async submitTeam() {
      this.$refs.teamForm.validate(async valid => {
        if (valid) {
          const res = await createTeam(this.teamForm);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '添加成功!' });
          }
          await this.getTeamList();
          this.closeDialog();
        }
      });
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.teamForm.resetFields();
      this.dialogVisible = false;
    },
    // 初始化表单
    resetForm() {
      if (this.$refs.teamForm) {
        this.$refs.teamForm.resetFields();
      }
      for (const key in this.teamForm) {
        this.teamForm[key] = '';
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.team-cont-left .menu-info {
  .menu-contorl {
    line-height: 52px;
    font-size: 20px;
    display: table-cell;
    vertical-align: middle;
  }
}
.team-cont-left .el-menu-vertical {
  height: calc(100vh - 220px) !important;
  border-right: none;
}
</style>
