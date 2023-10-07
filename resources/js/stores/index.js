import { createStore } from "vuex";
import axios from "axios";

export default createStore({
    state: {
        user: JSON.parse(localStorage.getItem('user')) || {},

    },
    mutations: {
        setUser(state, data) {
            state.user = data;
            localStorage.setItem('user', JSON.stringify(data));
        },
    },
    actions: {
        toggleSidebarColor({ commit }, payload) {
            commit("sidebarType", payload);
        },
        Login({ commit }, user) {
            commit('setUser', user);
        },
        adminLogin({ commit }, user) {
            commit('setUser', user);
        }
    },
    getters: {}
});
