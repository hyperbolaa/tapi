
const teamRoutes = {
  path: 'team/:tid(\\d+)',
  name: 'team',
  component: () => import('@/view/team/index.vue'),
  meta: { title: '团队', roles: ['adminer', 'member'] },
};

export default teamRoutes;
