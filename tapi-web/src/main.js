import Vue from 'vue';
import App from './App.vue';
// 引入element
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// 全局配置elementui的dialog不能通过点击遮罩层关闭
ElementUI.Dialog.props.closeOnClickModal.default = false;
Vue.use(ElementUI);
// 引入封装的router
import router from '@/router/index';
import { store } from '@/store';
import '@/permission'; // 路由权限限制
import * as filters from './filters'; // global filters
// register global utility filters
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

// markdown插件
import mavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';
Vue.use(mavonEditor);
// 代码编辑器
import VueCodeMirror from 'vue-codemirror';
import 'codemirror/lib/codemirror.css';
Vue.use(VueCodeMirror);

Vue.config.productionTip = false;

// 路由守卫
import Bus from '@/utils/bus.js';
Vue.use(Bus);

export default new Vue({
  render: h => h(App),
  router,
  store,
}).$mount('#app');
