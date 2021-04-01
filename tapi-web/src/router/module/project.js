
const projectRoutes = {
  path: 'project/:pid(\\d+)',
  name: 'project',
  component: () => import('@/view/project/index'),
  meta: { title: '项目' },
  children: [
    {
      path: 'api',
      name: 'project-api-all',
      component: () => import('@/view/project/api/list/index'),
      meta: { title: '全部接口' },
    },
    {
      path: 'api/cat_:cid(\\d+)',
      name: 'project-api-cat',
      component: () => import('@/view/project/api/list/index'),
      meta: { title: '接口分类' },
    },
    {
      path: 'api/:did(\\d+)',
      name: 'project-api-detail',
      component: () => import('@/view/project/api/detail/index'),
      meta: { title: '接口详情' },
    },
    {
      path: 'col',
      name: 'project-col-all',
      component: () => import('@/view/project/col/list/index'),
      meta: { title: '集合列表' },
    },
    {
      path: 'col/cat_:cid(\\d+)',
      name: 'project-col-cat',
      component: () => import('@/view/project/col/list/index'),
      meta: { title: '集合分类' },
    },
    {
      path: 'col/:did(\\d+)',
      name: 'project-col-detail',
      component: () => import('@/view/project/col/detail/index'),
      meta: { title: '集合详情' },
    },
    {
      path: 'trend',
      name: 'project-trend',
      component: () => import('@/view/project/trend/index'),
      meta: { title: '接口动态' },
    },
    {
      path: 'data',
      name: 'project-data',
      component: () => import('@/view/project/data/index'),
      meta: { title: '数据管理' },
    },
    {
      path: 'member',
      name: 'project-member',
      component: () => import('@/view/project/member/index'),
      meta: { title: '成员管理' },
    },
    {
      path: 'setting',
      name: 'project-setting',
      component: () => import('@/view/project/setting/index'),
      meta: { title: '项目设置' },
    },
    {
      path: 'wiki',
      name: 'project-wiki',
      component: () => import('@/view/project/wiki/index'),
      meta: { title: '项目设置' },
    },
  ],
};

export default projectRoutes;
