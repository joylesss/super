import axios from 'axios';

export const apiRequest = (url, methodType, data = {}, multipart = false) => {
    let headers;
    headers = [];

    if (multipart) {
        headers['content-type'] = 'multipart/form-data';
    }

    return new Promise (
        (resolve, reject) => {
            axios({
                method: methodType,
                url: url,
                data: data,
                headers: headers
            }).then(response => {
                resolve(response.data);
            }).catch(function (error) {
                reject(error.response);
            });
        }
    );
};
