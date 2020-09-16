import axiosApiInstance from '../helpers/axiosApiInstance'

export default {
  login (email, password) {
    return axiosApiInstance.post(
      '/api/login_check',
      {
        'email': email,
        'password': password
      }
    );
  },
}