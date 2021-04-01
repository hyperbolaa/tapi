## 环境依赖
1. centos
2. nginx 
3. mysql 
4. php 7.2.5+
5. laravel 6.2


## 执行命令
```
composer install
cp .env.example  .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
```

## 插件
    tymon/jwt-auth   token认证用
    
## 开发
    php artisan serve
    
    
    
## 介绍
```
jwt: 可参考我的简书
models/user   实现jwt用户模型
config/auth   实现api守卫使用jwt驱动
routes/api    中间件限制
controllers/api/auth  登录退出
middleware/authenticate   设置异常请求跳转登录路由
```    
