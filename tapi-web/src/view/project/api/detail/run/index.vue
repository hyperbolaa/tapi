<template>
  <div class="api-run">
    <div v-show="gotTapi === false" class="api-plugin">
      <el-alert
        type="warning"
        :closable="false"
        show-icon
      >
        <template slot="title">
          <div style="padding: 5px;">重要提示</div>
          <div style="padding: 5px;">
            当前的接口测试服务，需安装免费测试增强插件,仅支持 chrome 浏览器，安装方式请参考:  <el-link href="https://www.baidu.com" target="_blank">谷歌插件详细安装教程</el-link>
          </div>
        </template>
      </el-alert>
    </div>
    <div class="api-url">
      <el-row :gutter="10">
        <el-col :span="3">
          <el-select v-model="apiForm.method" disabled>
            <el-option
              v-for="item in methodOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-col>
        <el-col :span="8">
          <el-select v-model="runEnv" style="width: 100%;">
            <el-option
              v-for="item in runEnvOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-col>
        <el-col :span="9">
          <el-input v-model="apiForm.path" :disabled="true" />
        </el-col>
        <template v-if="gotTapi">
          <el-col :span="2">
            <el-tooltip effect="dark" content="发送请求" placement="bottom">
              <el-button type="primary" class="api-run-btn" :loading="loading" @click="submitApi()">发送</el-button>
            </el-tooltip>
          </el-col>
        </template>
        <template v-else>
          <el-col :span="2">
            <el-tooltip effect="dark" content="请安装 tapi 插件" placement="bottom">
              <el-button disabled>发送</el-button>
            </el-tooltip>
          </el-col>
        </template>
        <el-col :span="2">
          <el-tooltip effect="dark" class="api-run-btn" content="保存到测试集合" placement="bottom">
            <el-button type="primary">保存</el-button>
          </el-tooltip>
        </el-col>
      </el-row>
    </div>

    <div class="api-request">
      <template v-if="reqTabs.length > 0">
        <el-tabs v-model="activeReqTab" @tab-click="handleTabClick">
          <el-tab-pane
            v-for="(reqtab,reqtabindex) in reqTabs"
            :key="reqtabindex"
            :label="reqtab.label"
            :name="reqtab.name"
          >
            <template v-if="reqtab.name === 'req_param'">
              <div class="panel-sub">
                <div class="api-edit-item">
                  <el-row
                    v-for="(param,i1) in apiForm.req_param"
                    :key="i1"
                    :gutter="10"
                  >
                    <el-col :span="4"><el-input v-model="param.name" placeholder="参数名" /></el-col>
                    <el-col :span="2" class="equal">=</el-col>
                    <el-col :span="16">
                      <el-input v-model="param.value" placeholder="参数值" />
                    </el-col>
                  </el-row>
                </div>
              </div>
            </template>
            <template v-if="reqtab.name === 'req_query'">
              <div class="panel-sub">
                <div class="api-edit-item">
                  <el-row
                    v-for="(query,i2) in apiForm.req_query"
                    :key="i2"
                    :gutter="10"
                  >
                    <el-col :span="4"><el-input v-model="query.name" placeholder="参数名" /></el-col>
                    <el-col :span="2" class="equal">=</el-col>
                    <el-col :span="16">
                      <el-input v-model="query.value" placeholder="参数值" />
                    </el-col>
                  </el-row>
                </div>
              </div>
            </template>
            <template v-if="reqtab.name === 'req_header'">
              <div class="panel-sub">
                <div class="api-edit-item">
                  <el-row
                    v-for="(header,i3) in apiForm.req_header"
                    :key="i3"
                    :gutter="10"
                  >
                    <el-col :span="4"><el-input v-model="header.name" placeholder="参数名" /></el-col>
                    <el-col :span="2" class="equal">=</el-col>
                    <el-col :span="16">
                      <el-input v-model="header.value" placeholder="参数值" />
                    </el-col>
                  </el-row>
                </div>
              </div>
            </template>
            <template v-if="reqtab.name === 'req_body_form'">
              <div class="panel-sub">
                <div class="api-edit-item">
                  <el-row
                    v-for="(form,i4) in apiForm.req_body_form"
                    :key="i4"
                    :gutter="10"
                  >
                    <el-col :span="4"><el-input v-model="form.name" placeholder="参数名" /></el-col>
                    <el-col :span="2" class="equal">=</el-col>
                    <el-col :span="16">
                      <el-input v-model="form.value" placeholder="参数值" />
                    </el-col>
                  </el-row>
                </div>
              </div>
            </template>
            <template v-else-if="reqtab.name === 'req_body_json'">
              <div class="api-run-editor">
                <codemirror
                  ref="req_body_mirror"
                  :value="codemirrorReq"
                  :options="reqCmOptions"
                  class="code"
                />
              </div>
            </template>
          </el-tab-pane>
        </el-tabs>
      </template>
    </div>

    <div class="api-response">
      <el-tabs v-model="activeResTab">
        <el-tab-pane
          v-for="(restab,restabindex) in resTabs"
          :key="restabindex"
          :label="restab.label"
          :name="restab.name"
        >
          <template v-if="restab.name === 'res_body'">
            <HttpStatus :code="resData.status" :text="resData.statusText" />
            <div class="api-run-editor">
              <codemirror
                ref="res_body_mirror"
                :value="resBody"
                :options="resCmOptions"
                class="code"
              />
            </div>
          </template>
          <template v-if="restab.name === 'res_header'">
            <el-table :data="resHeader" row-key="id" border :show-header="false">
              <el-table-column prop="name" label="key" />
              <el-table-column prop="value" label="value" />
            </el-table>
          </template>
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>

<script>

