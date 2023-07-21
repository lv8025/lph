module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://localhost:3005/add.php', // 后端API服务器的地址
        changeOrigin: true,
        pathRewrite: {
          '^/api': '' // 若后端API服务器无前缀，则删除本行
        }
      }
    }
  }
};
