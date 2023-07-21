<template>
  <div>
    <form>
      <label for="">请输入服务器地址：</label>
    <select name="url" v-model="box.serverAddress">
      <option value="" disabled selected hidden>请选择一个选项</option>
      <option value="192.168.33.212">192.168.33.212</option>
      <option value="localhost">localhost</option>
    </select><br>
    <label for="">请输入用户名：</label>
    <input type="text" name="name" v-model="box.username"><br>
    <label for="">请输入密码：</label>
    <input type="text" name="password" v-model="box.password"><br>
    <label for="dropdown">选择数据库：</label>
    <select name="dropdown" v-model="box.database">
      <option value="" disabled selected hidden>请选择一个选项</option>
      <option value="lvpenghui">lvpenghui</option>
      <option value="box">box</option>
    </select>
    <br>
    <input ref="a" type="file" @change="handleFileUpload" />
    <button @click="uploadFile">上传文件</button><br>
    </form>
  <el-table
    v-if="data.data"
    :data="data.data.slice(currentPage1-5,currentPage1)"
    stripe
    style="width: 100%">
    <el-table-column
      prop="id"
      label="id"
      width="180">
    </el-table-column>
    <el-table-column
      prop="x"
      label="x"
      width="180">
    </el-table-column>
    <el-table-column
      prop="y"
      label="y"
      width="180">
    </el-table-column>
    <el-table-column
      prop="z"
      label="z"
      width="180">
    </el-table-column>
    <el-table-column
      prop="crop"
      label="植物"
      width="180">
    </el-table-column>
    <el-table-column
      prop="size"
      label="大小">
    </el-table-column>
  </el-table>
  <div class="block">
    <el-pagination
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
      :current-page="10000"
      :page-sizes="[5, 200, 300, 400]"
      :page-size="5"
      layout="total, sizes, prev, pager, next, jumper"
      :total="10000">
    </el-pagination>
  </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      box:{
        serverAddress: '',
        username: '',
        password: '',
        database: '',
        file: null,
      },
      data:'',
      currentPage1: 1,
      currentPage2: 5,
    };
  },
  methods: {
      handleSizeChange(val) {
        this.currentPage1 += this.currentPage2;
        console.log(`每页 ${val} 条`,this.currentPage1);
      },
      handleCurrentChange(val) {
         this.currentPage1 = 5 * val;
        console.log(`当前页: ${val}`,this.currentPage1);
      },
    handleFileUpload(event) {
      this.box.file = event.target.files[0];
      console.log(event.target.files[0]);
    },
    uploadFile() {
      const formData = new FormData();
      formData.append('excelFile', this.box.file);
      formData.append('serverAddress', this.box.serverAddress);
      formData.append('username', this.box.username);
      formData.append('password', this.box.password);
      formData.append('database', this.box.database);

      axios.post('/api',formData)
        .then(response => {
          this.data = response.data;
          console.log(this.data);
        })
        .catch(error => {
          console.error('请求出错：', error);
        });
    },
  },
};
</script>
