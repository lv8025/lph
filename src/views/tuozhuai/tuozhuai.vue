<template>
  <div style="text-align: center;">
    <input type="text" v-model="a"><button @click="fn1(a)">查询</button>
    <h1>{{ b }}</h1>
    <div>
      <h1 v-for="(item,index) in box" :key="index">{{ item.name }}</h1>
    </div>
    <!-- <ul>
      <li>{{this.$store.state.const}}</li>
    </ul> -->
    <!-- <button @click="boxs()">获取数据</button> -->
    <div v-if="dataLoaded">
      <!-- 已经加载的部分 -->
      <h1 v-for="(item,index) in data" :key="index">{{ item.name}}</h1>
    </div>
    <div v-else v-cloak>
      <!-- 缓慢加载的部分 -->
      <h1>正在加载</h1>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import VirtualList from 'vue-virtual-scroll-list';
import { mapState, mapActions } from 'vuex';
import $ from 'jquery';
export default {
  components: {
    VirtualList
  },
  data() {
    return {
      box:[],
      a:'',
      b:'',
      list: [], // 从后端接口中获取的大量数据
      // dataLoaded: false,
      // data: []
    }
  },
  computed: {
    ...mapState(['data']),
    dataLoaded() {
      return this.data !== null;
    }
  },
  mounted() {
    // this.fn(this.a,this.b)
    // this.fn1()
    // this.fn2() 
    // 拿到vuex的数据
    // console.log(this.$store.getters.fn);
    if (this.data === null) {
      // 如果数据为空，则从后端获取数据
      this.fetchData();
    }

    // 获取数据
    // axios.get('/s')
    // .then((data) => {
    //   console.log(data.data);
    //   this.data = data.data;
    //   this.dataLoaded = true;
    // });
  },
  methods: {
    ...mapActions(['fetchData']),
    // 分页查询
    fn(a,b){
      this.box = []
      axios.get(`/x?page=${a}&limit=${b}`,
      )
        .then(res=>{
          for(let i = 0; i < res.data.length; i++) {
            this.box.push(res.data[i].moves)
          }
        })
        .catch(err=>{
          console.log(err);
        })
    },
    // 添加
    fn1(a){
      this.a = ''
      this.box = []
      $.ajax({
        url:'/s',
        methods: ['GET'],
        // data:{
        //   page:a
        // },
        success:(res)=>{
          console.log(res.slice(0,12));
          this.box = res.slice(0,122)
          // let a = []
          // for(let i = 0; i < res.length; i++) {
          //   a.push(res[i].name)
          // }
          // console.log(a);
          // localStorage.setItem('boxs',a)
          // console.log(localStorage.getItem('boxs').slice(0,100))
          
        //   if(res.length == 0){
        //     this.b = '查询未找到'
        // }else{
        //     this.b = ''
        //   for(let i = 0; i < res.length; i++) {
        //     this.box.push(res[i].moves)
        //   }
        //   }
        },
        error:(err)=>{
          console.log(err);
        }
      })
    },
    fn2(){
      // 全部数据
      for(let i = 0; i < 1000; i++) {
        axios.post('/z',{
        name:'Base'+i,
        password:"123"+i,
        lydate:"2013"
      })
      .then(res=>{
        console.log(res);
      })
      .catch(err=>{
        console.log(err);
      })
      }
    }
  },
}
</script>
