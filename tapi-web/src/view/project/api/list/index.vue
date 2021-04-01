<template>
  <div class="cont-project-Api">
    <el-row :gutter="10">
      <el-col :span="6">
        <ApiMenu />
      </el-col>
      <el-col :span="18">
        <div class="api-list-cont right_container">
          <div class="search-term">
            <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
              <el-form-item label="接口名称">
                <el-input v-model="searchInfo.name" clearable placeholder="请输入查询接口名称" />
              </el-form-item>
              <el-form-item label="接口状态">
                <el-select v-model="searchInfo.status" clearable placeholder="请选择">
                  <el-option
                    v-for="item in statusOptions"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="接口标签">
                <el-select v-model="searchInfo.tag" clearable filterable placeholder="请选择">
                  <el-option
                    v-for="item in projectInfo.tags"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  />
                </el-select>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" @click="searchData">查询</el-button>
              </el-form-item>
            </el-form>
          </div>

          <el-table :data="tableData" border stripe>
            <el-table-column label="接口名称" prop="name" min-width="100">
              <template v-slot="scope">
                <router-link :to="{ name: 'project-api-detail', params: { pid: scope.row.pid,did:scope.row.id }}">
                  <el-link icon="el-icon-document">{{ scope.row.name }}</el-link>
                </router-link>
              </template>
            </el-table-column>
            <el-table-column label="接口路径" min-width="300">
              <template v-slot="scope">
                <el-button type="info" size="small">{{ scope.row.method }}</el-button>
                <span style="margin-left: 10px;">{{ scope.row.path }}</span>
              </template>
            </el-table-column>
            <el-table-column label="接口分类" prop="cat_id">
              <template v-slot="scope">
                <el-select v-model="scope.row.cat_id" filterable placeholder="请选择" style="width: 100%;" @change="changeCat(scope.row)">
                  <el-option
                    v-for="item in projectInfo.cats"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  />
                </el-select>
              </template>
            </el-table-column>
            <el-table-column label="状态" prop="status">
              <template v-slot="scope">
                <el-select v-model="scope.row.status" placeholder="请选择" style="width: 100%;" @change="changeStatus(scope.row)">
                  <el-option
                    v-for="item in statusOptions"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </template>
            </el-table-column>
            <el-table-column label="标签" prop="tag_id">
              <template v-slot="scope">
                <el-select v-model="scope.row.tag_id" filterable placeholder="请选择" style="width: 100%;" @change="changeTag(scope.row)">
                  <el-option
                    v-for="item in projectInfo.tags"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  />
                </el-select>
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
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
// 获取列表内容封装在mixins内部  getTableData方法 初始化已封装完成
import ApiMenu from '@/view/project/api/components/menu';
import { getApiList, changeApiCat, changeApiStatus, changeApiTag } from '@/api/api';
import apiList from '@/mixins/apiList';
import options from '@/mixins/options';
import { mapGetters } from 'vuex';
export default {
  name: 'ApiList',
  components: { ApiMenu },
  mixins: [apiList, options],
  data() {
    return {
      pid: 0,
      cid: 0,
      listApi: getApiList,
    };
  },
  computed: {
    ...mapGetters('project', ['projectInfo']),
  },
  watch: {
    $route() {
      this.initParam();
    },
  },
  async created() {
    this.initParam();
  },
  methods: {
    initParam(){
      this.pid = parseInt(this.$route.params.pid);
      const cid = parseInt(this.$route.params.cid);
      if (isNaN(cid)){
        this.cid = 0;
      } else {
        this.cid = cid;
      }
      this.getTableData();
    },
    // 搜索
    searchData() {
      this.page = 1;
      this.getTableData();
    },
    async changeCat(row){
      const res = await changeApiCat({ id: row.id, cat_id: row.cat_id });
      if (res.code === '000000') {
        this.$message({ type: 'success', message: '修改成功!' });
      }
    },
    async changeStatus(row){
      const res = await changeApiStatus({ id: row.id, status: row.status });
      if (res.code === '000000') {
        this.$message({ type: 'success', message: '修改成功!' });
      }
    },
    async changeTag(row){
      const res = await changeApiTag({ id: row.id, tag_id: row.tag_id });
      if (res.code === '000000') {
        this.$message({ type: 'success', message: '修改成功!' });
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
.input-with-select .el-input-group__prepend {
  background-color: #fff;
}
</style>
