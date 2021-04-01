<template>
  <div class="right_container">
    <div class="search-term">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item label="类型">
          <el-select v-model="searchInfo.type" clearable placeholder="请选择">
            <el-option
              v-for="item in searchOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="关键字">
          <el-input v-model="searchInfo.keyword" placeholder="请输入查询关键字" />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchData">查询</el-button>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addUser()">添加用户</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="头像" min-width="50">
        <template v-slot="scope">
          <div :style="{'textAlign':'center'}">
            <el-avatar :size="30" :src="scope.row.avatar" />
          </div>
        </template>
      </el-table-column>
      <el-table-column label="用户ID" min-width="250" prop="uuid" />
      <el-table-column label="账号" min-width="150" prop="email" />
      <el-table-column label="姓名" min-width="150" prop="name" />
      <el-table-column label="角色" min-width="150" prop="roleName" />
      <el-table-column label="操作" min-width="150">
        <template v-slot="scope">
          <el-button
            icon="el-icon-edit"
            size="small"
            type="primary"
            @click="editUser(scope.row)"
          >编辑</el-button>
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

    <el-dialog :visible.sync="dialogVisible" custom-class="user-dialog" :title="dialogTitle">
      <el-form ref="userForm" :rules="rules" :model="userForm">
        <el-form-item label="用户名" label-width="80px" prop="email">
          <el-input v-model="userForm.email" placeholder="请输入邮箱格式账号" />
        </el-form-item>
        <el-form-item label="密码" label-width="80px" prop="password">
          <el-input v-model="userForm.password" show-password placeholder="请输入6~20位密码" />
        </el-form-item>
        <el-form-item label="姓名" label-width="80px" prop="name">
          <el-input v-model="userForm.name" placeholder="请输入用户真实姓名" />
        </el-form-item>
        <el-form-item label="角色" label-width="80px" prop="role">
          <el-select v-model="userForm.role" placeholder="请选择">
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
import { getUserList, createUser, deleteUser, updateUser } from '@/api/user';
import infoList from '@/mixins/infoList';
export default {
  name: 'UserList',
  mixins: [infoList],
  data() {
    return {
      searchOptions: [
        { label: '账号', value: 'email' },
        { label: '姓名', value: 'name' },
      ],
      roleOptions: [
        { label: '客服人员', value: 'customer' },
        { label: '管理员', value: 'adminer' },
      ],
      listApi: getUserList,
      dialogVisible: false,
      dialogType: 'add',
      dialogTitle: '添加用户',
      userForm: {
        uuid: '',
        email: '',
        password: '',
        name: '',
        role: '',
      },
      rules: {
        email: [
          { required: true, message: '请输入邮箱账号', trigger: 'blur' },
          { type: 'email', message: '请输入正确的邮箱账号', trigger: ['blur', 'change'] },
        ],
        password: [
          { required: true, message: '请输入用户密码', trigger: 'blur' },
          { min: 6, message: '最低6位字符', trigger: 'blur' },
          { max: 20, message: '最多20位字符', trigger: 'blur' },
        ],
        name: [
          { required: true, message: '请输入真实姓名', trigger: 'blur' },
        ],
        role: [
          { required: true, message: '请选择用户角色', trigger: 'blur' },
        ],
      },
    };
  },
  async created() {
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
      this.dialogTitle = '添加用户';
      this.dialogType = 'add';
      this.dialogVisible = true;
    },
    // 编辑数据
    editUser(row) {
      this.dialogTitle = '编辑用户';
      this.dialogType = 'edit';
      for (const key in this.userForm) {
        this.userForm[key] = row[key];
      }
      this.dialogVisible = true;
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
        const res = await deleteUser({ uuid: row.uuid });
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
          switch (this.dialogType) {
            case 'add':
              {
                const res = await createUser(this.userForm);
                if (res.code === '000000') {
                  this.$message({ type: 'success', message: '添加成功!' });
                }
              }
              break;
            case 'edit':
              {
                const res = await updateUser(this.userForm);
                if (res.code === '000000') {
                  this.$message({ type: 'success', message: '编辑成功!' });
                }
              }
              break;
          }
          await this.getTableData();
          this.closeDialog();
        }
      });
    },
    // 初始化表单
    resetForm() {
      if (this.$refs.userForm) {
        this.$refs.userForm.resetFields();
      }
      for (const key in this.userForm) {
        this.userForm[key] = '';
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

.user-dialog {
  .header-img-box {
    width: 200px;
    height: 200px;
    border: 1px dashed #ccc;
    border-radius: 20px;
    text-align: center;
    line-height: 200px;
    cursor: pointer;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409eff;
  }
  .avatar-uploader-icon {
    border: 1px dashed #d9d9d9 !important;
    border-radius: 6px;
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
}
</style>
