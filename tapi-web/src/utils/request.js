import axios from 'axios'; // 引入axios
import { Message } from 'element-ui';
import { store } from '@/store/index';
import context from '@/main.js';
const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API,
  timeout: 5000,
});
let acitveAxios = 0;
let timer;
const showLoading = () => {
  acitveAxios++;
  if (timer) {
    clearTimeout(timer);
  }
  timer = setTimeout(() => {
    if (acitveAxios > 0) {
      context.$bus.emit('showLoading');
    }
  }, 400);
};

const closeLoading = () => {
  acitveAxios--;
  if (acitveAxios <= 0) {
    clearTimeout(timer);
    context.$bus.emit('closeLoading');
  }
};

// http request 拦截器
service.interceptors.request.use(
  config => {
    showLoading();
    const token = store.getters['user/token'];
    config.data = JSON.stringify(config.data);
    config.headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json, */*',
      'Authorization': 'Bearer ' + token,
    };
    return config;
  },
  error => {
    closeLoading();
    Message({
      showClose: true,
      message: error,
      type: 'error',
    });
    return error;
  },
);

// http response 拦截器  code msg data
service.interceptors.response.use(
  response => { // 200 请求码
    closeLoading();
    if (response.headers['authorization']) {
      store.commit('user/setToken', response.headers['authorization']);
      response.data.token = response.headers['authorization'];
    }
    // 正常请求或者列表页请求
    if (response.data.code === '000000' || response.data.code === undefined) {
      return response.data;
    } else {
      Message({
        showClose: true,
        message: response.data.msg || 'unknown error',
        type: 'error',
      });
      return response.data.msg ? response.data.msg : response;
    }
  },
  error => {
    console.log('error', error.response);
    closeLoading();
    if (error.response.status === 401){ // 需要退出的状态码
      store.commit('user/LoginOut');
      Message({
        showClose: true,
        message: '您的登录信息已过期,请重新登录',
        type: 'error',
      });
    } else if (error.response.status === 403){
      Message({
        showClose: true,
        message: '您的操作权限不足',
        type: 'error',
      });
    } else if (error.response.status === 404){
      Message({
        showClose: true,
        message: '您访问的资源不存在',
        type: 'error',
      });
    } else if (error.response.status >= 500){
      Message({
        showClose: true,
        message: '服务异常，请联系管理员',
        type: 'error',
      });
    } else {
      Message({
        showClose: true,
        message: error.message,
        type: 'error',
      });
    }
    return error;
  },
);

export default service;
