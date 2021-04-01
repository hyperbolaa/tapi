import request from '@/utils/request';

// @Summary 用户登录
export const login = (data) => {
  return request({
    url: '/auth/login',
    method: 'post',
    data: data,
  });
};

// @Summary 用户退出
export const logout = () => {
  return request({
    url: '/auth/logout',
    method: 'post',
  });
};

// @Summary 用户基本信息
export function getInfo() {
  return request({
    url: '/auth/user',
    method: 'get',
  });
}
