import Vue from "vue";
import Router from "vue-router";
import Ls from "./services/ls";
import { UserService } from "./services/user.service";
import SeguridadRoutes from "@/router/seguridad";
import AgentesRoutes from "./router/call/agentes";
import ClientesRoutes from "./router/call/clientes";
import PlataformaRoutes from "./router/call/plataforma";
import CarteraRoutes from "./router/call/cartera";

Vue.use(Router);

const router = new Router({
  // hashbang: false,
  // history: true,
  //mode: 'hash',
  routes: [
    { path: "*", redirect: "/login", meta: { requiresAuth: false } },
    // {
    //   path: "*", redirect: "/mantenimiento", meta: { requiresAuth: false }
    // },
    {
      path: "/mantenimiento",
      name: "mantenimiento",
      component: require("./pages/sistema/auth/Mantenimiento.vue").default,
      meta: { requiresAuth: false },
    },
    {
      path: "/login",
      name: "login",
      component: require("./pages/sistema/auth/Login.vue").default,
      meta: { requiresAuth: false },
    },
    {
      path: "/register",
      name: "register",
      component: require("./pages/sistema/auth/Register").default,
    },
    {
      path: "/recuperar",
      name: "app.recuperar",
      component: require("./pages/sistema/auth/ResetPassword.vue").default,
      meta: { requiresAuth: false },
    },
    {
      path: "/app",
      name: "app",
      component: require("./pages/app/App").default,
      meta: { requiresAuth: true },
      children: [
        {
          path: "/app/home",
          name: "app.home",
          component: require("./pages/home/Home").default,
          meta: { requiresAuth: true },
        },
        ...SeguridadRoutes,
        ...AgentesRoutes,
        ...ClientesRoutes,
        ...PlataformaRoutes,
        ...CarteraRoutes,
      ],
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const access_token = Ls.get("access_token");
    if (access_token) {
      next();
    } else {
      UserService.clearAccesos();
      next({ path: "/", query: { redirect: to.fullPath } });
    }
  }

  if (to.path == "/") {
    UserService.clearAccesos();
  }

  next();
});

export default router;
