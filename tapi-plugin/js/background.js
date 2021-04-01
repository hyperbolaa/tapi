//监听长链接
chrome.runtime.onConnect.addListener(function(connect) {
	if(connect.name === "tapi"){
        connect.onMessage.addListener(function(msg){
            console.log('msg:', msg);
            const id = msg.id;
            const version = msg && msg.data && msg.data.version || ''
            let promise;
            if(version === 2){
                promise = sendRequestV2(msg)
            }else{
                promise = sendRequest(msg)
            }
            promise.then(function(data){
                console.log('return:', data);
                new Promise(resolve=>{
                    resolve();
                }).then(()=>{
                    if(typeof msg.success === 'function'){
                        msg.success(data);
                    }
                    connect.postMessage({
                        id:id,
                        result:0,
                        data:data
                    });
                });
			}).catch(function(error) {
                console.log(error);
                connect.postMessage({
                    id: id,
                    result: -1,
                    data: error,
                    message: error.message,
                    stack: error.stack
                });
            });
		});
	}
});
//用例的场景调用--config需要是格式化好的
function sendRequestV2(msg){
    const config = msg.data.config;
    return axios.request(config)
}
//测试接口场景调用--数据插件中构建
function sendRequest(msg){
    const config = msg.data.config;
    const queryParams = msg.data.params.queryParams;
    const headerParams = msg.data.params.headerParams;
    const bodyType = msg.data.params.bodyType;
    const bodyParams = msg.data.params.bodyParams;

    config.params = mapParamsToObject(queryParams);
    config.headers = mapParamsToObject(headerParams);

	//封装body参数
    switch(bodyType){
        case 'none':
            //no need body
            break;
        case 'form':
            //x-www-form-urlencoded
            // config.data = mapParamsToObject(bodyParams);
            config.data = getUrlByParams(bodyParams);
            break;
        default:
            //raw or other
            config.data = bodyParams;
            break;
    }
    console.log('request config :', config);
	return axios.request(config);
}
//数据类型转换
function mapParamsToObject(params){
    //映射参数为对象
    let obj = {};
    if(params && params.length > 0){
        params.forEach((param) => {
            if(param.required === true && param.name !== ''){
                obj[param.name] = param.value;
            }
        });
    }
    return obj;
}
//数据类型转换
function getUrlByParams(params){
    let urlStr = '';
    params.forEach((param, index) => {
        if(param.required === true && param.name !== ''){
            if(index !== 0){
                urlStr += '&';
            }
            urlStr += param.name + '=' + param.value;
        }
    });
    return urlStr;
}
