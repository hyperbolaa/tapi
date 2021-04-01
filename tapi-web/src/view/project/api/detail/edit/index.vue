<template>
  <div class="api-edit">
    <el-form ref="form" :model="apiForm" label-width="100px">
      <h2 class="api-title">基本设置</h2>
      <div class="panel-sub">
        <el-form-item label="接口名称">
          <el-input v-model="apiForm.name" />
        </el-form-item>
        <el-form-item label="选择分类">
          <el-select v-model="apiForm.cat_id" style="width: 100%;">
            <el-option
              v-for="item in projectInfo.cats"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="接口路径">
          <el-row style="padding: 0;">
            <el-col :span="4">
              <el-select v-model="apiForm.method" placeholder="请选择">
                <el-option
                  v-for="item in methodOptions"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-col>
            <el-col :span="4">
              <el-tooltip content="接口基本路径，可在 项目设置 里修改" placement="top">
                <el-input v-model="apiForm.pj.path" disabled />
              </el-tooltip>
            </el-col>
            <el-col :span="16">
              <el-input v-model="apiForm.path" placeholder="请输入内容" @input="pathnameChange" />
            </el-col>
          </el-row>
          <template v-if="apiForm.req_param.length > 0">
            <el-row
              v-for="(rp,index) in apiForm.req_param"
              :key="index"
              :gutter="10"
            >
              <el-col :span="6">
                <el-input v-model="rp.name" disabled placeholder="参数名" />
              </el-col>
              <el-col :span="8">
                <el-input v-model="rp.value" placeholder="参数示例" />
              </el-col>
              <el-col :span="10">
                <el-input v-model="rp.desc" placeholder="备注" />
              </el-col>
            </el-row>
          </template>
        </el-form-item>
        <el-form-item label="标签">
          <el-select v-model="apiForm.tag_id" style="width: 100%;">
            <el-option
              v-for="item in projectInfo.tags"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="状态">
          <el-select v-model="apiForm.status" style="width: 100%;">
            <el-option
              v-for="item in statusOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
      </div>

      <h2 class="api-title">请求参数设置</h2>
      <el-tabs v-model="requestTab">
        <el-tab-pane label="Query" name="query">
          <div class="panel-sub">
            <div class="api-edit-item">
              <el-row>
                <el-col :span="12">
                  <el-button type="primary" @click="addReqQuery">添加Query参数</el-button>
                </el-col>
              </el-row>
              <draggable
                v-model="apiForm.req_query"
                handle=".el-icon-sort"
                v-bind="dragOptions"
                @start="drag=true"
                @end="drag=false"
              >
                <el-row
                  v-for="(rq,index) in apiForm.req_query"
                  :key="index"
                  :gutter="10"
                >
                  <el-col :span="1">
                    <div class="request-icon">
                      <i class="el-icon-sort" />
                    </div>
                  </el-col>
                  <el-col :span="4"><el-input v-model="rq.name" placeholder="名称" /></el-col>
                  <el-col :span="3">
                    <el-select v-model="rq.datatype">
                      <el-option
                        v-for="item in dataTypeOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-col>
                  <el-col :span="3">
                    <el-select v-model="rq.required">
                      <el-option
                        v-for="item in requiredOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-col>
                  <el-col :span="5">
                    <el-input v-model="rq.value" placeholder="参数示例" />
                  </el-col>
                  <el-col :span="6">
                    <el-input v-model="rq.desc" placeholder="备注" />
                  </el-col>
                  <el-col :span="2">
                    <div class="request-icon">
                      <i class="el-icon-close" title="删除" @click="removeReqQuery(rq)" />
                    </div>
                  </el-col>
                </el-row>
              </draggable>
            </div>
          </div>
        </el-tab-pane>
        <el-tab-pane label="Header" name="header">
          <div class="panel-sub">
            <div class="api-edit-item">
              <el-row>
                <el-col :span="12">
                  <el-button type="primary" @click="addReqHeader">添加Header参数</el-button>
                </el-col>
              </el-row>
              <draggable
                v-model="apiForm.req_header"
                handle=".el-icon-sort"
                v-bind="dragOptions"
                @start="drag=true"
                @end="drag=false"
              >
                <el-row
                  v-for="(rh,index) in apiForm.req_header"
                  :key="index"
                  :gutter="10"
                >
                  <el-col :span="1">
                    <div class="request-icon">
                      <i class="el-icon-sort" />
                    </div>
                  </el-col>
                  <el-col :span="5">
                    <el-input v-model="rh.name" placeholder="参数名" />
                  </el-col>
                  <el-col :span="5">
                    <el-input v-model="rh.value" placeholder="参数值" />
                  </el-col>
                  <el-col :span="7">
                    <el-input v-model="rh.desc" placeholder="备注" />
                  </el-col>
                  <el-col :span="1">
                    <div class="request-icon">
                      <i class="el-icon-close" title="删除" @click="removeReqHeader(rh)" />
                    </div>
                  </el-col>
                </el-row>
              </draggable>
            </div>
          </div>
        </el-tab-pane>
        <el-tab-pane label="Body" name="body">
          <div class="panel-sub">
            <div class="api-edit-item">
              <el-row>
                <el-col :span="12">
                  <el-radio-group v-model="apiForm.req_body_type">
                    <el-radio label="none">none</el-radio>
                    <el-radio label="form">form</el-radio>
                    <el-radio label="json">json</el-radio>
                  </el-radio-group>
                </el-col>
              </el-row>
              <template v-if="apiForm.req_body_type === 'form'">
                <el-row>
                  <el-col :span="12">
                    <el-button type="primary" @click="addReqBodyForm">添加Form参数</el-button>
                  </el-col>
                </el-row>
                <draggable
                  v-model="apiForm.req_body_form"
                  handle=".el-icon-sort"
                  v-bind="dragOptions"
                  @start="drag=true"
                  @end="drag=false"
                >
                  <el-row
                    v-for="(rbf,index) in apiForm.req_body_form"
                    :key="index"
                    :gutter="10"
                  >
                    <el-col :span="1">
                      <div class="request-icon">
                        <i class="el-icon-sort" />
                      </div>
                    </el-col>
                    <el-col :span="4"><el-input v-model="rbf.name" placeholder="名称" /></el-col>
                    <el-col :span="3">
                      <el-select v-model="rbf.datatype">
                        <el-option
                          v-for="item in dataTypeOptions"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                        />
                      </el-select>
                    </el-col>
                    <el-col :span="3">
                      <el-select v-model="rbf.required">
                        <el-option
                          v-for="item in requiredOptions"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                        />
                      </el-select>
                    </el-col>
                    <el-col :span="5">
                      <el-input v-model="rbf.value" placeholder="参数示例" />
                    </el-col>
                    <el-col :span="6">
                      <el-input v-model="rbf.desc" placeholder="备注" />
                    </el-col>
                    <el-col :span="2">
                      <div class="request-icon">
                        <i class="el-icon-close" title="删除" @click="removeReqBodyForm(rbf)" />
                      </div>
                    </el-col>
                  </el-row>
                </draggable>
              </template>
              <template v-else-if="apiForm.req_body_type === 'json'">
                <el-row>
                  <el-col :span="12">
                    <el-button type="primary" @click="addReqBodyJson">添加 Json 参数</el-button>
                    <el-button type="primary">导入 Json</el-button>
                  </el-col>
                </el-row>
                <el-tree
                  ref="tree"
                  :data="apiForm.req_body_json"
                  node-key="id"
                  :expand-on-click-node="false"
                  :default-expand-all="true"
                  class="json-tree"
                >
                  <div slot-scope="{ node, data }" class="json-tree-node">
                    <template>
                      <el-row :gutter="24">
                        <el-col :span="8">
                          <el-input v-model="data.name" placeholder="名称" />
                        </el-col>
                        <el-col :span="3">
                          <el-select v-model="data.datatype">
                            <el-option
                              v-for="item in dataTypeOptions"
                              :key="item.value"
                              :label="item.label"
                              :value="item.value"
                            />
                          </el-select>
                        </el-col>
                        <el-col :span="3">
                          <el-select v-model="data.required">
                            <el-option
                              v-for="item in requiredOptions"
                              :key="item.value"
                              :label="item.label"
                              :value="item.value"
                            />
                          </el-select>
                        </el-col>
                        <el-col :span="4">
                          <el-input v-model="data.value" placeholder="参数示例" />
                        </el-col>
                        <el-col :span="4">
                          <el-input v-model="data.desc" placeholder="备注" />
                        </el-col>
                        <el-col :span="1">
                          <div class="request-icon">
                            <i class="el-icon-plus" title="添加子参数" @click="appendReqBodyJson(data)" />
                          </div>
                        </el-col>
                        <el-col :span="1">
                          <div class="request-icon">
                            <i class="el-icon-close" title="删除" @click="removeReqBodyJson(node,data)" />
                          </div>
                        </el-col>
                      </el-row>
                    </template>
                  </div>
                </el-tree>
              </template>
              <template v-else>
                <div class="body-none">此请求没有正文</div>
              </template>
            </div>
          </div>
        </el-tab-pane>
      </el-tabs>

      <h2 class="api-title">返回数据设置</h2>
      <div class="panel-sub">
        <div class="api-edit-item">
          <el-row>
            <el-col :span="12">
              <el-button type="primary" @click="addResBody">添加 Json 数据</el-button>
              <el-button type="primary">导入 Json</el-button>
            </el-col>
          </el-row>

          <el-tree
            ref="tree"
            :data="apiForm.res_body"
            node-key="id"
            :expand-on-click-node="false"
            :default-expand-all="true"
            class="json-tree"
          >
            <div slot-scope="{ node, data }" class="json-tree-node">
              <template>
                <el-row :gutter="24">
                  <el-col :span="8">
                    <el-input v-model="data.name" placeholder="名称" />
                  </el-col>
                  <el-col :span="3">
                    <el-select v-model="data.datatype">
                      <el-option
                        v-for="item in dataTypeOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-col>
                  <el-col :span="3">
                    <el-select v-model="data.required">
                      <el-option
                        v-for="item in requiredOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-col>
                  <el-col :span="4">
                    <el-input v-model="data.value" placeholder="参数示例" />
                  </el-col>
                  <el-col :span="4">
                    <el-input v-model="data.desc" placeholder="备注" />
                  </el-col>
                  <el-col :span="1">
                    <div class="request-icon">
                      <i class="el-icon-plus" title="添加子参数" @click="appendResBody(data)" />
                    </div>
                  </el-col>
                  <el-col :span="1">
                    <div class="request-icon">
                      <i class="el-icon-close" title="删除" @click="removeResBody(node,data)" />
                    </div>
                  </el-col>
                </el-row>
              </template>
            </div>
          </el-tree>
        </div>
      </div>

      <h2 class="api-title">备 注</h2>
      <div class="panel-sub">
        <el-input
          v-model="apiForm.desc"
          type="textarea"
          :rows="2"
          placeholder="请输入备注内容"
        />
      </div>

      <sticky :z-index="100">
        <el-button type="primary" @click="submitForm">保存</el-button>
      </sticky>
    </el-form>
  </div>
