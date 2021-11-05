import axios from 'axios'

const backend =  axios.create({
    baseURL: "http://"+location.hostname+":3000/api"
})
export { backend }