<template>
  <div>
    <div class="search-term" style="float: right;">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item>
          <el-button type="primary" @click="addUser()">添加成员</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="姓名" min-width="200" prop="uname" />
      <el-table-column label="角色" min-width="200">
        <template v-slot="scope">
          <el-select v-model="scope.row.role" placeholder="请选择" style="width: 100%;" @change="changeRole(scope.row)">
            <el-option
              v-for="item in roleOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </template>
      </el-table-column>
      <el-table-column label="操作" min-width="100">
        <template v-slot="scope">
          <el-button
            icon="el-icon-delete"
            size="small"
            type="danger"
            @click="deleteTeamUser(scope.row)"
          >删除</el-button>
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

    <el-dialog :visible.sync="dialogVisible" custom-class="user-dialog" title="添加成员">
      <el-form ref="userForm" :rules="rules" :model="userForm">
        <el-form-item label-width="100px" label="用户名: " prop="uuid">
          <el-select
            v-model="userForm.uuid"
            :remote-method="getRemoteUserList"
            filterable
            remote
            placeholder="根据用户名搜索"
          >
            <el-option
              v-for="(item,index) in userListOptions"
              :key="index"
              :label="item.name"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="权限: " label-width="100px" prop="role">
          <el-select v-model="userForm.role" placeholder="请选择团队角色">
            <el-option v-for="item in roleOptions" :key="item.value" :label="item.label" :value="item.value" />
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitUser">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
// 获取列表内容封装在mixins内部  getTableData方法 初始化已封装完成
import { getTeamUserList, updateTeamUser, createTeamUser, deleteTeamUser } from '@/api/teamMember';
import { searchUser } from '@/api/user';
import teamList from '@/mixins/teamList';
import options from '@/mixins/options';
import { store } from '@/store';

export default {
  name: 'TeamMember',
  mixins: [teamList, options],
  data() {
    return {
      tid: 0,
      teamInfo: {},
      userListOptions: [],
      listApi: getTeamUserList,
      dialogVisible: false,
      userForm: {
        id: 0,
        tid: 0,
        uuid: '',
        role: 'dever',
      },
      rules: {
        uuid: [
          { required: true, message: '请输入真实姓名', trigger: 'change' },
        ],
        role: [
          { required: true, message: '请选择用户角色', trigger: 'change' },
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
    this.getRemoteUserList('');
  },
  methods: {
    initData(){
      this.teamInfo = store.getters['team/teamInfo'];
      this.tid = this.teamInfo.id;
      this.getTableData();
    },
    // 搜索
    searchData() {
      this.page = 1;
      this.limit = 10;
      this.getTableData();
    },
    getRemoteUserList(value) {
      searchUser({ name: value }).then(response => {
        this.userListOptions = response.data;
      });
    },
    // 添加用户
    addUser() {
      this.resetForm();
      this.userForm.tid = this.tid;
      this.dialogVisible = true;
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.userForm.resetFields();
      this.dialogVisible = false;
    },
    // 删除数据
    deleteTeamUser(row) {
      this.$confirm('此操作将永久删除该用户, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(async() => {
        const res = await deleteTeamUser({ id: row.id });
        if (res.code === '000000') {
          this.$message({ type: 'success', message: '删除成功!' });
          this.getTableData();
        }
      }).catch(() => {
        this.$message({ type: 'info', message: '已取消删除' });
      });
    },
    // 提交数据
    async submitUser() {
      this.$refs.userForm.validate(async valid => {
        if (valid) {
          const res = await createTeamUser(this.userForm);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '添加成功!' });
          }
          await this.getTableData();
          this.closeDialog();
        }
      });
    },
    async changeRole(row){
      const res = await updateTeamUser({ id: row.id, role: row.role });
      if (res.code === '000000') {
        this.$message({ type: 'success', message: '修改成功!' });
      }
    },
    // 初始化表单
    resetForm() {
      if (this.$refs.userForm) {
        this.$refs.userForm.resetFields();
      }
      for (const key in this.userForm) {
        if (key !== 'role'){
          this.userForm[key] = '';
        }
      }
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
