import request from '@/utils/request';

// @Summary 列表get方法传参params
export const getUserList = (params) => {
  return request({
    url: '/users',
    method: 'get',
    params: params,
  });
};

// @Summary 列表get方法传参params
export const searchUser = (data) => {
  return request({
    url: '/users/search',
    method: 'post',
    data: data,
  });
};

// @Summary 保存信息,post数据用data
export const createUser = (data) => {
  return request({
    url: '/users',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateUser = (data) => {
  return request({
    url: '/users',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteUser = (data) => {
  return request({
    url: '/users',
    method: 'delete',
    data: data,
  });
};

export const changePassword = (data) => {
  return request({
    url: '/users/password',
    method: 'post',
    data: data,
  });
};
