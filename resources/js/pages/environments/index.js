const origin = window.location.origin;

export const environment = {
    API_URL: /*${origin}/*/`${process.env.MIX_APP_URL}/api`,
    APP_URL: /*${origin}/*/`${process.env.MIX_APP_URL}`,
    APP_NAME: process.env.MIX_APP_NAME,
    APP_VERSION: process.env.MIX_APP_VERSION,
    ENTIDAD_APP_NAME: process.env.MIX_ENTIDAD_APP_NAME,
    ENTIDAD_PERIODO_INICIO: process.env.MIX_ENTIDAD_PERIODO_INICIO,
};
