import request from '@/utils/request';

// @Summary 团队信息
export const getApiList = (params) => {
  return request({
    url: '/apis',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createApi = (data) => {
  return request({
    url: '/apis',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateApi = (data) => {
  return request({
    url: '/apis',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteApi = (data) => {
  return request({
    url: '/apis',
    method: 'delete',
    data: data,
  });
};


// @Summary 保存信息,post数据用data
export const getInfo = (data) => {
  return request({
    url: '/apis/detail',
    method: 'post',
    data: data,
  });
};
