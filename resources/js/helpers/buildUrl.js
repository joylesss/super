export const buildUrl = params => {
    let arr = [];
    Object.keys(params).forEach(function(key) {
        arr.push(`${key}=${params[key]}`)
    });
    return '?' + arr.join('&');
};
