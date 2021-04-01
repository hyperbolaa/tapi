import request from '@/utils/request';

// @Summary 列表get方法传参params
export const getCatMenu = (params) => {
  return request({
    url: '/api/cats/menu',
    method: 'get',
    params: params,
  });
};

// @Summary 列表get方法传参params
export const getCatList = (params) => {
  return request({
    url: '/api/cats',
    method: 'get',
    params: params,
  });
};

// @Summary 保存信息,post数据用data
export const createCat = (data) => {
  return request({
    url: '/api/cats',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateCat = (data) => {
  return request({
    url: '/api/cats',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteCat = (data) => {
  return request({
    url: '/api/cats',
    method: 'delete',
    data: data,
  });
};

