import { backend } from '@/_axios';

export default {
  me() {
    return backend.post('/auth/me', {headers:{'Authorization':'Bearer' + sessionStorage.getItem('access_token')}});
  },
  login(email, password) {
    return backend.post('auth/login', { email, password });
  },
  register(data) {
    return backend.post('auth/register', data);
  },
  logout(data){
    return backend.post('auth/logout', data);
  }
  // forgotPassword(emailData) {
  //   return Backend.post('auth/forgot-password', emailData);
  // },
  // resetPassword(resetData) {
  //   return Backend.put('auth/reset-password', resetData);
  // },
};
