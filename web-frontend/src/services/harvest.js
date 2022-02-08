import { backend } from '@/_axios';

export default {
  createData() {
    return backend.get(`/harvest/create/`);
  },
  create(data) {
    return backend.post(`/harvest`, data );
  },
  editData(id) {
    return backend.get(`/harvest/${id}/edit`);
  },
  update(data) {
    return backend.put(`/harvest/${data.id}`, data);
  },
  delete(id) {
    return backend.delete(`/harvest/${id}`);
  },
  list(params) {
    return backend.get(`/harvest/`, { params });
  }
};
