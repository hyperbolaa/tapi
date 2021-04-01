import request from '@/utils/request';

// @Summary 保存信息,post数据用data
export const getTeamUserList = (params) => {
  return request({
    url: '/team/members',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createTeamUser = (data) => {
  return request({
    url: '/team/members',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateTeamUser = (data) => {
  return request({
    url: '/team/members',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteTeamUser = (data) => {
  return request({
    url: '/team/members',
    method: 'delete',
    data: data,
  });
};
