import request from '@/utils/request';

// @Summary 团队信息
export const getMyTeams = (params) => {
  return request({
    url: '/teams',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createTeam = (data) => {
  return request({
    url: '/teams',
    method: 'post',
    data: data,
  });
};

// @Summary 保存信息,post数据用data
export const updateTeam = (data) => {
  return request({
    url: '/teams',
    method: 'put',
    data: data,
  });
};

// @Summary 保存信息,post数据用data
export const getInfo = (data) => {
  return request({
    url: '/teams/detail',
    method: 'post',
    data: data,
  });
};
