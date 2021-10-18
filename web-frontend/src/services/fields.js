import axios from 'axios'

export default{
    getAllData(){
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/')
        //.get('posts')
    },
    createData(){
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/fields/create')
    },
    create(data){
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/fields/', data)
    },
    editData(id) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get(`/api/fields/${id}/edit`)
    },
    update(data) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/fields/${data.id}', data)
    },
    delete(id) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get(`/api/fields/${id}`)
    },
    list(params) {
        return (axios.create({
            baseURL: "http://"+location.hostname+":3000"
        })).get('/api/fields/', { params })
    }
}