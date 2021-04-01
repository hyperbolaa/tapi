import request from '@/utils/request';

// @Summary 团队信息
export const getEnvList = (params) => {
  return request({
    url: '/project/envs',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createEnv = (data) => {
  return request({
    url: '/project/envs',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateEnv = (data) => {
  return request({
    url: '/project/envs',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteEnv = (data) => {
  return request({
    url: '/project/envs',
    method: 'delete',
    data: data,
  });
};
