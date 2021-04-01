import request from '@/utils/request';

// @Summary 团队信息
export const getTagList = (params) => {
  return request({
    url: '/project/tags',
    method: 'get',
    params,
  });
};

// @Summary 保存信息,post数据用data
export const createTag = (data) => {
  return request({
    url: '/project/tags',
    method: 'post',
    data: data,
  });
};

// @Summary 更新信息,put数据用data
export const updateTag = (data) => {
  return request({
    url: '/project/tags',
    method: 'put',
    data: data,
  });
};

// @Summary 删除信息
export const deleteTag = (data) => {
  return request({
    url: '/project/tags',
    method: 'delete',
    data: data,
  });
};
