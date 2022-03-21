import { backend } from '@/_axios';

export default {
  createData() {
    return backend.get(`/fieldAddOns/create/`);
  },
  create(data) {
    return backend.post(`/fieldAddOns`, data );
  },
  editData(id) {
    return backend.get(`/fieldAddOns/${id}/edit`);
  },
  update(data) {
    return backend.put(`/fieldAddOns/${data.id}`, data);
  },
  delete(id) {
    return backend.delete(`/fieldAddOns/${id}`);
  },
  list(params) {
    return backend.get(`/fieldAddOns/`, { params });
  }
};