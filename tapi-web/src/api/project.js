import request from '@/utils/request';

// @Summary 团队信息
export const getProjectList = (params) => {
  return request({
    url: '/projects',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createProject = (data) => {
  return request({
    url: '/projects',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateProject = (data) => {
  return request({
    url: '/projects',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteProject = (data) => {
  return request({
    url: '/projects',
    method: 'delete',
    data: data,
  });
};

// @Summary 关注
export const followProject = (data) => {
  return request({
    url: '/projects/follow',
    method: 'post',
    data: data,
  });
};

// @Summary 保存信息,post数据用data
export const getInfo = (data) => {
  return request({
    url: '/projects/detail',
    method: 'post',
    data: data,
  });
};
