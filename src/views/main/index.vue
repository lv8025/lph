<template>
  <div class="nav">
    <div>
      <el-button @click="show1()" type="primary" round>{{cards = show==false?'显示底牌':'隐藏底牌'}}</el-button>
      <h1>需要&nbsp;{{ remain }}&nbsp;步</h1>
      <h3>ID:{{ids}}</h3>
    </div>
    <div style="padding: 0 80px;display: flex;justify-content: space-between;">
      <img v-show="!show" src="../../assets/Card/CardBackBase001.png" width="120" alt="">
      <!-- 隐藏显示 -->
      <div v-show="show" style="width: 40%;height: 166px;display: flex;flex-wrap: nowrap;">
        <span v-for="(stock1,indexs) in stock" :key="indexs"
         style="float: left;box-shadow:0px 3px 5px 3px #dfdcdc;"
        :style="{transform:`translate3d(${-69.2*indexs+'px'},0,0)`}"
        ><img :src= "require('../../assets/Card/CardFront'+stock1.b+stock1.a)" width="120px" alt=""></span>
      </div>
      <div  class="empty">
        <span v-for="(item,index) in data1" :key="index">
          {{item}}
          </span>
        </div>
    </div>
    <div style="position: absolute; top: 47%;left: 18%;">
      <span class="span" v-for="(item1,index1) in underpans" :key="index1" style="marginLeft: 45px;">
        <ul 
          v-for="(item2,index2) in item1" :key="index2" 
          :style="{display: 'block',
          transform:`translate3d(0,${-140*index2+'px'},0)`
          }">
          <li><img :src= "require('../../assets/Card/CardFront'+item2.b+item2.a)" width="120px" alt=""></li>
        </ul>
      </span>
    </div>
  </div>
</template>

<script>
import _ from 'lodash';
import axios from 'axios';
export default {
  name: 'GameIndex',
  props:['introd'],
  data() {
    return {
      a:this.introd[1],
      b:['121','43','2781','30','27','38','30','28','33','398','42','49','26','35','34'],
      // 隐藏牌数
      stock:[],
      show:false,
      // 显示
      cards:'显示底牌',
      // 全部数据
      data:'',
      // 空牌位
      data1:'',
      // 底部
      underpans:[[],[],[],[],[],[],[]],
      box:{a:[],b:[]},
      box1:{a:[],b:[]},
      // 剩余步数
      remain:'',
      ids:"",
      names:"",
    };
  },

  mounted() {
    this.nameData()
    this.$message({
          message: '恭喜你，打开 '+this.names+'  关卡',
          type: 'success',
          duration: 1000
        });
  },

  methods: {
    show1(){
      this.show = !this.show
    },
    nameData(){
        this.data = this.a.game
        this.ids = this.a.id
        this.names = this.a.name
        this.data1 = this.data.foundations
        // 步数
        this.remain = this.a.moves
        let c;
        let d;
        let e;
        //显示的牌
        for(let i = 0; i < this.data['tableau piles'].length; i++){
          for(let j = 0; j < this.data['tableau piles'][i].length; j++){
            c = this.data['tableau piles'][i][j]
            if(c.length != 3){
              if(c.substr(0,1)=='J'){
                d = 11+'.png'
              }else if(c.substr(0,1)== 'Q'){
                d = 12+'.png'
              }else if(c.substr(0,1)=='K'){
                d = 13+'.png'
              }else if(c.substr(0,1)== 'A'){
                d = '0'+'1.png'
              }else{
                d = '0'+c.substr(0,1)+'.png'
              }
              if(c.substr(1,1)=='C'){
                e = 'Club'
              }else if(c.substr(1,1)== 'H'){
                e = 'Heart'
              }else if(c.substr(1,1)=='D'){
                e= 'Diamond'
              }else{
                e = 'Spade'
              }
              this.box.a = d 
              this.box.b = e
            }else{
              if(c.substr(1,1)=='C'){
                e = 'Club'
              }else if(c.substr(1,1)== 'H'){
                e = 'Heart'
              }else if(c.substr(1,1)=='D'){
                e= 'Diamond'
              }else{
                e = 'Spade'
              }
                d = c.substr(0,2)+'.png'
              this.box.a = d
              this.box.b = e
            }
            this.underpans[i].push(_.cloneDeep(this.box))
          }
        }
        // 隐藏的牌
        let c1;
        let d1;
        let e1;
        for(let k in this.data.stock){
            c1 = this.data.stock[k]
            if(c1.length != 3){
              if(c1.substr(0,1)=='J'){
                d1 = 11+'.png'
              }else if(c1.substr(0,1)== 'Q'){
                
                d1 = 12+'.png'
              }else if(c1.substr(0,1)=='K'){
                d1 = 13+'.png'
              }else if(c1.substr(0,1)== 'A'){
                d1 = '0'+'1.png'
              }else{
                d1 = '0'+c1.substr(0,1)+'.png'
              }
              if(c1.substr(1,1) == 'C'){
                e1 = 'Club'
              }else if(c1.substr(1,1) == 'H'){
                e1 = 'Heart'
              }else if(c1.substr(1,1) == 'D'){
                e1 = 'Diamond'
              }else{
                e1 = 'Spade'
              }
              this.box1.a = d1 
              this.box1.b = e1
            }else{
              if(c1.substr(2,1)=='C'){
                e1 = 'Club'
              }else if(c1.substr(2,1)== 'H'){
                e1 = 'Heart'
              }else if(c1.substr(2,1)=='D'){
                e1 = 'Diamond'
              }else{
                e1 = 'Spade'
              }
              d1 = c1.substr(0,2)+'.png'
              this.box1.a = d1
              this.box1.b = e1
            }
            this.stock.push(_.cloneDeep(this.box1))
          }
    },
  },

};
</script>

<style lang="scss" scoped>
  .nav{
    span{
      display: block;
      width: 120px;
      height: 166px;
    }
    .span{
      float: right;
      text-align: center;
      box-shadow:0px 3px 5px 3px #dfdcdc;
    }
    .empty{
      span{
        display: block;
        float: right;
        margin-right: 20px;
        box-shadow:0px 0px 5px 3px #8d8d8d;
      }
    }
    
    div:nth-child(1){
      line-height: 60px;
      text-align: center;
      position: relative;
      margin: auto;
      margin-bottom: 30px;
      font-size: 22px;
      background: rgba(0, 238, 255, 0.3);
      button{
        position: absolute;
        left: 10px;
        top: 10px;
      }
      h3{
        position: absolute;
        right: 10px;
        top: 10px;
      }
    }
  }

</style>