import VueRouter from 'vue-router'

const MainLayout = () => import('./../layouts/MainLayout.vue')
const records = () => import('@/views/DBRecords.vue')
const Fields = () => import('@/views/Fields.vue')
const FieldForm = () => import('@/views/FieldForm.vue')
const Bar = { template: '<div>barss</div>' }

const routes = [
    {
        path: '/',
        component: MainLayout,
        children: [
            { path: '/records', component: records },
            { path: '/example', component: Fields },
            // { path: '/FieldCreate', component: FieldCreate},
            { path: '/bar', component: Bar },
            {
                path: 'fields',
                name: null,
                meta: { label: 'route.fields_list_title' },
                redirect: { name: 'Fields', params: { page: 1 } },
      
                component: {
                  render(c) { return c('router-view'); }
                },
      
                children: [
                  {
                    path: 'list/:page',
                    name: 'Fields',
                    meta: { label: 'route.field_list' },
                    props: true,
                    component: Fields,
                  },
                  {
                    path: 'create',
                    name: 'FieldCreate',
                    meta: { label: 'route.field_create_title' },
                    component: FieldForm
                  },
                  {
                    path: 'update/:id',
                    name: 'FieldUpdate',
                    meta: { label: 'route.field_update_title' },
                    props: (route) => {
                      return {
                        id: Number(route.params.id)
                      };
                    },
                    component: FieldForm
                  },
                ]
              },

        ],
    }
] 
const router = new VueRouter({
    routes
  })

export default router