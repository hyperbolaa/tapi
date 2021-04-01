<template>
  <div class="api-prev">
    <h2 class="api-title">基本信息</h2>
    <div class="api-basic-view">
      <el-row>
        <el-col :span="4">接口名称:</el-col>
        <el-col :span="8">{{ apiData.name }}</el-col>
        <el-col :span="4">接口状态：</el-col>
        <el-col :span="8">{{ apiData.status | apiStatusMap }}</el-col>
      </el-row>
      <el-row>
        <el-col :span="4">编辑人员：</el-col>
        <el-col :span="8">{{ apiData.user.name }}</el-col>
        <el-col :span="4">更新时间：</el-col>
        <el-col :span="8">{{ apiData.created_at }}</el-col>
      </el-row>
      <el-row>
        <el-col :span="4">接口路径：</el-col>
        <el-col :span="2"><span style="background-color: rgb(207, 239, 223);">{{ apiData.method }}</span></el-col>
        <el-col :span="16"><div style="vertical-align: center;">{{ apiData.path }}</div></el-col>
      </el-row>
      <el-row>
        <el-col :span="4">标签：</el-col>
        <el-col :span="20">{{ apiData.tag ? apiData.tag.name : '' }}</el-col>
      </el-row>
    </div>
    <h2 class="api-title">备注</h2>
    <div class="api-desc-view" style=""><p>{{ apiData.desc ? apiData.desc : '暂无备注信息' }}</p></div>
    <h2 class="api-title">请求参数</h2>
    <template v-if="apiData.req_param.length > 0">
      <div class="col-param">
        <div class="col-title">路径参数：</div>
        <el-table :data="apiData.req_param" border>
          <el-table-column prop="name" label="参数名" />
          <el-table-column prop="value" label="示例值" />
          <el-table-column prop="desc" label="备注" />
        </el-table>
      </div>
    </template>
    <template v-if="apiData.req_query.length > 0">
      <div class="col-param">
        <div class="col-title">Query参数说明：</div>
        <el-table :data="apiData.req_query" border>
          <el-table-column prop="name" label="参数名" />
          <el-table-column prop="value" label="示例值" />
          <el-table-column prop="required" label="是否必填">
            <template v-slot="scope">
              <span>{{ scope.row.required | requiredMap }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="datatype" label="参数类型" />
          <el-table-column prop="desc" label="备注" />
        </el-table>
      </div>
    </template>
    <template v-if="apiData.req_header.length > 0">
      <div class="col-header">
        <div class="col-title">Header参数说明：</div>
        <el-table :data="apiData.req_header" border>
          <el-table-column prop="name" label="参数名" />
          <el-table-column prop="value" label="示例值" />
          <el-table-column prop="desc" label="备注" />
        </el-table>
      </div>
    </template>

    <template v-if="apiData.req_body_type == 'form'">
      <template v-if="apiData.req_body_form.length > 0">
        <div class="col-body">
          <div class="col-title">Body参数说明：</div>
          <el-table :data="apiData.req_body_form" border>
            <el-table-column prop="name" label="参数名" />
            <el-table-column prop="value" label="示例值" />
            <el-table-column prop="required" label="是否必填">
              <template v-slot="scope">
                <span>{{ scope.row.required | requiredMap }}</span>
              </template>
            </el-table-column>
            <el-table-column prop="datatype" label="参数类型" />
            <el-table-column prop="desc" label="备注" />
          </el-table>
        </div>
      </template>
    </template>
    <template v-if="apiData.req_body_type == 'json'">
      <template v-if="apiData.req_body_json.length > 0">
        <div class="col-body">
          <div class="col-title">Body参数说明：</div>
          <el-table :data="apiData.req_body_json" border>
            <el-table-column prop="name" label="参数名" />
            <el-table-column prop="value" label="示例值" />
            <el-table-column prop="required" label="是否必填">
              <template v-slot="scope">
                <span>{{ scope.row.required | requiredMap }}</span>
              </template>
            </el-table-column>
            <el-table-column prop="datatype" label="参数类型" />
            <el-table-column prop="desc" label="备注" />
          </el-table>
        </div>
      </template>
    </template>

    <h2 class="api-title">返回数据</h2>
    <template v-if="apiData.res_body.length > 0">
      <div class="col-result">
        <el-table :data="apiData.res_body" row-key="id" border>
          <el-table-column prop="name" label="名称" />
          <el-table-column prop="value" label="示例值" />
          <el-table-column prop="required" label="是否必须">
            <template v-slot="scope">
              <span>{{ scope.row.required | requiredMap }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="datatype" label="类型" />
          <el-table-column prop="desc" label="备注" />
        </el-table>
      </div>
    </template>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { store } from '@/store';

export default {
  name: 'ApiPrev',
  data() {
    return {
      apiData: {},
    };
  },
  computed: {
    ...mapGetters('api', ['apiInfo']),
  },
  mounted() {
    this.$bus.on('apiChange', () => {
      this.apiData = store.getters['api/apiInfo'];
    });
  },
  created() {
    this.apiData = this.apiInfo;
  },
  destroyed(){
    this.$bus.$off('apiChange');
  },
};
</script>

<style lang="scss">
.api-title{
  clear: both;
  font-weight: 400;
  margin-top: 20px;
  border-left: 3px solid #2395f1;
  padding-left: 8px;
}
.col-title{
  margin-bottom: 5px;
}
.api-basic-view{
  margin: 8px 0;
  padding: 16px;
  box-sizing: border-box;
}
.api-desc-view{
  margin: 0;
  padding: 0 20px;
  float: none;
}
.api-prev>div {
  margin: 8px 0;
  padding: 16px;
  width: 100%;
  box-sizing: border-box;
  float: left;
}
</style>
