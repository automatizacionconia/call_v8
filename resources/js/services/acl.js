import store from '../store';

export default {
    // methods: {
    isLoggedIn() {
        return !!store.getters['auth/getMe']
    },
    /* string */
    hasRole(payload) {
        let me = store.getters['auth/getMe']
        return _.includes(me.roles, payload)
    },
    /* string */
    hasPermission(payload) {
        let permisos = store.getters['auth/getRutas']
        return _.includes(permisos, payload)
    },
    /* array */
    hasAnyPermission(permissions) {
        let me = store.getters['auth/getMe']
        return permissions.some(p => me.permissions.includes(p))
    },
    /* array */
    hasAnyRole(roles) {
        let me = store.getters['auth/getMe']
        return roles.some(r => me.roles.includes(r))
    },
    /* array */
    hasAllRoles(roles) {
        let me = store.getters['auth/getMe']
        return _.difference(roles, me.roles).length === 0
    },
    /* array */
    hasAllPermissions(permissions) {
        let me = store.getters['auth/getMe']
        return _.difference(permissions, me.permissions).length === 0
    },
    /* string */
    can(permission) {
        return store.getters['auth/getMe'].can[permission]
    }
    // }
}