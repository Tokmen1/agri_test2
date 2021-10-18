<template>
    <div>
        <h2>
        DB records:
        </h2>
        <div v-for="post in posts" :key="post.id">
            <p>
                <span>{{ post.id +": "+ post.field_name }}</span>
            </p>
        </div>
    </div>
</template>

<script>
import FieldService from '../services/fields'

export default {
  
  name: 'posts',
  data(){
    return{
      posts: []
    }
  },
  mounted (){
    this.getPosts()
  },
  methods: {
    async getPosts(){
      const response = await FieldService.getAllData()
      console.log(response.data['data'])
      this.posts = response.data['data']
    }
  }
}

</script>
