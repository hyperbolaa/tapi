<template>
  <div class="member-cont right_container">
    <div class="search-term">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item label="成员名称">
          <el-input v-model="searchInfo.keyword" placeholder="请输入查询成员名称" />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchData">查询</el-button>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addUser()">添加成员</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="姓名" prop="uname" min-width="200" />
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
            @click="deleteUser(scope.row)"
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
        <el-form-item label="用户名: " label-width="100px">
          <el-select v-model="userForm.uuid" :remote-method="getRemoteUserList" filterable default-first-option remote placeholder="根据用户名搜索">
            <el-option v-for="(item,index) in userListOptions" :key="index" :label="item.name" :value="item.value" />
          </el-select>
        </el-form-item>
        <el-form-item label="权限: " label-width="100px">
          <el-select v-model="userForm.role">
            <el-option
              v-for="item in roleOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
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
import { getProjectUserList, createProjectUser, updateProjectUser, deleteProjectUser } from '@/api/projectMember';
import { searchUser } from '@/api/user';
import projectList from '@/mixins/projectList';
import options from '@/mixins/options';

export default {
  name: 'ProjectMember',
  mixins: [projectList, options],
  data() {
    return {
      pid: 0,
      listApi: getProjectUserList,
      userListOptions: [],
      dialogVisible: false,
      userForm: {
        pid: '',
        uuid: '',
        role: 'dever',
      },
      rules: {
        uuid: [
          { required: true, message: '请选择用户', trigger: 'blur' },
        ],
      },
    };
  },
  async created() {
    this.pid = parseInt(this.$route.params.pid);
    this.getTableData();
  },
  methods: {
    // 搜索
    searchData() {
      this.page = 1;
      this.limit = 10;
      this.getTableData();
    },
    // 添加用户
    addUser() {
      this.resetForm();
      this.userForm.pid = this.pid;
      this.dialogVisible = true;
    },
    async changeRole(row){
      const res = await updateProjectUser({ id: row.id, role: row.role });
      if (res.code === '000000') {
        this.$message({ type: 'success', message: '修改成功!' });
      }
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.userForm.resetFields();
      this.dialogVisible = false;
    },
    // 删除数据
    deleteUser(row) {
      this.$confirm('此操作将永久删除该用户, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(async() => {
        const res = await deleteProjectUser({ id: row.id });
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
          const res = await createProjectUser(this.userForm);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '添加成功!' });
          }
          await this.getTableData();
          this.closeDialog();
        }
      });
    },
    async getRemoteUserList(name) {
      searchUser({ name: name }).then(response => {
        this.userListOptions = response.data;
      });
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

</style>
