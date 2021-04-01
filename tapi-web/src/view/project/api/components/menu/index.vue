<template>
  <div class="api-menu">
    <el-card class="project-category">
      <el-row :gutter="10">
        <el-col :span="16">
          <el-input
            v-model="filterText"
            placeholder="搜索接口"
            clearable
          />
        </el-col>
        <el-col :span="6" :offset="2">
          <el-button type="primary" style="float: right;" @click="addCat">添加分类</el-button>
        </el-col>
      </el-row>
      <div class="cont-menu" style="margin-top: 10px;">
        <el-tree
          ref="tree"
          :data="menuTreeData"
          node-key="key"
          highlight-current
          :filter-node-method="filterNode"
          :current-node-key="currentNodeKey"
          :expand-on-click-node="expandOnClickNode"
          :default-expand-all="defaultExpandAll"
          style="min-height: 500px;"
        >
          <span slot-scope="{ node, data }" class="custom-tree-node">
            <template v-if="data.type === 'cat'">
              <router-link :to="{ name: 'project-api-cat', params: { pid: pid,cid:data.id }}"><el-link icon="el-icon-folder-opened">{{ data.name | substrName(0,10) }}</el-link></router-link>
              <span>
                <el-tooltip content="添加接口" placement="top">
                  <i class="el-icon-plus" @click="() => addApi(data)" />
                </el-tooltip>
                <el-tooltip content="修改分类" placement="top">
                  <i class="el-icon-edit" @click="() => editCat(data)" />
                </el-tooltip>
                <el-tooltip content="删除分类" placement="top">
                  <i class="el-icon-delete" @click="() => delCat(data)" />
                </el-tooltip>
              </span>
            </template>
            <template v-else-if="data.type === 'api'">
              <router-link :to="{ name: 'project-api-detail', params: { pid: pid,did:data.id }}"><el-link icon="el-icon-document">{{ data.name | substrName(0,10) }}</el-link></router-link>
              <span>
                <el-tooltip content="删除接口" placement="top">
                  <i class="el-icon-delete" @click="() => delApi(data)" />
                </el-tooltip>
              </span>
            </template>
            <template v-else>
              <router-link :to="{ name: 'project-api-all', params: { pid: pid }}"><el-link icon="el-icon-files">{{ data.name }}</el-link></router-link>
            </template>
          </span>
        </el-tree>
      </div>
    </el-card>

    <el-dialog :visible.sync="dialogVisible" :title="dialogTitle">
      <el-form ref="menuForm" :rules="rules" :model="menuForm">
        <el-form-item label="分类名" label-width="100px" prop="name">
          <el-input v-model="menuForm.name" placeholder="请输入分类名称" />
        </el-form-item>
        <el-form-item label="备注" label-width="100px">
          <el-input v-model="menuForm.desc" placeholder="请输入分类备注" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitMenu">确 定</el-button>
      </div>
    </el-dialog>

    <el-dialog :visible.sync="dialogVisibleApi" title="添加接口">
      <el-form ref="apiForm" :rules="apiRules" :model="apiForm">
        <el-form-item label="接口分类" label-width="100px" prop="cat_id">
          <el-select v-model="apiForm.cat_id" placeholder="请选择" style="width: 100%;">
            <el-option v-for="item in menuData" :key="item.id" :label="item.name" :value="item.id" />
          </el-select>
        </el-form-item>
        <el-form-item label="接口名称" label-width="100px" prop="name">
          <el-input v-model="apiForm.name" placeholder="请输入接口名称" />
        </el-form-item>
        <el-form-item label="接口路径" label-width="100px" prop="path">
          <el-input v-model="apiForm.path" placeholder="请输入内容">
            <el-select slot="prepend" v-model="apiForm.method" style="width: 110px;">
              <el-option
                v-for="item in methodOptions"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-input>
        </el-form-item>
        <el-alert
          title="详细的接口数据可以在编辑页面中添加"
          type="info"
          :closable="false"
        />
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">取 消</el-button>
        <el-button type="primary" @click="submitApi">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getCatMenu, createCat, updateCat, deleteCat } from '@/api/apiCat';
import { createApi, deleteApi } from '@/api/api';
import options from '@/mixins/options';

