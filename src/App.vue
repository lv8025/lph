<template>
  <div id="app">
    <!-- <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div> -->
      <!-- 注册 -->
    <login @change="change(arguments)" :dialogs.sync="dialogs" :dialog.sync="dialog"></login>

    <!-- 登录 -->
    <register @change1="change(arguments)" :dialogs.sync="dialogs" :dialog.sync="dialog"></register>
    
    <router-view/>
  </div>
</template>

<script>
import login from './components/popups/login.vue'
import register from './components/popups/register.vue'
  export default{
    data(){
      return {
        // 登录
        dialog: false,
        // 注册
        dialogs: false,
      }
    },
    components:{
      login,
      register
    },
    methods:{
      change(event){
        this.dialogs = event[0]
        this.dialog = event[1]
      }   
    },
    mounted(){

    }
  }
</script>

<style lang="scss">
  *{
    margin: 0;
    padding: 0;
    list-style: none;
  }
</style>
