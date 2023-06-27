import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import axios from 'axios'
export default new Vuex.Store({
  state: {
    data: null
  },
  mutations: {
    setData(state, data) {
      state.data = data;
    }
  },
  actions: {
    fetchData({ commit }) {
      // 从后端获取数据的逻辑
          // 获取数据
    axios.get('/s')
    .then((data) => {
      console.log(data.data);
      commit('setData', data.data);
    });
    }
  },
  // 严格模式
  strict: true
})
