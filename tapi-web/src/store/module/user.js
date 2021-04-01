import { login, getInfo, logout } from '@/api/auth';
import router from '@/router/index';

export const user = {
  namespaced: true,
  state: {
    userInfo: {
      uuid: '',
      name: '',
      avatar: '',
      role: '',
    },
    token: '',
    role: '',
  },
  mutations: {
    setUserInfo(state, userInfo) {
      state.userInfo = userInfo;
    },
    setToken(state, token) {
      state.token = token;
    },
    setRole(state, role) {
      state.role = role;
    },
    LoginOut(state) {
      state.userInfo = {};
      state.token = '';
      state.role = '';
      router.push({ name: 'login', replace: true });
      sessionStorage.clear();
      window.location.reload();
    },
  },
  actions: {
    async LoginIn({ commit }, loginInfo) {
      const res = await login(loginInfo);
      if (res.code === '000000') {
        const token = res.token;
        commit('setToken', token);
        // 这个地方出现错误一般是跳转的路由不存在
        router.push({ path: '/console/dashboard' }).catch(() => {
          console.log('login done');
        });
      }
    },
    async getInfo({ commit }) {
      const res = await getInfo();
      if (res.code === '000000') {
        const userinfo = res.data;
        const role = userinfo.role;
        commit('setUserInfo', userinfo);
        commit('setRole', role);
      }
    },
    async LoginOut({ commit }) {
      const res = await logout();
      if (res.code === '000000') {
        commit('LoginOut');
      }
    },
  },
  getters: {
    userInfo(state) {
      return state.userInfo;
    },
    token(state) {
      return state.token;
    },
    role(state) {
      return state.role;
    },
  },
};
