import { backend } from '@/_axios';

export default {
  user() {
    return backend.get('/users/me');
  },
  login(email, password) {
    return backend.post('auth/login', { email, password });
  },
  register(data) {
    return backend.post('auth/register', data);
  },
  logout(){
    return backend.post('auth/logout');
  }
  // forgotPassword(emailData) {
  //   return Backend.post('auth/forgot-password', emailData);
  // },
  // resetPassword(resetData) {
  //   return Backend.put('auth/reset-password', resetData);
  // },
};
