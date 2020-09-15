import axios from 'axios'
import store from '../store'
// import router from '../router'
import createAuthRefreshInterceptor from 'axios-auth-refresh';



export default function setup() {
  function getAccessToken() {
    return localStorage.getItem('token');
  }
  // Use interceptor to inject the token to requests
  if (store.getters['isAuthenticated']) {
    axios.interceptors.request.use(request => {
      request.headers['Authorization'] = `Bearer ${getAccessToken()}`;
      return request;
    });
  }

  const refreshAuthLogic = failedRequest => {
    let refreshToken = store.getters['refreshToken'];
    store.dispatch('logout')
    let req = axios.post('/api/token/refresh', {
      refresh_token: refreshToken
    })
      .then(tokenRefreshResponse => {
        store.dispatch('refresh', tokenRefreshResponse)
        failedRequest.response.config.headers['Authorization'] = 'Bearer ' + tokenRefreshResponse.data.token;
      })
    return req;
  }

  // Instantiate the interceptor (you can chain it as it returns the axios instance)
  createAuthRefreshInterceptor(axios, refreshAuthLogic)
}