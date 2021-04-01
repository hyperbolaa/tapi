import { store } from '@/store';

function checkPermission(el, binding) {
  const { value } = binding;
  const role = store.getters['team/getTeamRole'];

  if (value && value instanceof Array) {
    if (value.length > 0) {
      const hasPermission = value.includes(role);

      if (!hasPermission) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    }
  } else {
    throw new Error(`need roles! Like v-permission="['admin','leader']"`);
  }
}

export default {
  inserted(el, binding) {
    checkPermission(el, binding);
  },
  update(el, binding) {
    checkPermission(el, binding);
  },
};
