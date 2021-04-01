<template>
  <div class="project">
    <div class="search-term">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item label="项目名称">
          <el-input v-model="searchInfo.keyword" placeholder="请输入查询项目名称" clearable />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchData">查询</el-button>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addProject()">添加项目</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="项目名称" prop="name">
        <template v-slot="scope">
          <router-link :to="{ name: 'project-api-all', params: { pid: scope.row.id }}"><el-link icon="el-icon-files">{{ scope.row.name }}</el-link></router-link>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template v-slot="scope">
          <el-button
            v-if="scope.row.follow === 'on'"
            icon="el-icon-star-on"
            size="small"
            type="warning"
            @click="followProject(scope.row,'off')"
          >取关</el-button>
          <el-button
            v-if="scope.row.follow === 'off'"
            icon="el-icon-star-on"
            size="small"
            type="warning"
            @click="followProject(scope.row,'on')"
          >关注</el-button>
          <el-button
            icon="el-icon-share"
            size="small"
            type="success"
            @click="shareProject(scope.row)"
          >分享</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-pagination
      :current-page="page"
      :page-size="limit"
      :page-sizes="[10, 30, 50, 100]"
      :style="{float:'right',padding:'20px'}"
      :total="total"
      layout="total, sizes, prev, pager, next, jumper"
      @current-change="handleCurrentChange"
      @size-change="handleSizeChange"
    />

    <el-dialog :visible.sync="dialogVisible" custom-class="user-dialog" :title="dialogTitle">
      <el-form ref="projectForm" :rules="rules" :model="projectForm">
        <el-form-item label="项目名称" label-width="80px" prop="name">
          <el-input v-model="projectForm.name" placeholder="请输入项目名称，长度不超过100字符(中文算作2字符)" />
        </el-form-item>
        <el-form-item label="所属团队" label-width="80px" prop="tid">
          <el-select v-model="projectForm.tid" placeholder="请选择项目所属团队" filterable style="width: 100%;">
            <el-option v-for="item in teamOptions" :key="item.value" :label="item.label" :value="item.value" />
          </el-select>
        </el-form-item>
        <el-form-item label="基本路径" label-width="80px">
          <el-input v-model="projectForm.path" placeholder="接口基本路径，为空是根路径" />
        </el-form-item>
        <el-form-item label="项目描述" label-width="80px">
          <el-input v-model="projectForm.desc" type="textarea" placeholder="请输入项目描述" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitProject">确 定</el-button>
      </div>
    </el-dialog>

    <el-dialog :title="copyDialogTitle" :visible.sync="copyDialogVisible">
      <el-alert
        :title="copyAlertTitle"
        type="warning"
        :closable="false"
      />
      <el-form ref="copyForm" :model="copyForm" :rules="copyRules">
        <el-form-item label="项目名称" prop="name">
          <el-input v-model="copyForm.name" autocomplete="off" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeCopyDialog">取 消</el-button>
        <el-button type="primary" @click="submitCopy">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
// 获取列表内容封装在mixins内部  getTableData方法 初始化已封装完成
import { getProjectList, createProject, followProject } from '@/api/project';
import teamList from '@/mixins/teamList';
import { getMyTeams } from '@/api/team';
import { store } from '@/store';
export default {
  name: 'TeamProject',
  mixins: [teamList],
  data() {
    return {
      tid: 0,
      teamInfo: {},
      teamOptions: [],
      listApi: getProjectList,
      dialogVisible: false,
      dialogTitle: '添加项目',
      projectForm: {
        name: '',
        tid: 0,
        path: '',
        desc: '',
      },
      rules: {
        name: [
          { required: true, message: '请输入项目名称，长度不超过100字符(中文算作2字符)', trigger: 'blur' },
        ],
        tid: [
          { required: true, message: '请选择项目所属团队', trigger: 'change' },
        ],
      },
      copyDialogVisible: false,
      copyDialogTitle: '',
      copyAlertTitle: '',
      copyForm: {
        id: 0,
        name: '',
      },
      copyRules: {
        name: [
          { required: true, message: '请输入项目名称，长度不超过100字符(中文算作2字符)', trigger: 'blur' },
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
    this.getTeams();
  },
  methods: {
    initData(){
      this.teamInfo = store.getters['team/teamInfo'];
      this.tid = this.teamInfo.id;
      this.getTableData(this.tid);
      this.projectForm.tid = this.tid;
    },
    // 搜索
    searchData() {
      this.page = 1;
      this.limit = 10;
      this.getTableData();
    },
    async getTeams(){
      const teamListRes = await getMyTeams();
      const teamList = teamListRes.data;
      teamList.map(item => {
        this.teamOptions.push({ label: item.name, value: item.id });
      });
    },
    // 添加项目
    addProject() {
      this.resetForm();
      this.dialogTitle = '添加项目';
      this.dialogVisible = true;
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.projectForm.resetFields();
      this.dialogVisible = false;
    },
    // 提交数据
    async submitProject() {
      this.$refs.projectForm.validate(async valid => {
        if (valid) {
          const res = await createProject(this.projectForm);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '添加成功!' });
          }
          await this.getTableData();
          this.closeDialog();
        }
      });
    },
    // 初始化表单
    resetForm() {
      for (const key in this.projectForm) {
        if (key !== 'tid'){
          this.projectForm[key] = '';
        }
      }
    },
    // 关闭弹窗
    closeCopyDialog() {
      this.$refs.copyForm.resetFields();
      this.copyDialogVisible = false;
    },
    // 关注项目
    async followProject(row, flag) {
      const res = await followProject({ id: row.id, flag: flag });
      if (res.code === '000000') {
        const msg = (flag === 'on') ? '关注成功!' : '取消关注成功!';
        this.$message({ type: 'success', message: msg });
        this.getTableData();
      }
    },
    // 分享
    async shareProject(row) {
      console.log('share');
    },
  },
};
</script>
<style lang="scss">

.button-box {
  padding: 10px 20px;
  .el-button {
    float: right;
  }
}

</style>
