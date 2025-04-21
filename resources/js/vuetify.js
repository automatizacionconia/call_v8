import Vue from "vue";
import Vuetify from "vuetify";
import en from "vuetify/lib/locale/en";
import es from "vuetify/lib/locale/es";
import store from "./store";
Vue.use(Vuetify);

const vuetify = new Vuetify({
  lang: {
    locales: { es, en },
    current: "es",
  },
  icons: {
    iconfont: "mdi", // default - only for display purposes
  },
  theme: {
    dark: false,
    themes: {
      light: {
        primary: '#01579B', //'#1976D2',
        secondary: '#424242',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        entidad: store.state.color.colorEntidad,
      },
      dark: {
        primary: '#01579B', // Cambia este valor para personalizar el color primario en modo oscuro
        secondary: '#FFCDD2',
        accent: '#FF4081',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FB8C00',
      },
    },
  },
});

store.watch(
  (state) => state.color.colorEntidad,
  (nuevoColor) => {
    vuetify.framework.theme.themes.light.primary = nuevoColor;
  }
);

export default vuetify;

// {
//   primary: '#1976D2',
//   secondary: '#424242',
//   accent: '#82B1FF',
//   error: '#FF5252',
//   info: '#2196F3',
//   success: '#4CAF50',
//   warning: '#FFC107',
// }