</template>

<script>
import sticky from '@/components/sticky'; // 粘性header组件
import { updateApi } from '@/api/api';
import options from '@/mixins/options';
import draggable from 'vuedraggable';
import { mapGetters } from 'vuex';
import { store } from '@/store';
import { handleVarPath } from '@/utils/stringFun';

export default {
  name: 'ApiEdit',
  components: { sticky, draggable },
  mixins: [options],
  data() {
    return {
      drag: false,
      requestTab: 'query', // request tab
      // 基本信息
      apiForm: {},
      // 提交数据结构
      newForm: {
        id: 0,
        pid: 0,
        name: '',
        cat_id: '',
        tag_id: '',
        method: '',
        path: '',
        desc: '',
        status: '',
        res_body_type: 'json',
        req_body_type: 'form',
        req_param: [],
        req_query: [],
        req_header: [],
        req_body_json: [],
        req_body_form: [],
        res_body: [],
      },
    };
  },
  computed: {
    ...mapGetters('project', ['projectInfo']),
    ...mapGetters('api', ['apiInfo']),
    dragOptions() {
      return {
        animation: 200, // 动画时间
        disabled: false, // false可拖拽，true不可拖拽
      };
    },
  },
  mounted() {
    this.$bus.on('apiChange', () => {
      const apiInfo = store.getters['api/apiInfo'];
      this.apiForm = JSON.parse(JSON.stringify(apiInfo));
      this.initForm();
    });
  },
  created() {
    this.apiForm = JSON.parse(JSON.stringify(this.apiInfo));// 个方法是完全复制了一个新的对象
    this.initForm();
  },
  destroyed(){
    this.$bus.$off('apiChange');
  },
  methods: {
    initForm(){ // 初始化表信息
      if (this.apiForm.req_query.length === 0){
        this.addReqQuery();
      }
      if (this.apiForm.req_header.length === 0){
        this.addReqHeader();
      }
      if (this.apiForm.req_body_form.length === 0){
        this.addReqBodyForm();
      }
      if (this.apiForm.req_body_json.length === 0) {
        this.addReqBodyJson();
      }
    },
    addReqQuery(){
      const model = { name: '', datatype: 'String', required: 1, value: '', desc: '', id: Date.now() };
      this.apiForm.req_query.push(model);
    },
    removeReqQuery(item) {
      const index = this.apiForm.req_query.indexOf(item);
      if (index !== -1) {
        this.apiForm.req_query.splice(index, 1);
      }
    },
    addReqHeader(){
      const model = { name: '', value: '', desc: '', id: Date.now() };
      this.apiForm.req_header.push(model);
    },
    removeReqHeader(item){
      const index = this.apiForm.req_header.indexOf(item);
      if (index !== -1) {
        this.apiForm.req_header.splice(index, 1);
      }
    },
    addReqBodyForm(){
      const model = { name: '', datatype: 'String', required: 1, value: '', desc: '', id: Date.now() };
      this.apiForm.req_body_form.push(model);
    },
    removeReqBodyForm(item){
      const index = this.apiForm.req_body_form.indexOf(item);
      if (index !== -1) {
        this.apiForm.req_body_form.splice(index, 1);
      }
    },
    addReqBodyJson(){
      const model = { id: Date.now(), name: '', datatype: 'String', required: 1, value: '', desc: '' };
      this.apiForm.req_body_json.push(model);
    },
    appendReqBodyJson(data){
      const model = { id: Date.now(), name: '', datatype: 'String', required: 1, value: '', desc: '' };
      if (!data.children) {
        this.$set(data, 'children', []);
      }
      data.children.push(model);
    },
    removeReqBodyJson(node, data){
      const parent = node.parent;
      const children = parent.data.children || parent.data;
      const index = children.findIndex(d => d.id === data.id);
      children.splice(index, 1);
    },
    addResBody(){
      const model = { id: Date.now(), name: '', datatype: 'String', required: 1, value: '', desc: '' };
      this.apiForm.res_body.push(model);
    },
    appendResBody(data){
      const model = { id: Date.now(), name: '', datatype: 'String', required: 1, value: '', desc: '' };
      if (!data.children) {
        this.$set(data, 'children', []);
      }
      data.children.push(model);
    },
    removeResBody(node, data){
      const parent = node.parent;
      const children = parent.data.children || parent.data;
      const index = children.findIndex(d => d.id === data.id);
      children.splice(index, 1);
    },
    async submitForm() {
      this.makeData();
      const res = await updateApi(this.newForm);
      if (res.code === '000000') {
        this.$message({ type: 'success', message: '保存成功!' });
        this.$bus.emit('apiSave');
      }
    },
    makeData(){ // 构造数据
      for (const key in this.newForm) {
        this.newForm[key] = this.apiForm[key];
      }
    },
    pathnameChange(value){
      this.apiForm.req_param = [];
      handleVarPath(value, this.apiForm.req_param);
    },
  },
};
</script>

<style lang="scss">
.api-edit .api-title {
  clear: both;
  font-weight: 400;
  margin-top: 30px;
  margin-bottom: 10px;
  border-left: 3px solid #2395f1;
  padding-left: 8px;
}
.api-edit .panel-sub{
  background: rgba(236,238,241,.67);
  padding: 10px;
}
.api-edit .container-radiogroup {
  text-align: center;
  margin-bottom: 16px;
}
.api-edit .request-icon {
  text-align: center;
  height: 30px;
  line-height: 30px;
}
.sub-navbar {
  height: 50px;
  line-height: 50px;
  position: relative;
  width: 100%;
  text-align: center;
  background: #d0d0d0;
}
.json-tree .el-tree-node{
  padding: 10px 0;
}
.body-none{
  height: 200px;
  line-height: 200px;
  background-color: white;
  text-align: center;
}
.el-tree{
  background-color: transparent;
}
</style>
