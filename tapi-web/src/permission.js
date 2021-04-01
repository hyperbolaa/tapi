import router from './router';
import { store } from '@/store';

const whiteList = ['login', 'document', 'share'];

router.beforeEach(async(to, from, next) => {
  const hasToken = store.getters['user/token'];
  if (whiteList.indexOf(to.name) !== -1) {
    if (hasToken && to.name === 'login') {
      next({ path: '/console/dashboard' });
    } else {
      next();
    }
  } else {
    if (hasToken) {
      console.log('route-path', to.path);
      const asyncRouters = store.getters['router/asyncRouters'];
      if (asyncRouters.length > 0) {
        if (to.path.indexOf('team') > 0){ // 团队
          const asyncTeamInfo = store.getters['team/teamInfo'] || {};
          if (Object.keys(asyncTeamInfo).length === 0){
            await store.dispatch('team/setTeamInfo', (to.params.tid));
            const asyncTeamInfo = store.getters['team/teamInfo'];
            if (Object.keys(asyncTeamInfo).length === 0){
              next({ name: '404', query: { from: to.path }});
            }
          } else if (asyncTeamInfo.id !== to.params.tid){
            await store.dispatch('team/setTeamInfo', (to.params.tid));
            const asyncTeamInfo = store.getters['team/teamInfo'];
            if (Object.keys(asyncTeamInfo).length === 0){
              next({ name: '404', query: { from: to.path }});
            }
          }

          next();
        } else if (to.path.indexOf('project') > 0){ // 项目
          const asyncProjectInfo = store.getters['project/projectInfo'] || {};
          if (Object.keys(asyncProjectInfo).length === 0){
            await store.dispatch('project/setProjectInfo', (to.params.pid));
            const asyncProjectInfo = store.getters['project/projectInfo'];
            if (Object.keys(asyncProjectInfo).length === 0){
              next({ name: '404', query: { from: to.path }});
            }
          } else if (asyncProjectInfo.id !== to.params.pid){
            await store.dispatch('project/setProjectInfo', (to.params.pid));
            const asyncProjectInfo = store.getters['project/projectInfo'];
            if (Object.keys(asyncProjectInfo).length === 0){
              next({ name: '404', query: { from: to.path }});
            }
          }

          next();
        } else { // 其他业务--系统，通知，个人
          await store.dispatch('team/setTeamEmpty');
          await store.dispatch('project/setProjectEmpty');

          next();
        }
      } else {
        try {
          // get user info
          await store.dispatch('user/getInfo');
          // generate accessible routes map based on roles
          await store.dispatch('router/SetAsyncRouter');
          // dynamically add accessible routes
          const asyncRouters = store.getters['router/asyncRouters'];
          router.addRoutes(asyncRouters);
          // hack method to ensure that addRoutes is complete
          // set the replace: true, so the navigation will not leave a history record
          next({ ...to, replace: true });
        } catch (error) {
          // remove token and go to login page to re-login
          await store.dispatch('user/LoginOut');
          next(`/console/login?redirect=${to.path}`);
        }
      }
    }
    // 不在白名单中并且未登陆的时候
    if (!hasToken) {
      next({
        name: 'login',
        query: {
          redirect: document.location.hash,
        },
      });
    }
  }
});
