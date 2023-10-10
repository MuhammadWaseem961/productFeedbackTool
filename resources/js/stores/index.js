import { createStore } from "vuex";
import axios from "axios";

export default createStore({
    state: {
        user: JSON.parse(localStorage.getItem('user')) || {},
        apiUrl:"http://127.0.0.1:8000/api/"
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
        Logout({ commit }, user) {
            commit('setUser', user);
        },
        adminLogin({ commit }, user) {
            commit('setUser', user);
        }
    },
    getters: {}
});
