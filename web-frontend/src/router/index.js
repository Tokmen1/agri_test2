import VueRouter from 'vue-router'

const MainLayout = () => import('./../layouts/MainLayout.vue')
const records = () => import('@/views/DBRecords.vue')
const Fields = () => import('@/views/Fields.vue')
const FieldForm = () => import('@/views/FieldForm.vue')
const FieldActions = () => import('@/views/FieldActions.vue')
const FieldActionsForm = () => import('@/views/FieldActionsForm.vue')

const routes = [
    {
        path: '/',
        component: MainLayout,
        children: [
            { path: '/records', component: records },
            { path: '/example', component: Fields },
            { path: '/FieldActions', component: FieldActions},
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
              {
                path: 'fieldactions',
                name: null,
                meta: { label: 'route.fields_list_title' },
                redirect: { name: 'FieldActions', params: { page: 1 } },
      
                component: {
                  render(c) { return c('router-view'); }
                },
      
                children: [
                  {
                    path: 'list/:id',
                    name: 'FieldActions',
                    meta: { label: 'route.fieldaction_list' },
                    props: (route) => {
                      return {
                        id: Number(route.params.id)
                      };
                    },
                    component: FieldActions,
                  },
                  {
                    // path: 'create/:field_id',
                    path: 'create',
                    name: 'FieldActionsCreate',
                    meta: { label: 'route.field_actions_create_title' },
                    // props: (route) => {
                    //   return {
                    //     field_id: Number(route.params.field_id)
                    //   };
                    // },
                    component: FieldActionsForm
                  },
                  {
                    path: 'update/:id',
                    name: 'FieldActionsUpdate',
                    meta: { label: 'route.field_actions_update_title' },
                    props: (route) => {
                      return {
                        id: Number(route.params.id)
                      };
                    },
                    component: FieldActionsForm
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