import { codemirror } from 'vue-codemirror';
import 'codemirror/theme/ambiance.css'; // 这里引入的是主题样式，根据设置的theme的主题引入，一定要引入！！
require('codemirror/mode/javascript/javascript'); // 这里引入的模式的js，根据设置的mode引入，一定要引入！！

import { obj2Arr } from '@/utils/index.js';
import { handleRequestConfig } from '@/utils/chrome.js';
import HttpStatus from '@/components/httpstatus';
import options from '@/mixins/options';
import { mapGetters } from 'vuex';
import { store } from '@/store';
import { getEnvList } from '@/api/projectEnv';

export default {
  name: 'ApiRun',
  components: {
    codemirror,
    HttpStatus,
  },
  mixins: [options],
  data() {
    return {
      runEnv: '',
      runEnvOptions: [],
      apiForm: {},
      resData: {},
      resHeader: [],
      resBody: '',
      codemirrorReq: '',
      reqCmOptions: {
        tabSize: 4,
        mode: 'application/json', // 模式：json
        autofocus: true, // 聚焦
        lineNumbers: true, // 显示行
        matchBrackets: true, // 括号匹配
        lineWiseCopyCut: true,
        lineWrapping: true, // 支持滚动
        showCursorWhenSelecting: true, // 选中显示
      },
      resCmOptions: {
        tabSize: 4,
        mode: 'application/json', // 模式：json
        autofocus: true, // 聚焦
        lineNumbers: true, // 显示行
        matchBrackets: true, // 括号匹配
        lineWrapping: true, // 支持滚动
        readOnly: true, // 只读
      },
      activeReqTab: 'req_query',
      activeResTab: 'res_body',
      reqTabs: [],
      resTabs: [{ name: 'res_body', label: '响应内容' }, { name: 'res_header', label: '响应头部' }],
      loading: false,
      reqConfig: {
        config: {
          method: 'get',
          url: 'http://127.0.0.1/index.php?r=sss',
        },
        params: {
          queryParams: [],
          headerParams: [
            { 'name': 'Content-Type', 'value': 'application/json', 'required': true },
          ],
          bodyType: 'form',
          bodyParams: [],
        },
      },
    };
  },
  computed: {
    ...mapGetters('api', ['apiInfo']),
    gotTapi() {
      return typeof tapi !== 'undefined';
    },
  },
  mounted() {
    this.$bus.on('apiChange', () => {
      const apiInfo = store.getters['api/apiInfo'];
      this.apiForm = JSON.parse(JSON.stringify(apiInfo));// 个方法是完全复制了一个新的对象
      this.validTabs();
    });
  },
  created() {
    this.apiForm = JSON.parse(JSON.stringify(this.apiInfo));// 个方法是完全复制了一个新的对象
    this.validTabs();
    this.defaultEnv();
  },
  destroyed(){
    this.$bus.$off('apiChange');
  },
  methods: {
    async defaultEnv(){
      const defaultEnv = [{ name: 'local', protocol: 'http://', domain: '127.0.0.1' }];
      const res = await getEnvList({ pid: this.apiForm.pid });
      const options = res.data.length > 0 ? res.data : defaultEnv;
      options.forEach(item => {
        this.runEnvOptions.push({ label: item.name + ': ' + item.protocol + item.domain, value: item.protocol + item.domain });
      });
      this.runEnv = this.runEnvOptions[0].value;
    },
    handleTabClick(tab){
      if (tab.label === 'Body'){
        this.formatStr2Json();
      }
    },
    validTabs(){
      this.reqTabs = [];
      if (this.apiForm.req_param.length > 0){
        this.reqTabs.push({ 'name': 'req_param', 'label': 'PathParameters' });
      }
      if (this.apiForm.req_query.length > 0){
        this.reqTabs.push({ 'name': 'req_query', 'label': 'QueryParameters' });
      }
      if (this.apiForm.req_header.length > 0){
        this.reqTabs.push({ 'name': 'req_header', 'label': 'Headers' });
      }
      if (this.apiForm.req_body_type === 'form' && this.apiForm.req_body_form.length > 0){
        this.reqTabs.push({ 'name': 'req_body_form', 'label': 'Body' });
      }
      if (this.apiForm.req_body_type === 'json' && this.apiForm.req_body_json !== ''){
        this.reqTabs.push({ 'name': 'req_body_json', 'label': 'Body' });
      }
      this.activeReqTab = this.reqTabs.length > 0 ? this.reqTabs[0].name : '';
      this.formatStr2Json();
    },
    formatStr2Json(){
      if (this.apiForm.req_body_json_string){
        setTimeout(() => { // 重新聚焦
          this.$refs.req_body_mirror[0].codemirror.refresh();
        }, 50);
        this.codemirrorReq = JSON.stringify(JSON.parse(this.apiForm.req_body_json_string), null, 4);
      }
    },
    submitApi(){
      this.loading = true;
      const requestConfig = handleRequestConfig(this.apiForm, this.runEnv);
      console.log('config', requestConfig);
      window.tapi.request(requestConfig).then(response => {
        this.loading = false;
        this.resData = response;
        this.resHeader = obj2Arr(response.headers);
        this.resBody = JSON.stringify(response.data, null, 4);
      }).catch(error => {
        this.loading = false;
        console.log('submitError', error);
      });
    },
  },
};
</script>

<style lang="scss">
.api-run .api-url{
  margin: 20px 10px;
}
.api-run-editor{
  font-size: 14px;
  border: 1px solid #d3d3d3;
  border-radius: 5px;
  overflow: auto;
  margin-bottom: 40px;
}
.admin-box .api-run .api-run-btn{
  padding-left: 20px;
  padding-right: 20px;
}
.api-run .equal{
  text-align: center;
  height: 30px;
  line-height: 30px;
}
</style>
