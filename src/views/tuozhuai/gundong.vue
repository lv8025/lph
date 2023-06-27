<template>
  <div>
    <el-menu 
          style="box-sizing: border-box;height: 100%;"
          default-active="" 
          class="el-menu-vertical-demo" 
          :collapse="isCollapse">
          <div :style="{width:isCollapse==true?'63px':'200px'}" class="customs">
              <span style="float: left;" v-if="!isCollapse">关卡</span>
              <span style="float: right;" v-if="!isCollapse">
                <i class="el-icon-search" @click="fn1(navigation,box)"></i>&nbsp;
                <!-- 新增 -->
                <i class="el-icon-circle-plus" @click="fn(navigation,box)"></i>&nbsp;
                <!-- 收起导航 -->
                <i class="el-icon-d-arrow-left" @click="isCollapse=!isCollapse"></i></span>
                <!-- 展开 -->
                <i class="el-icon-d-arrow-right"  v-if="isCollapse" @click="isCollapse=!isCollapse"></i>
          </div>
          <div class="box" ref="scrollContainer" :style="{width:isCollapse==true?'63px':'200px'}" >
             <div class="box1">
              <el-submenu :index="`''`+item.id" v-for="(item,index) in navigation.slice(currentPage,currentPage+17)" :key="index">
                      <template slot="title">
                        <i class="el-icon-location"></i>
                        <span 
                          @contextmenu.prevent="openMenu()" 
                          slot="title">{{isCollapse==true?'':item.name}}</span>
                      </template>
                      <el-submenu index="1-4">
                        <template slot="title">选项4</template>
                        <el-menu-item index="1-4-1">选项1</el-menu-item>
                      </el-submenu>
                  </el-submenu>
             </div>
             <div class="box2"></div>
          </div>
        </el-menu>
  </div>
</template>

<script>
import _ from 'lodash';
import axios from 'axios';
import $ from 'jquery';
import draggable from 'vuedraggable'
export default {
  name: 'GameIndex',
  components: {
    draggable
  },
  data() {
    return {
      //向牌桌传入的关卡
      introduction:'',
      // 导航栏的展开收起
      isCollapse: false,
      // box:'展开',
      navigation:[],
      // 新关卡包
      box:[
        '台桌','卡牌'
      ],
      // 激活的关卡的颜色
      shows: false,
      // 更多
      more:true,
      // 查询
      query2:[],
      //右键选择的索引
      box3:'',
      // 获取的编辑元素
      input:'',
      value1:false,
      value:'',
      add1:'1',
      add2:'',
      dataLoaded: false,
      // 显示隐藏添加
      show:false,
      currentPage:0,
    };
  },

  mounted() {
    // this.getData()
    this.a1(0)
      const scrollContainer = this.$refs.scrollContainer;
      scrollContainer.addEventListener("scroll", this.handleScroll);
    },

  methods: {
    handleScroll() {
      let box1 = document.querySelector(".box1");
      let box = this.$refs.scrollContainer.scrollTop;
      box1.style.top = box + "px";
      this.currentPage = Math.floor(box / 56.1)
    },

    a1(){
      axios.get('/a')
      .then((data) => {
        this.navigation = data.data
        document.querySelector('.box2').style.height = this.navigation.length*56.1+'px'
      });
    },
      
    },
    // 检索
    fn1(){
      let a = this
      layer.prompt({title: '查询'}, function(value, index, elem){
              if(value != ''){
                $.ajax({
                  url:'/s',
                  methods: ['GET'],
                  data:{
                    page:value
                  },
                  success:(res)=>{
                    console.log(res);
                    if(res.length ==0){
                      layer.msg('查询：未找到'); // 显示 value
                    }else{
                      layer.msg('查询：成功'); // 显示 value
                      a.navigation = res
                    }
                  },
                  error:(err)=>{
                    console.log(err);
                  }
                })
              }else{
                a.a1()
                layer.msg('查询：成功'); // 显示 value
              }
        // 关闭 prompt
        layer.close(index);
      })
    },
    fn2(){
      console.log('1');
    }
};
</script>

<style lang="scss" scoped>
    #add,#add1{
    z-index: 2;
    width: 120px;
    background: white;
    padding: 3px 3px 3px 3px;
    display: block;
    position: fixed; 
    box-shadow:3px 3px 5px 3px #aaa;
    dd{
      width: 100%;
      line-height: 30px;
    }
     dd:hover{
        background: rgb(4, 253, 249);
        border-radius:5px;
      }
  }
  .customs{
    box-sizing: border-box;
    font-size: 18px;
    padding: 0 10px;
    text-align: center;
    height: 48px;
    line-height: 48px;
    background-color: rgb(226, 226, 226);
    i{
      color: rgb(30, 159, 255)
    }
  }
  .box{
    height:calc(100vh - 50px);
    // overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box !important;
    position: relative;
    .box1{
      position: absolute;
      top: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }
    .box2{
      position: absolute;
      top: 0;
      width: 100%;
    }
  }
</style>