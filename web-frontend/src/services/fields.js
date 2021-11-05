import { backend } from '@/_axios'

export default{
    createData(){
        return backend.get('/fields/create')
    },
    create(data){
        return backend.post('/fields/',  data )
    },
    editData(id) {
        return backend.get(`/fields/${id}/edit`)
    },
    update(data) {
        return backend.put(`/fields/${data.id}`, data)
    },
    delete(id) {
        return backend.delete(`/fields/${id}`)
    },
    list(params) {
        return backend.get('/fields/', { params })
    }
}