/* eslint-disable */
const URL = require('url');
// 构造请求路由
export const handleRequestConfig = (apiData,env) => {
    let requestOptions = {};
    const path = makePathParam(env+apiData.path,apiData.req_param)
    const urlObj = URL.parse(path, true);
    const url = URL.format({
        protocol: urlObj.protocol || 'http',
        host: urlObj.host || '127.0.0.1',
        pathname: urlObj.pathname,
    });

    const request_query  = makeReqQuery(apiData.req_query,urlObj.query);
    const request_header = makeReqHeader(apiData.req_header);
    const request_body   = makeReqBody(apiData.req_body_type,apiData.req_body_form,apiData.req_body_json_string);

    requestOptions = {
        config: {
            method: apiData.method || 'GET',
            url: url,
        },
        params: {
            queryParams: request_query,
            headerParams: request_header,
            bodyType: apiData.req_body_type,
            bodyParams: request_body,
        },
    };

    return requestOptions;

    // 构造查询信息  [name value required]
    function makeReqQuery(querys,url_query)  {
        const Q = [];
        Object.keys(url_query).forEach(key => {
            Q.push({name:key,value:url_query[key],required:true})
        });
        if(querys.length > 0){
            querys.forEach((param) => {
                if(param.required === 1 && param.name !== ''){
                    Q.push({name:param.name,value:param.value,required:true});
                }
            });
        }
        return Q;
    }

    // 构造头信息,[name value required]
    function makeReqHeader(headers) {
        const H = [];
        if(headers.length > 0){
            headers.forEach((param) => {
                if(param.required === 1 && param.name !== ''){
                    H.push({name:param.name,value:param.value,required:true});
                }
            });
        }
        return H;
    }

    // 构造内容
    function makeReqBody(body_type,body_form,body_json) {
        if(body_type === 'form'){
            const B = [];
            if(body_form.length > 0){
                body_form.forEach((param) => {
                    if(param.required === 1 && param.name !== ''){
                        B.push({name:param.name,value:param.value,required:true});
                    }
                });
            }
            return B;
        }else if(body_type === 'json'){
            return body_json;
        }else{
            return '';
        }
    }

    //动态路由  ('/user/logins/:id/{im}?token={token}',[{name:'id',value:1},{name:'im',value:2},{name:'token',value:'ss'}])
    function makePathParam(path,req_params) {
        req_params.forEach(item => {
            path = path.replace(`:${item.name}`, item.value || `:${item.name}`);
            path = path.replace(`{${item.name}}`, item.value || `{${item.name}}`);
        });
        return path;
    }
}





