import team from './team';

const install = function(Vue) {
  Vue.directive('team', team);
};

if (window.Vue) {
  window['team'] = team;
  Vue.use(install); // eslint-disable-line
}

team.install = install;
export default team;
