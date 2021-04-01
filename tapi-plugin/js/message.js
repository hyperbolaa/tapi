// 注入js
const promistList = {};
//用来外部决议
const resolveList = {};
const rejectList = {};

// 传递消息给content tag:111
window.sendMsgToContent = function(msg){
    const id = Math.uuidFast();
    promistList[id] = new Promise(function(resolve, reject){
        window.postMessage({
            id:id,
            data:msg,
            type:'from-injected-script'
        }, '*');
        resolveList[id] = resolve;
        rejectList[id] = reject;
    });
    return promistList[id];
}

// 接受消息来自content, tag:222
window.addEventListener('message', function(e){
    if(e.data.type === 'from-content-script'){
        console.log('message js', e);
        if(e.data.result === 0){
            //success
            resolveList[e.data.id](e.data.data);
        }else{
            rejectList[e.data.id](e.data.data);
        }
    }
}, true);

