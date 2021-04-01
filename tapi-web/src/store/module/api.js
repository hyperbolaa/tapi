import { getInfo } from '@/api/api';
// 配合权限指令使用
export const api = {
  namespaced: true,
  state: {
    asyncApiInfo: {},
  },
  mutations: {
    setApiInfo(state, info) {
      state.asyncApiInfo = info;
    },
  },
  actions: {
    async setApiInfo({ commit, state }, id) {
      if (parseInt(id) > 0){
        const res = await getInfo({ id: id });
        if (res.code === '000000') {
          commit('setApiInfo', res.data);
        } else {
          commit('setApiInfo', {});
        }
      } else {
        commit('setApiInfo', {});
      }
      return true;
    },
  },
  getters: {
    apiInfo(state){
      return state.asyncApiInfo;
    },
  },
};
