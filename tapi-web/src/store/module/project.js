import { getInfo } from '@/api/project';
// 配合权限指令使用
export const project = {
  namespaced: true,
  state: {
    asyncProjectInfo: {},
    asyncProjectRole: 'guest',
  },
  mutations: {
    setProjectInfo(state, info) {
      state.asyncProjectInfo = info;
    },
    setProjectRole(state, role) {
      state.asyncProjectRole = role;
    },
  },
  actions: {
    async setProjectInfo({ commit, state }, pid) {
      if (parseInt(pid) > 0){
        const res = await getInfo({ id: pid });
        if (res.code === '000000') {
          commit('setProjectInfo', res.data);
          commit('setProjectRole', res.data.role);
        } else {
          commit('setProjectInfo', {});
          commit('setProjectRole', 'guest');
        }
      } else {
        commit('setProjectInfo', {});
        commit('setProjectRole', 'guest');
      }
      return true;
    },
    setProjectEmpty({ commit }) {
      commit('setProjectInfo', {});
      commit('setProjectRole', 'guest');
    },
  },
  getters: {
    projectInfo(state){
      return state.asyncProjectInfo;
    },
    projectRole(state){
      return state.asyncProjectRole;
    },
  },
};
