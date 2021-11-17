import VueRouter from 'vue-router'

const MainLayout = () => import('./../layouts/MainLayout.vue')
const records = () => import('@/views/DBRecords.vue')
const Fields = () => import('@/views/Fields.vue')
const FieldForm = () => import('@/views/FieldForm.vue')
const FieldActions = () => import('@/views/FieldActions.vue')
const FieldActionsForm = () => import('@/views/FieldActionsForm.vue')
const Login = () => import('@/views/Pages/Login.vue')
const Register = () => import('@/views/Pages/Register.vue')

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
                    path: 'list/:page',
                    name: 'FieldActions',
                    meta: { label: 'route.fieldaction_list' },
                    props: (route) => {
                      return {
                        id: Number(route.params.id),
                        page: Number(route.params.page)
                      };
                    },
                    component: FieldActions,
                  },
                  {
                    path: 'create',
                    name: 'FieldActionsCreate',
                    meta: { label: 'route.field_actions_create_title' },
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
    },
    {
      path: '/login',
      name: 'Login',
      meta: { label: 'route.login' },
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      meta: { label: 'route.register' },
      component: Register
    },
]
const publicRoutes = [
  'Login',
  'Register'
]; 
const router = new VueRouter({
    routes
  });

  router.beforeEach((to, from, next) => {
    if (!publicRoutes.includes(to.name) && (typeof sessionStorage.getItem('access_token') === 'undefined')) {
      next({ name: 'Login' });
    }
    if (to.name === 'Login' && from.name && from.name !== 'Login'
      && from.name !== 'Register'
      && from.name !== 'PasswordForgot'
      && from.name !== 'PasswordReset') {
      sessionStorage.setItem('redirectPath', from.path);
    }
  
    next();
  });

export default router