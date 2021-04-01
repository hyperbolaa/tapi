/* eslint-disable */
export const toUpperCase = (str) => {
    if (str[0]) {
        return str.replace(str[0], str[0].toUpperCase())
    } else {
        return ""
    }
}

// 驼峰转换下划线
export const toSQLLine = (str) => {
    if (str == "ID") return "ID"
    return str.replace(/([A-Z])/g, "_$1").toLowerCase();
}

// 下划线转换驼峰
export const toHump = (name) => {
    return name.replace(/\_(\w)/g, function(all, letter) {
        return letter.toUpperCase();
    });
}

/**
 * 获取pathname变量
 * @param pathname
 * @param params
 */
export const handleVarPath = (pathname, params) => {
    function insertParams(name) {
        if(name){
            if(params.indexOf({name:name}) === -1){
                params.push({
                    name: name,
                    example: '',
                    desc: ''
                });
            }
        }
    }

    if (!pathname) return;
    if (pathname.indexOf(':') !== -1) {
        let paths = pathname.split('/'),
            name,
            i;
        for (i = 1; i < paths.length; i++) {
            if (paths[i] && paths[i][0] === ':') {
                name = paths[i].substr(1);
                insertParams(name);
            }
        }
    }
    pathname.replace(/\{(.+?)\}/g, function (str, match) {
        insertParams(match);
    });
};


/**
 * 验证一个 path 是否合法
 * path第一位必需为 /, path 只允许由 字母数字-/_:.{}= 组成
 * @param path
 * @returns {boolean}
 */
export const regPath = (path) => {
    return /^\/[a-zA-Z0-9\-\/_:!\.\{\}\=]*$/.test(path);
}
