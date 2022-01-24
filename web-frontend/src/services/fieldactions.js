import { backend } from '@/_axios';

export default {
  createData() {
    return backend.get(`/fieldactions/create/`);
  },
  create(data) {
    return backend.post('/fieldactions/', data );
  },
  editData(id) {
    return backend.get(`/fieldactions/${id}/edit`);
  },
  update(data) {
    return backend.put(`/fieldactions/${data.id}`, data);
  },
  delete(id) {
    return backend.delete(`/fieldactions/${id}`);
  },
  list(params) {
    return backend.get(`/fieldactions/`, { params });
  }
};
