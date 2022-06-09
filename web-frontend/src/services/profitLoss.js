import { backend } from '@/_axios';

export default {
//   createData() {
//     return backend.get(`/sowing/create/`);
//   },
  create(data) {
    return backend.post(`/profitLoss`, data );
  },
//   editData(id) {
//     return backend.get(`/sowing/${id}/edit`);
//   },
//   update(data) {
//     return backend.put(`/sowing/${data.id}`, data);
//   },
//   delete(id) {
//     return backend.delete(`/sowing/${id}`);
//   },
  list(params) {
    return backend.get(`/profitLoss/`, { params });
  }
};
