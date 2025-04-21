const ClientesRoutes = [
    {
      path: "/app/call/clientes",
      component: require("@/pages/call/Page").default,
      meta: { requiresAuth: true },
      children: [
        {
          path: "/",
          name: "app.call.clientes.lista",
          component: require("@/pages/call/clientes/components/List").default,
          meta: { requiresAuth: true },
        },   
      ]
    },
  ];
  
  export default ClientesRoutes;
  