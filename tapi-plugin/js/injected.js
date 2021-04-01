window.tapi = {
	version: 1,
	request(config){// 运行时使用
		return window.sendMsgToContent(config)
	},
	async requestAsync(config){ // 案例脚本时使用,同步返回
		return window.sendMsgToContent({
			version: 2,
			config,
		}).then(async res=>{
			return res
		})
	},
}
