const PlataformaRoutes = [
    {
      path: "/app/call/plataforma",
      component: require("@/pages/call/Page").default,
      meta: { requiresAuth: true },
      children: [
        {
          path: "/",
          name: "app.call.plataforma.lista",
          component: require("@/pages/call/plataforma/components/List").default,
          meta: { requiresAuth: true },
        },   
      ]
    },
  ];
  
  export default PlataformaRoutes;
  