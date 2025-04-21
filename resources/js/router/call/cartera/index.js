const CarteraRoutes = [
    {
      path: "/app/call/cartera",
      component: require("@/pages/call/Page").default,
      meta: { requiresAuth: true },
      children: [
        {
          path: "/",
          name: "app.call.cartera.lista",
          component: require("@/pages/call/cartera/components/List").default,
          meta: { requiresAuth: true },
        },
        {
          path: "bandeja-llamadas",
          name: "app.call.cartera.bandeja-llamadas",
          component: require("@/pages/call/cartera/components/BandejaLlamadas").default,
          meta: { requiresAuth: true },
        },
        {
          path: "reportes",
          name: "app.call.cartera.reportes",
          component: require("@/pages/call/cartera/components/Reportes").default,
          meta: { requiresAuth: true },
        }
      ]
    },
  ];
  
  export default CarteraRoutes;
  