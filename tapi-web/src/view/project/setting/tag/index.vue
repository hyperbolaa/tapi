<template>
  <div class="right_container">
    <div class="search-term">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item label="标签名称">
          <el-input v-model="searchInfo.keyword" placeholder="请输入标签名称" />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchData">查询</el-button>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addTag()">添加标签</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="名称" min-width="150" prop="name" />
      <el-table-column label="备注" min-width="200" prop="desc" />
      <el-table-column label="操作">
        <template v-slot="scope">
          <el-button
            icon="el-icon-document-edit"
            size="small"
            type="primary"
            @click="editTag(scope.row)"
          >编辑</el-button>
          <el-button
            icon="el-icon-delete"
            size="small"
            type="danger"
            @click="deleteTag(scope.row)"
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

    <el-dialog :visible.sync="dialogVisible" custom-class="tag-dialog" :title="dialogTitle">
      <el-form ref="tagForm" :rules="rules" :model="tagForm">
        <el-form-item label="名称" label-width="100px" prop="name">
          <el-input v-model="tagForm.name" placeholder="请输入标签名称" />
        </el-form-item>
        <el-form-item label="备注" label-width="100px" prop="desc">
          <el-input v-model="tagForm.desc" placeholder="请输入标签备注" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitTag">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
// 获取列表内容封装在mixins内部  getTableData方法 初始化已封装完成
import { getTagList, createTag, deleteTag, updateTag } from '@/api/projectTag';
import projectList from '@/mixins/projectList';
export default {
  name: 'ProjectTag',
  mixins: [projectList],
  data() {
    return {
      pid: 0,
      listApi: getTagList,
      dialogVisible: false,
      dialogType: 'add',
      dialogTitle: '添加标签',
      tagForm: {
        id: '',
        pid: '',
        name: '',
        desc: '',
      },
      rules: {
        name: [
          { required: true, message: '请输入标签名称', trigger: 'blur' },
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
    // 添加
    addTag() {
      this.resetForm();
      this.dialogTitle = '添加标签';
      this.dialogType = 'add';
      this.dialogVisible = true;
    },
    // 编辑数据
    editTag(row) {
      this.dialogTitle = '编辑标签';
      this.dialogType = 'edit';
      for (const key in this.tagForm) {
        this.tagForm[key] = row[key];
      }
      this.dialogVisible = true;
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.tagForm.resetFields();
      this.dialogVisible = false;
    },
    // 删除数据
    deleteTag(row) {
      this.$confirm('此操作将永久删除该标签, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(async() => {
        const res = await deleteTag({ id: row.id });
        if (res.code === '000000') {
          this.$message({ type: 'success', message: '删除成功!' });
          this.getTableData();
        }
      }).catch(() => {
        this.$message({ type: 'info', message: '已取消删除' });
      });
    },
    // 提交数据
    async submitTag() {
      this.$refs.tagForm.validate(async valid => {
        if (valid) {
          switch (this.dialogType) {
            case 'add':
              {
                this.tagForm.pid = this.pid;
                const res = await createTag(this.tagForm);
                if (res.code === '000000') {
                  this.$message({ type: 'success', message: '添加成功!' });
                }
              }
              break;
            case 'edit':
              {
                this.tagForm.pid = this.pid;
                const res = await updateTag(this.tagForm);
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
      if (this.$refs.tagForm) {
        this.$refs.tagForm.resetFields();
      }
      for (const key in this.tagForm) {
        this.tagForm[key] = '';
      }
    },
  },
};
</script>
<style lang="scss">

</style>
