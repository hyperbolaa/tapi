import project from './project';

const install = function(Vue) {
  Vue.directive('project', project);
};

if (window.Vue) {
  window['project'] = project;
  Vue.use(install); // eslint-disable-line
}

project.install = install;
export default project;
