<template>
  <RecycleScroller
      class="scroller"
      :items="list"
      :item-size="50"
      :buffer="10"
      key-field="name"
      v-slot="{ item }">
    <!-- 这里就是自己要渲染的每一项的内容-->
    <div class="user">
      {{ item.name }}
    </div>
  </RecycleScroller>
</template>
<script>
import axios from 'axios';
export default {
  data(){
    return {
      list: []
    }
  },
  methods:{

  },
  mounted(){
    axios.get('/a')
    .then(res=>{
      
      this.list  = res.data
      console.log(this.list)
    })
  }
}
</script>
<style lang="scss" scoped>
.scroller {
  height: calc(100vh - 50px);
}
.user {
  height: 33%;
  padding: 0 12px;
  display: flex;
  align-items: center;
}
</style>