import request from '@/utils/request';

// @Summary 列表get方法传参params
export const getLogList = (params) => {
  return request({
    url: '/operations',
    method: 'get',
    params: params,
  });
};
