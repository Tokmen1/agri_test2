import { backend } from '@/_axios'

export default{
    list(params) {
        return backend.get(`/fieldactions/`, { params })
    }
}