import { asyncRouters } from '@/router';
import { store } from '@/store';

/**
 * 简单的角色判断
 * @param role
 * @param route
 * @returns {boolean}
 */
function canAccess(role, route) {
  if (route.meta && route.meta.roles) {
    return route.meta.roles.includes(role);
  } else {
    return true;
  }
}

/**
 * 限制路由
 * @param routes
 * @param role
 * @returns {Array}
 */
function filterAsyncRouters(routes, role) {
  const res = [];
  routes.forEach(route => {
    const tmp = { ...route };
    if (canAccess(role, tmp)) {
      if (tmp.children) {
        tmp.children = filterAsyncRouters(
          tmp.children,
          role,
        );
      }
      res.push(tmp);
    }
  });
  return res;
}

export const router = {
  namespaced: true,
  state: {
    asyncRouters: [],
  },
  mutations: {
    // 设置动态路由
    setAsyncRouter(state, asyncRouters) {
      state.asyncRouters = asyncRouters;
    },
  },
  actions: {
    // 从后台获取动态路由
    SetAsyncRouter({ commit }) {
      const role = store.getters['user/role'];
      let accessedRoutes;
      if (role === 'adminer') {
        accessedRoutes = asyncRouters || [];
      } else {
        accessedRoutes = filterAsyncRouters(asyncRouters, role);
      }
      const baseRouter = [{
        path: '/console',
        name: 'console',
        component: () => import('@/view/layout/index.vue'),
        meta: { title: '底层视图布局' },
        redirect: { name: 'dashboard' },
        children: [],
      }, {
        path: '*',
        redirect: { name: '404' },
      }];
      baseRouter[0].children = accessedRoutes;
      commit('setAsyncRouter', baseRouter);
      return true;
    },
  },
  getters: {
    // 获取动态路由
    asyncRouters(state) {
      return state.asyncRouters;
    },
    // 获取动态路由
    asyncRoutersNew(state) {
      return state.asyncRouters;
    },
  },
};
