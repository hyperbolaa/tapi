import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import userRoutes from './module/user';
import teamRoutes from './module/team';
import projectRoutes from './module/project';
import systemRoutes from './module/system';
// 登录后异步组件
export const asyncRouters = [
  {
    path: 'dashboard',
    name: 'dashboard',
    component: () => import('@/view/dashboard/index.vue'),
    meta: { title: '工作台', icon: 's-home' },
  },
  userRoutes,
  teamRoutes,
  projectRoutes,
  systemRoutes,
  {
    path: '404',
    name: '404',
    hidden: true,
    component: () => import('@/view/error/index'),
    meta: { title: '走丢了哦' },
  },
];

// 基础组件
const baseRouters = [
  {
    path: '/console/login',
    name: 'login',
    component: () => import ('@/view/login/login'),
    hidden: true,
  },
  {
    path: '/share/:pid',
    name: 'share',
    component: () => import ('@/view/front/project/index'),
  },
  {
    path: '/document',
    name: 'document',
    component: () => import ('@/view/front/doc/index'),
  },
];

// 需要通过后台数据来生成的组件
const createRouter = () => new Router({
  routes: baseRouters,
});

const router = createRouter();

export default router;
