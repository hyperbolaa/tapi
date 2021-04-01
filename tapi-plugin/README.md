<h4>一个赋予html页面跨域请求能力的chrome扩展</h4> 

### 1:安装步骤
1. 进入chrome浏览器拓展程序管理业
>chrome://extensions/
2. 打开“开发者模式”开关，点击“加载已解压的拓展程序”
>选择下载的文件夹
### 2:使用方法
##### 2.1 sendRequest vs formUrlEncoded
```
var config = {
    config:{
        method: 'get',
        url: 'http://127.0.0.1/index.php?r=user/form',
    },
    params:{
        queryParams:[],
        headerParams:[
            {"name":"Content-Type","value":"application/x-www-form-urlencoded","required":true}
        ],
        bodyType: "form",
        bodyParams:[],
    }
};
tapi.request(config)
```

##### 2.2 sendRequest vs raw
>Content-Type  的值是多变的，【"text/plain","application/json","application/javascript","text/html","text/xml","application/xml"】
```
var config = {
    config:{
        method: 'post',
        url: 'http://127.0.0.1/index.php?r=user/json',
    },
    params:{
        queryParams:[],
        headerParams:[
            {"name":"Content-Type","value":"application/json","required":true}
        ],
        bodyType: "raw",
        bodyParams:'{"domain": "yun.zjer.cn/space", "platformCode": 330000}',
    }
};
tapi.request(config)
```

##### 2.3 sendRequestV2 测试用例的方法,自动构造好数据结构
```
var config = {
    method: 'post',
    url: '/index.php?r=user/async',
    baseURL: 'http://127.0.0.1',
    params:{},
    headers:{},
    data:{email: 'tuoxie',password: 'xxxxx'},
};
tapi.requestAsync(config)
```

### 3: 原理
    content.js  负责注入js,及与message.js和background.js交互
    injected.js 注入js,发送消息
    message.js  负责发送消息和监听消息
    uuid.js     生成唯一ID
    background.js   发送跨域请求
    
### 4: 源代码传送门
[gitee](https://gitee.com/hyperbolaa)

### 5: 参考文档
[Chrome插件(扩展)开发全攻略](https://www.cnblogs.com/liuxianan/p/chrome-plugin-develop.html#popup%E6%88%96%E8%80%85bg%E5%90%91content%E4%B8%BB%E5%8A%A8%E5%8F%91%E9%80%81%E6%B6%88%E6%81%AF)

[axios使用文档](http://www.axios-js.com/zh-cn/docs/)


