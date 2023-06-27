<template>
  <div class="home">
    <!-- 头部 -->
    <ul class="layui-nav">
      <li class="layui-nav-item" v-for="(item, index) in box" :key="index" lay-unselect>
        <a href="javascript:;">
          <i class="layui-icon" :class="item.clas"></i>
          <span>{{ item.name }}</span>
        </a>
        <dl class="layui-nav-child">
          <dd v-for="(items, index) in item.children" :key="index">
            <a href="javascript:;">{{ items }}</a>
          </dd>
          <template v-if="item.tui">
            <hr>
            <dd style="text-align: center;"><a href="nav.html">{{ item.tui }}</a></dd>
          </template>
        </dl>
      </li>
    </ul>
    <navigation></navigation>
  </div>
</template>

<script>
import navigation from './navigation.vue';
export default{
  components: { navigation },
  data(){
    return {
      box:[
        {imgs:'https://unpkg.com/outeres@0.0.10/demo/avatar/1.jpg'
          ,name:"admin",
          clas:'layui-icon-github',
          tui:'退出',
          children:[
            "重置密码"
          ]},
          {imgs:'https://unpkg.com/outeres@0.0.10/demo/avatar/1.jpg'
          ,name:"工具",
          clas:'layui-icon-slider',
          children:[
            "Help","Update","About"
          ]},
          {imgs:'https://unpkg.com/outeres@0.0.10/demo/avatar/1.jpg'
          ,name:"帮助",
          clas:'layui-icon-tips-fill',
          children:[
          "Help","Update","About"
          ]},
      ]
    }
  },
  components:{
    navigation
  },
  mounted() {

  },
  methods:{

  }
}

</script>

<style scoped  lang="scss">
  .layui-nav .layui-nav-item{
    height: 45px;
    line-height: 45px;
  }
  .layui-nav{
    padding: 0 ;
    li{
      i{
        font-size: 20px;
        color: #1E9FFF;
        margin-right: 8px;
        position: relative;
        top: 3px;
      }
      .layui-nav-child{
        left: 30px;
        top:45px;
        a{
          &:hover{
            background-color: rgb(2, 181, 246);
          }
        }
        .layui-this {
          background-color: red;
        }
      }
    }
  }
</style>
