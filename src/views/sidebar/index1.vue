<template>
  <div>
    <el-menu 
          style="box-sizing: border-box;height: 100%;"
          default-active="" 
          class="el-menu-vertical-demo" 
          :collapse="isCollapse">
          <div :style="{width:isCollapse==true?'63px':'220px'}" class="customs">
              <span style="float: left;" v-if="!isCollapse">关卡</span>
              <span style="float: right;" v-if="!isCollapse">
                <i class="el-icon-download" @click="sort()" title="排序"></i>&nbsp;
                <i class="el-icon-search" @click="inquire()" title="搜索"></i>&nbsp;
                <!-- 新增 -->
                <i class="el-icon-circle-plus" @click="fn(navigation,box)" title="新增"></i>&nbsp;
                <!-- 收起导航 -->
                <i class="el-icon-d-arrow-left" @click="isCollapse=!isCollapse" title="关闭"></i></span>
                <!-- 展开 -->
                <i class="el-icon-d-arrow-right"  v-if="isCollapse" @click="isCollapse=!isCollapse"></i>
          </div>
          <div class="box" ref="scrollContainer" :style="{width:isCollapse==true?'63px':'220px'}" style="height:calc(100% - 50px);overflow: auto;">
            <div class="box1">
              <el-submenu 
                :index="`''`+item.id" 
                v-for="(item,index) in navigation.slice(currentPage,currentPage+17)" 
                
                :key="index">
              <template slot="title">
                <i class="el-icon-location"></i>
                <!-- 右键 -->
                <span 
                  @contextmenu.prevent="openMenu($event,'0'+item.id,index,item)" 
                  slot="title">{{isCollapse==false? item.name:''}}
                </span>
                  </template>
                  <draggable v-model="item.levels" group="menu1" @start="onChildDragEnd(item.name,index)" @add="onDragEnd1(item.name,index)">
                        <el-submenu
                            @click.native="shows = items.id"
                            :style="{backgroundColor: shows == items.id ?'rgb(236,245,255)':''}" :index="`''`+items.id"  
                            v-for="(items,indexs) in item.levels.slice(0,more == true ? 3:item.levels.length)"  
                            :key="indexs">
                        <template slot="title">
                          <i class="el-icon-location"></i>
                          <span @contextmenu.prevent="openMenu($event,'1'+items.id,indexs,items.name,index)" @click="$emit('introduction',introduction = [item,items])" slot="title">
                            {{items.name}}{{'id：'+ items.id }}
                          </span>
                        </template>
                        <el-menu-item :index="indexs+''+indexs1" v-for="(items1,indexs1) in box" :key="indexs1">
                          <i class="el-icon-location"></i>
                          <span>{{ items1 }}</span>
                        </el-menu-item>
                      </el-submenu>
                    <h1 style="cursor: pointer;" v-if="item.levels.length>3" @click="more = !more">{{more == true ? '更多':'收起'}}</h1>
                  </draggable>
              </el-submenu>
            </div>
            <div class="box2"></div>
          </div>
        </el-menu>
    
    
        <!-- 新增弹出框 -->
        <dl id="add" ref="add" v-show="show" @mouseout="none()">
            <dd v-for="(add,index) in add1 == 1 ? added1:added"  @click="right(index)" class="el-icon-location" :key="index">
              {{ add }}
            </dd>
        </dl>
        <input style='width:60px' autofocus v-show="value1" ref="input" @blur.prevent="txtinput()" v-model="value">
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
      added:['新关卡','编辑','删除','查询'],
      added1:['编辑','删除','查询'],
      currentPage:0,
      // 关卡查询
      query2:[],
      currentPage1:[],
      // 关卡包查询
      currentPage2:[],
      // 列表排序
      sort1:'el-icon-download'
    };
  },

  mounted() {
    this.getData()
    const scrollContainer = this.$refs.scrollContainer;
    scrollContainer.addEventListener("scroll", this.handleScroll);
  },

  methods: {
    getData(){
      // 全部数据
      axios.post('http://poke.touchmagic.cn/klondike/bag',{_ajax:true},
      )
        .then(res=>{
          this.navigation = res.data
          this.currentPage1 = _.cloneDeep(this.navigation)
          this.currentPage2 = _.cloneDeep(this.navigation)
          document.querySelector('.box2').style.height = this.navigation.length*56+'px'
        })
        .catch(err=>{
          console.log(err);
        })
    },
    // 滚动事件
    handleScroll() {
      let box1 = document.querySelector(".box1");
      let box = this.$refs.scrollContainer.scrollTop;
      box1.style.top = box + "px";
      this.currentPage = Math.floor(box / 56)
    },
    // 列表排序
    sort(){
      // 初始化将列表进行排序
      let a = this.navigation.sort((a,b)=>a.name.localeCompare(b.name))
      console.log(a);
    },

    // 子级菜单拖拽
    onChildDragEnd(a,b) {
      // 正在拖拽的元素
      console.log('开始',a,b);
    },
    onDragEnd1(a,b) {
      console.log('结束',a,b);
    },

    // 右键
    openMenu(e,a,b,c,d){
      // e:获取元素 b:index a:下标 c:title
      // 打开的弹窗
      this.add1 = a.slice(0,1) == 0 ? '0':'1'
      this.add2 = a.slice(1)
      // 菜单下标
      this.box3 = b
      // 输入框内容
      this.value = e.currentTarget.innerHTML
      this.input = e.currentTarget
      this.show = !this.show;
      this.$refs.add.style.top = e.clientY+'px' 
      this.$refs.add.style.left = e.clientX+'px'
    },

    // 移除关闭右键
    none(){
      this.show = !this.show
    },
    // 新增
    fn(a,b){    
      $.ajax({
      url: 'http://poke.touchmagic.cn/bag/add',
      type: 'POST',
      data:{
        name:'sdfsdf',game:'Klondike',
        _ajax:true,
      },
      success: response => {
        this.getData()
      },
      error: error => {
        console.log(error);
      }
    });

      
    },
    // 关卡包查询
    inquire(){
      let a = []
      let c = this
      layer.prompt({title: '查询关卡包'}, function(value, index, elem){
            if(value.length == 0){
              c.navigation = c.currentPage2
              layer.msg('查询：内容为空')
            }else{
              // 遍历关卡是否存在改名称
            let a1 =  c.navigation.filter(e => {
              return e.name == value 
            })
            if(a1.length != 0 ){
              a = a1;
              c.navigation = a
              document.querySelector('.box2').style.height = c.navigation.length*56+'px'
              layer.msg('查询：成功'); // 显示 value
            }else{
              layer.msg('查询：未找到')
            }
          }
        // 关闭 prompt
        layer.close(index);
      })
    },
    // 右键关卡包
    right(a){
      switch(a){
        case 0:{
          this.add1 == 0 ? this.add() : this.comp()
          this.$refs.add.style.display = 'none'
          break;
        }
        case 1:{
          this.add1 == 0 ? this.comp() : this.dele()
          this.$refs.add.style.display = 'none'
          break;
        }
        case 2:{
          this.add1 == 0 ? this.dele() : this.down()
          this.$refs.add.style.display = 'none'
          break;
        }
        case 3:{
          this.add1 == 0 ? this.down() : ''
          this.$refs.add.style.display = 'none'
          break;
        }
      }
    },
    // 删除
    dele(b,a){
      this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          $.ajax({
            url:this.add1 == 0 ? 'http://poke.touchmagic.cn/bag/del' : 'http://poke.touchmagic.cn/klondike/del',
            type: 'POST',
            data:{
              ids:this.add2,
              _ajax:true,
            },
            success: response => {
              this.getData()
            },
            error: error => {
              console.log(error);
            }
          });
          this.$emit('introduction',this.introduction = '0')
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          });          
        });
    },
    // 增加关卡.length
    add(a,b){
        $.ajax({
          url: 'http://poke.touchmagic.cn/klondike/add',
          type: 'POST',
          data:{
            pokebag_model_id:this.add2,
            name:'ABC',
            game:{},
            moves:12,
            _ajax:true,
          },
          success: response => {
            this.getData()
          },
          error: error => {
            console.log(error);
          }
        });
    },
    // 编辑
    comp(){
      this.value1 = true
      this.input.innerHTML = ''
      this.input.appendChild(this.$refs.input)
      setTimeout(()=>{
        this.$refs.input.focus()
        
      },10)
    },
    // 查询
    down(){
      let b = []
      let box3 = this.box3
      this.query2 = []
      this.query2 = this.navigation[box3].levels
      let c = this.query2
      let navigation = this.navigation
      let currentPage1 = this.currentPage1
      layer.prompt({title: '请输入文本'}, function(value, index, elem){
            if(value.length != 0){
              c.forEach(e => {
              if(e.name.indexOf(value) >= 0){
                b[b.length] = e
                navigation[box3].levels = b
                layer.msg('查询：成功'); // 显示 value
              }else{
                navigation[box3].levels = b
              } 
              if(b.length <= 0){
                layer.msg('查询失败：未找到'); // 显示 value
              }});
            }else{
              navigation[box3].levels = currentPage1[box3].levels
            }
        
        // 关闭 prompt
        layer.close(index);
      })
    },
    // 编辑失去焦点
    txtinput(){
      if(this.value.length <= 6 && this.value != 0){
        console.log(this.value);
        this.value1 = false,
        this.input.innerHTML = this.value
        axios({
          url:this.add1 == 0 ?'http://poke.touchmagic.cn/bag/rename':'http://poke.touchmagic.cn/klondike/rename',
          method:"POST",
          data:{
            id:this.add2,
            name:this.value,
            _ajax:true
          }
        })
          .then(res => {
            console.log(res);
            res.data.msg.length == 0 ?
            this.$message({
                type: 'success',
                message: '修改成功!'
              }):
              this.$message({
                type: 'info',
                message: '命名已存在'
                
              })
              this.getData()
          })
          .catch(err => {
            console.log('修改失败');
          })
      }else{
        alert('命名长度为大于等于6字符')
        setTimeout(()=>{
        this.$refs.input.focus()
      },10)
      }
    }
  },
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