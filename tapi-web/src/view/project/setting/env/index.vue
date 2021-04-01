<template>
  <div class="right_container">
    <div class="search-term">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item label="环境名称">
          <el-input v-model="searchInfo.keyword" placeholder="请输入查询环境名称" />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchData">查询</el-button>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addEnv()">添加环境</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="环境名称" min-width="250" prop="name" />
      <el-table-column label="环境域名" min-width="150" prop="httpUrl" />
      <el-table-column label="操作" min-width="150">
        <template v-slot="scope">
          <el-button
            icon="el-icon-document-edit"
            size="small"
            type="primary"
            @click="editEnv(scope.row)"
          >编辑</el-button>
          <el-button
            icon="el-icon-delete"
            size="small"
            type="danger"
            @click="deleteEnv(scope.row)"
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

    <el-dialog :visible.sync="dialogVisible" custom-class="env-dialog" :title="dialogTitle">
      <el-form ref="envForm" :rules="rules" :model="envForm">
        <el-form-item label="名称" label-width="100px" prop="name">
          <el-input v-model="envForm.name" placeholder="请输入环境名称" />
        </el-form-item>
        <el-form-item label="域名" label-width="100px" prop="domain">
          <el-input v-model="envForm.domain" placeholder="请输入内容">
            <el-select slot="prepend" v-model="envForm.protocol" style="width: 110px;">
              <el-option
                v-for="item in protocolOptions"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitEnv">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
// 获取列表内容封装在mixins内部  getTableData方法 初始化已封装完成
import { getEnvList, createEnv, deleteEnv, updateEnv } from '@/api/projectEnv';
import projectList from '@/mixins/projectList';
export default {
  name: 'ProjectEnv',
  mixins: [projectList],
  data() {
    return {
      pid: 0,
      listApi: getEnvList,
      dialogVisible: false,
      dialogType: 'add',
      dialogTitle: '添加环境',
      protocolOptions: [{ value: 'http://', label: 'http://' }, { value: 'https://', label: 'https://' }],
      envForm: {
        id: '',
        pid: '',
        name: '',
        protocol: 'http://',
        domain: '',
      },
      rules: {
        name: [
          { required: true, message: '请输入环境名称', trigger: 'blur' },
        ],
        domain: [
          { required: true, message: '请输入环境域名', trigger: 'blur' },
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
    // 添加环境
    addEnv() {
      this.resetForm();
      this.dialogTitle = '添加环境';
      this.dialogType = 'add';
      this.dialogVisible = true;
      this.envForm.pid = this.pid;
    },
    // 编辑数据
    editEnv(row) {
      this.dialogTitle = '编辑环境';
      this.dialogType = 'edit';
      for (const key in this.envForm) {
        this.envForm[key] = row[key];
      }
      this.dialogVisible = true;
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.envForm.resetFields();
      this.dialogVisible = false;
    },
    // 删除数据
    deleteEnv(row) {
      this.$confirm('此操作将永久删除该环境, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(async() => {
        const res = await deleteEnv({ id: row.id });
        if (res.code === '000000') {
          this.$message({ type: 'success', message: '删除成功!' });
          this.getTableData();
        }
      }).catch(() => {
        this.$message({ type: 'info', message: '已取消删除' });
      });
    },
    // 提交数据
    async submitEnv() {
      this.$refs.envForm.validate(async valid => {
        if (valid) {
          switch (this.dialogType) {
            case 'add':
              {
                const res = await createEnv(this.envForm);
                if (res.code === '000000') {
                  this.$message({ type: 'success', message: '添加成功!' });
                }
              }
              break;
            case 'edit':
              {
                const res = await updateEnv(this.envForm);
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
      if (this.$refs.envForm) {
        this.$refs.envForm.resetFields();
      }
      for (const key in this.envForm) {
        if (key !== 'protocol'){
          this.envForm[key] = '';
        }
      }
    },
  },
};
</script>
<style lang="scss">

</style>
