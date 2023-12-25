
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue'), meta: { public: false } },
      { path: 'jogadores', component: () => import('pages/Jogadores/Jogadores.vue'), meta: { public: false } },
      { path: 'partidas', component: () => import('pages/Partidas/Partidas.vue'), meta: { public: false } },

    ]
  },
  {
    path: '/login',
    component: () => import('layouts/Auth.vue'),
    children: [
      { path: '', component: () => import('pages/Login.vue'), meta: { public: true } },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
