import { getInfo } from '@/api/team';

// 配合权限指令使用
export const team = {
  namespaced: true,
  state: {
    asyncTeamInfo: {},
    asyncTeamRole: 'guest',
  },
  mutations: {
    setTeamInfo(state, info) {
      state.asyncTeamInfo = info;
    },
    setTeamRole(state, role) {
      state.asyncTeamRole = role;
    },
  },
  actions: {
    async setTeamInfo({ commit, state }, tid) {
      if (parseInt(tid) > 0){
        const res = await getInfo({ id: tid });
        if (res.code === '000000') {
          commit('setTeamInfo', res.data);
          commit('setTeamRole', res.data.role);
        } else {
          commit('setTeamInfo', {});
          commit('setTeamRole', 'guest');
        }
      } else {
        commit('setTeamInfo', {});
        commit('setTeamRole', 'guest');
      }
      return true;
    },
    setTeamEmpty({ commit }) {
      commit('setTeamInfo', {});
      commit('setTeamRole', 'guest');
    },
  },
  getters: {
    teamInfo(state){
      return state.asyncTeamInfo;
    },
    teamRole(state){
      return state.asyncTeamRole;
    },
  },
};
