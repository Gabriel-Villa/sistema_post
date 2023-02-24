const helpHttp = () => {
    const customFetch = (endpoint, options) => {
      const defaultHeader = {
        accept: "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      };
  
      const original_options = options;

      const controller = new AbortController();
      options.signal = controller.signal;
  
      options.method = options.method || "GET";
      options.headers = options.headers
        ? { ...defaultHeader, ...options.headers }
        : defaultHeader;
  
      options.body = JSON.stringify(options.body) || false;
      if (!options.body) delete options.body;
  
      //console.log(options);
      setTimeout(() => controller.abort(), 10000);
  
      return fetch(endpoint, options)
        .then((res) => {
          
          if(!res.ok){
            return Promise.reject({
              err: true,
              status: res.status || "00",
              mensaje: res.statusText || "Ocurrió un error",
            });
          }else{
            return original_options.modal 
              ?  res.text()
              :  res.json();
          }
        })
        .catch((err) => err);
    };
  
    const get = (url, options = {}) => customFetch(url, options);
  
    const post = (url, options = {}) => {
      options.method = "POST";
      return customFetch(url, options);
    };
  
    const put = (url, options = {}) => {
      options.method = "PUT";
      return customFetch(url, options);
    };
  
    const del = (url, options = {}) => {
      options.method = "DELETE";

      return customFetch(url, options);
    };
  
    return {
      get,
      post,
      put,
      del,
    };
    
};