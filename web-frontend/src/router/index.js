/* eslint-disable */
import VueRouter from 'vue-router';

const MainLayout = () => import('@/layouts/MainLayout.vue');
const Fields = () => import('@/views/Fields.vue');
const FieldForm = () => import('@/views/FieldForm.vue');

const FieldActions = () => import('@/views/FieldActions.vue');
const FieldActionsForm = () => import('@/views/FieldActionsForm.vue');

const Sowing = () => import('@/views/Sowing/Sowing.vue');
const SowingForm = () => import('@/views/Sowing/SowingForm.vue');

const Harvest = () => import('@/views/Harvest/Harvest.vue');
const HarvestForm = () => import('@/views/Harvest/HarvestForm.vue');

const FieldAddOns = () => import('@/views/FieldAddOns/FieldAddOns.vue');
const FieldAddOnsForm = () => import('@/views/FieldAddOns/FieldAddOnsForm.vue');

const Login = () => import('@/views/Pages/Login.vue');
const Register = () => import('@/views/Pages/Register.vue');
/* eslint-enabled */
const routes = [ 
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '/', component: Fields },
      { path: '/records', component: Fields },
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
      {
        path: 'field/:field_id/sowing',
        name: null,
        meta: { label: 'route.fields_list_title' },
        redirect: { name: 'Sowing', params: { page: 1 } },

        component: {
          render(c) { return c('router-view'); }
        },

        children: [
          {
            path: 'list/:page',
            name: 'Sowing',
            meta: { label: 'route.sowing_list' },
            props: (route) => {
              return {
                field_id: Number(route.params.field_id),
                page: Number(route.params.page)
              };
            },
            component: Sowing,
          },
          {
            path: 'create',
            name: 'SowingCreate',
            meta: { label: 'route.sowing_create_title' },
            props: (route) => {
              return {
                field_id: Number(route.params.field_id),
              };
            },
            component: SowingForm
          },
          {
            path: 'update/:id',
            name: 'SowingUpdate',
            meta: { label: 'route.sowing_update_title' },
            props: (route) => {
              return {
                id: Number(route.params.id),
                field_id: Number(route.params.field_id),
              };
            },
            component: SowingForm
          },
        ]
      },
      {
        path: 'field/:field_id/harvest',
        name: null,
        meta: { label: 'route.fields_list_title' },
        redirect: { name: 'Harvest', params: { page: 1 } },

        component: {
          render(c) { return c('router-view'); }
        },

        children: [
          {
            path: 'list/:page',
            name: 'Harvest',
            meta: { label: 'route.harvest_list' },
            props: (route) => {
              return {
                field_id: Number(route.params.field_id),
                page: Number(route.params.page)
              };
            },
            component: Harvest,
          },
          {
            path: 'create',
            name: 'HarvestCreate',
            meta: { label: 'route.harvest_create_title' },
            props: (route) => {
              return {
                field_id: Number(route.params.field_id),
              };
            },
            component: HarvestForm
          },
          {
            path: 'update/:id',
            name: 'HarvestUpdate',
            meta: { label: 'route.harvest_update_title' },
            props: (route) => {
              return {
                id: Number(route.params.id),
                field_id: Number(route.params.field_id),
              };
            },
            component: HarvestForm
          },
        ]
      },
      {
        path: 'field/:field_id/fieldAddOns/:type',
        name: null,
        meta: { label: 'route.fields_list_title' },
        redirect: { name: 'FieldAddOns', params: { page: 1 } },

        component: {
          render(c) { return c('router-view'); }
        },

        children: [
          {
            path: 'list/:page',
            name: 'FieldAddOns',
            meta: { label: 'route.fieldAddOns_list' },
            props: (route) => {
              return {
                field_id: Number(route.params.field_id),
                type: String(route.params.type),
                page: Number(route.params.page)
              };
            },
            component: FieldAddOns,
          },
          {
            path: 'create',
            name: 'FieldAddOnsCreate',
            meta: { label: 'route.fieldAddOns_create_title' },
            props: (route) => {
              return {
                field_id: Number(route.params.field_id),
                type: String(route.params.type),
              };
            },
            component: FieldAddOnsForm
          },
          {
            path: 'update/:id',
            name: 'FieldAddOnsUpdate',
            meta: { label: 'route.fieldAddOns_update_title' },
            props: (route) => {
              return {
                id: Number(route.params.id),
                field_id: Number(route.params.field_id),
                type: String(route.params.type),
              };
            },
            component: FieldAddOnsForm
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
];
const publicRoutes = [
  'Login',
  'Register'
]; 
const router = new VueRouter({
  routes
});

router.beforeEach((to, from, next) => {
  (async () => {
    if (!publicRoutes.includes(to.name) && (await sessionStorage.getItem('access_token') === null)) {
      next({ name: 'Login' });
    }
  })();
  
  if (to.name === 'Login' && from.name && from.name !== 'Login' &&
    from.name !== 'Register' &&
    from.name !== 'PasswordForgot' &&
    from.name !== 'PasswordReset') {
    sessionStorage.setItem('redirectPath', from.path);
  }

  next();
});

export default router;
