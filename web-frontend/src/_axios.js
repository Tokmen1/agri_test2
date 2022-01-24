import axios from 'axios';
var token = null;
var backend = '';
(async () => {
  token = await sessionStorage.getItem('access_token');

  if (token != null) {
    backend = await axios.create({
      headers: {'Authorization': `Bearer ${token}`},
      baseURL: "http://"+location.hostname+":3000/api",
    });
  }
  else {
    backend = await axios.create({
      baseURL: "http://"+location.hostname+":3000/api"
    });
  }
})();
 
export { backend };
