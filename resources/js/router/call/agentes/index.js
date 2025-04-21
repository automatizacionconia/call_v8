const AgentesRoutes = [
    {
      path: "/app/call/agentes",
      component: require("@/pages/call/Page").default,
      meta: { requiresAuth: true },
      children: [
        {
          path: "/",
          name: "app.call.agentes.lista",
          component: require("@/pages/call/agentes/components/List").default,
          meta: { requiresAuth: true },
        },   
      ]
    },
  ];
  
  export default AgentesRoutes;
  