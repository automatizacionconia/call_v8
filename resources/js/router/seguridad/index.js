const SeguridadRoutes = [
  {
    path: "/app/seguridad",
    component: require("@/pages/seguridad/Page").default,
    meta: { requiresAuth: true },
    children: [
      {
        path: "/app/seguridad/opciones",
        name: "app.seguridad.opciones",
        component: require("@/pages/seguridad/opciones/components/List").default,
        meta: { requiresAuth: true },
      }, 
      {
        path: "/app/seguridad/roles",
        name: "app.seguridad.roles",
        component: require("@/pages/seguridad/roles/components/List").default,
        meta: { requiresAuth: true },
      },{
        path: "/app/seguridad/usuarios",
        name: "app.seguridad.usuarios",
        component: require("@/pages/seguridad/usuarios/components/List").default,
        meta: { requiresAuth: true },
      },{
        path: "/app/seguridad/empresas",
        name: "app.seguridad.empresas",
        component: require("@/pages/seguridad/empresas/components/List").default,
        meta: { requiresAuth: true },
      }  
    ]
  },
];

export default SeguridadRoutes;
