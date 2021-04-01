
const systemRoutes = {
  path: 'system',
  name: 'system',
  component: () => import('@/view/system/index'),
  meta: { title: '系统信息', icon: 'setting' },
  redirect: '/console/system/static',
  children: [
    {
      path: 'static',
      name: 'system-static',
      component: () => import('@/view/system/static/index'),
      meta: { title: '数据统计', icon: 's-data' },
    },
    {
      path: 'user',
      name: 'system-user',
      component: () => import('@/view/system/user/index'),
      meta: { title: '用户管理', icon: 'user' },
    },
    {
      path: 'notice',
      name: 'system-notice',
      component: () => import('@/view/system/notice/index'),
      meta: { title: '通知公告', icon: 'bell' },
    },
  ],
};

export default systemRoutes;
