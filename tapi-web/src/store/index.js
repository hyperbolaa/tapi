import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';

import { user } from '@/store/module/user';
import { team } from '@/store/module/team';
import { project } from '@/store/module/project';
import { api } from '@/store/module/api';
import { router } from '@/store/module/router';
Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
  storage: window.localStorage,
  modules: ['user'],
});

export const store = new Vuex.Store({
  modules: {
    user,
    team,
    project,
    api,
    router,
  },
  plugins: [vuexLocal.plugin],
});
