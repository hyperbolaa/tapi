
const userRoutes = {
  path: 'user',
  name: 'user',
  component: () => import('@/view/user/index'),
  meta: { title: '个人设置', icon: 'setting' },
  redirect: '/console/user/profile',
  children: [
    {
      path: 'profile',
      name: 'user-profile',
      component: () => import('@/view/user/profile/index'),
      meta: { title: '个人信息', icon: 'user' },
    },
    {
      path: 'password',
      name: 'user-password',
      component: () => import('@/view/user/password/index'),
      meta: { title: '修改密码', icon: 'knife-fork' },
    },
  ],
};

export default userRoutes;
