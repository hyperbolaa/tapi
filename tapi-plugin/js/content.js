//上下文信息，中转,inject->content->background; background->content->inject; 共享dom不共享js,操作dom注入injectedjs
console.log('This is tapi plugin!');
document.addEventListener('DOMContentLoaded', function(){
	function injectCustomJs(jsPath){
		const temp = document.createElement('script');
		temp.setAttribute('type', 'text/javascript');
		// 获得的地址类似：chrome-extension://ihcokhadfjfchaeagdoclpnjdiokfakg/js/inject.js
		temp.src = chrome.extension.getURL(jsPath);
		temp.onload = function()
		{
			// 放在页面不好看，执行完后移除掉
			this.parentNode.removeChild(this);
		};
		document.head.appendChild(temp);
	}
    injectCustomJs('js/uuid.js');
    injectCustomJs('js/message.js');
    injectCustomJs('js/injected.js');

	////建立长链接通道  连接background 通信
	const connect = chrome.runtime.connect({name: 'tapi'});

	//监听background通信,然后转给message,tag:222
	connect.onMessage.addListener(function(msg) {
        console.log('msg from background', msg);
        //如果是错误，将错误从新拼凑
		if(msg.result < 0){
			msg.data.message = msg.message;
			msg.data.stack = msg.stack;
		}
		// 传递消息给injected
        window.postMessage({
		    id:msg.id,
		    result:msg.result,
		    data:msg.data,
		    type:'from-content-script'
	    }, '*');
	});

	//监听injected script通信, 然后发送到background， tag:111
	window.addEventListener('message', function(e){
        if(e.data.type === 'from-injected-script') {
            console.log('get message from injected-script', e);
            //向background发送message
			connect.postMessage({
                id: e.data.id,
                data: e.data.data
            });
        }
	});
});
