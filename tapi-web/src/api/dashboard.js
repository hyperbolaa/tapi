import request from '@/utils/request';

// @Summary 列表get方法传参params
export const getNotice = () => {
  return request({
    url: '/dashboard/notice',
    method: 'get',
  });
};

// @Summary 列表get方法传参params
export const getFollow = () => {
  return request({
    url: '/dashboard/follow',
    method: 'get',
  });
};

// @Summary 列表get方法传参params
export const getTeam = () => {
  return request({
    url: '/dashboard/team',
    method: 'get',
  });
};

// @Summary 列表get方法传参params
export const getProject = () => {
  return request({
    url: '/dashboard/project',
    method: 'get',
  });
};