export default {
  name: 'ApiMenu',
  mixins: [options],
  data() {
    return {
      pid: 0,
      cid: 0,
      did: 0,
      filterText: '',
      currentNodeKey: 'all',
      expandOnClickNode: false,
      defaultExpandAll: true,
      menuData: [],
      menuTreeData: [],
      dialogVisible: false,
      dialogType: 'add',
      dialogTitle: '添加分类',
      menuForm: {
        pid: 0,
        id: 0,
        name: '',
        desc: '',
      },
      rules: {
        name: [
          { required: true, message: '请输入分类名称', trigger: 'blur' },
        ],
      },
      dialogVisibleApi: false,
      apiForm: {
        pid: 0,
        cat_id: '',
        name: '',
        method: 'GET',
        path: '',
      },
      apiRules: {
        cat_id: [
          { required: true, message: '请选择接口分类', trigger: 'change' },
        ],
        name: [
          { required: true, message: '请输入接口名称', trigger: 'blur' },
        ],
        path: [
          { required: true, message: '请输入接口路径', trigger: 'blur' },
        ],
      },
    };
  },
  watch: {
    currentNodeKey(key) {
      // Tree 内部使用了 Node 类型的对象来包装用户传入的数据，用来保存目前节点的状态。可以用 $refs 获取 Tree 实例
      this.$refs['tree'].setCurrentKey(key);
    },
    filterText(val) {
      this.$refs.tree.filter(val);
    },
    $route() { // 因为组件缓存，必须监听路由
      this.initParam();
    },
  },
  mounted() { // 更新接口信息的时候， 名称可能更改， 需监听
    this.$bus.on('apiSave', () => {
      this.initParam();
      this.getMenuList();
    });
  },
  created() {
    this.initParam();
    this.getMenuList();
  },
  methods: {
    initParam(){
      this.pid = parseInt(this.$route.params.pid);
      const cid = parseInt(this.$route.params.cid);
      const did = parseInt(this.$route.params.did);
      if (isNaN(cid)){
        this.cid = 0;
      } else {
        this.currentNodeKey = 'cat_' + cid;
        this.cid = cid;
      }
      if (isNaN(did)){
        this.did = 0;
      } else {
        this.currentNodeKey = 'api_' + did;
        this.did = did;
      }
    },
    filterNode(value, data) {
      if (!value) {
        return true;
      }
      return data.name.indexOf(value) !== -1;
    },
    async getMenuList() { // 获取栏目一次性获取,含接口
      const res = await getCatMenu({ pid: this.pid });
      this.menuData = res.data;
      this.menuTreeData = [{ id: 0, name: '全部接口', type: 'all', key: 'all' }];
      this.menuTreeData = this.menuTreeData.concat(this.menuData);
    },
    // 添加用户
    addCat() {
      this.resetForm();
      this.dialogTitle = '添加分类';
      this.dialogType = 'add';
      this.menuForm.pid = this.pid;
      this.dialogVisible = true;
    },
    // 编辑数据
    editCat(row) {
      this.dialogTitle = '编辑分类';
      this.dialogType = 'edit';
      for (const key in this.menuForm) {
        this.menuForm[key] = row[key];
      }
      this.dialogVisible = true;
    },
    // 提交数据--不跳转， 只有提示信息
    async submitMenu() {
      this.$refs.menuForm.validate(async valid => {
        if (valid) {
          switch (this.dialogType) {
            case 'add':
              {
                const res = await createCat(this.menuForm);
                if (res.code === '000000') {
                  this.$message({ type: 'success', message: '接口分类添加成功!' });
                  await this.getMenuList();
                }
              }
              break;
            case 'edit':
              {
                const res = await updateCat(this.menuForm);
                if (res.code === '000000') {
                  this.$message({ type: 'success', message: '接口分类更新成功!' });
                  await this.getMenuList();
                }
              }
              break;
          }
          this.closeDialog();
        }
      });
    },
    // 关闭弹窗
    closeDialog() {
      this.$refs.menuForm.resetFields();
      this.dialogVisible = false;
    },
    // 初始化表单
    resetForm() {
      if (this.$refs.menuForm) {
        this.$refs.menuForm.resetFields();
      }
      for (const key in this.menuForm) {
        this.menuForm[key] = '';
      }
    },
    delCat(data) { // 跳转到所有接口类
      this.$confirm('该操作会删除该分类下所有接口，接口删除后无法恢复', '确定删除此接口分类吗?', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(async() => {
        const res = await deleteCat({ id: data.id });
        if (res.code === '000000') {
          this.$message({ type: 'success', message: '删除成功' });
          await this.getMenuList();
          if ('/console/project/' + this.pid + '/api/index' !== this.$route.path) {
            await this.$router.push({ name: 'project-api-all', params: { pid: this.pid }});
          }
        }
      }).catch(() => {
        this.$message({ type: 'info', message: '已取消删除' });
      });
    },
    delApi(row) { // 跳转到分类
      this.$confirm('接口删除后，无法恢复', '您确认删除此接口?', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning',
      }).then(async() => {
        const res = await deleteApi({ id: row.id });
        if (res.code === '000000') {
          this.$message({ type: 'success', message: '删除成功' });
          await this.getMenuList();

          if ('/console/project/' + this.pid + '/api/cat_' + row.cid !== this.$route.path) {
            await this.$router.push({ name: 'project-api-cat', params: { pid: this.pid, cid: row.cid }});
          }
        }
      }).catch(() => {
        this.$message({ type: 'info', message: '已取消删除' });
      });
    },
    // 添加
    addApi(row) {
      this.resetFormApi();
      this.apiForm.pid = this.pid;
      this.apiForm.method = 'GET';
      this.apiForm.cat_id = row.id;
      this.dialogVisibleApi = true;
    },
    // 提交数据
    async submitApi() {
      this.$refs.apiForm.validate(async valid => {
        if (valid) {
          const res = await createApi(this.apiForm);
          if (res.code === '000000') {
            this.$message({ type: 'success', message: '添加成功!' });
            await this.getMenuList();
            await this.$router.push({ name: 'project-api-detail', params: { pid: this.pid, did: res.data.id }});
          }
          this.closeDialogApi();
        }
      });
    },
    // 初始化表单
    resetFormApi() {
      if (this.$refs.apiForm) {
        this.$refs.apiForm.resetFields();
      }
      for (const key in this.apiForm) {
        this.apiForm[key] = '';
      }
    },
    // 关闭弹窗
    closeDialogApi() {
      this.$refs.apiForm.resetFields();
      this.dialogVisibleApi = false;
    },
  },
};
</script>
<style lang="scss">
.project-category .el-card__body{
  padding: 10px;
}
.custom-tree-node {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
}
.custom-tree-node .el-tooltip{
  padding: 0 5px;
}
.api-menu .el-tree-node.is-current>.el-tree-node__content{
  background-color: #d5ebfc;
}
</style>
