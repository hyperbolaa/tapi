import request from '@/utils/request';

// @Summary 保存信息,post数据用data
export const getProjectUserList = (params) => {
  return request({
    url: '/project/members',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createProjectUser = (data) => {
  return request({
    url: '/project/members',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateProjectUser = (data) => {
  return request({
    url: '/project/members',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteProjectUser = (data) => {
  return request({
    url: '/project/members',
    method: 'delete',
    data: data,
  });
};
