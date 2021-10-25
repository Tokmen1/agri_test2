import axios from 'axios'

export default{
    getAllData(){
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/')
    },
    createData(){
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/fields/create')
    },
    create(data){
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).post('/api/fields/',  data )
    },
    editData(id) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get(`/api/fields/${id}/edit`)
    },
    update(data) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).put(`/api/fields/${data.id}`, data)
    },
    delete(id) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).delete(`/api/fields/${id}`)
    },
    list(params) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/fields/', { params })
    }
}