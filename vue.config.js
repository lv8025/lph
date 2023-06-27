module.exports = {
  pages: {
    index: {
      // page 的入口
      entry: 'src/main.js',
      // 模板来源
      template: 'public/index.html',
      // 在 dist/index.html 的输出
      filename: 'index.html',
      // 当使用 title 选项时，
      // template 中的 title 标签需要是 <title><%= htmlWebpackPlugin.options.title %></title>
      title: '蜘蛛纸牌', // 改的就是网页的标题 同在HTML中的title一样
    },
  },
  devServer: {
    proxy: {
      '/x': {
        target: 'http://localhost:3005/api/data',
        ws: true,
        changeOrigin: true,
          pathRewrite:{
            '^/x':''
          }
      },
      // 菜单栏数据
      '/z': {
        target: 'http://localhost:3005/api/add',
        ws: true,
        changeOrigin: true,
          pathRewrite:{
            '^/z':''
          }
      },
      // 同id修改
      '/s': {
        target: 'http://localhost:3005/api/cha',
        ws: true,
        changeOrigin: true,
          pathRewrite:{
            '^/s':''
          }
      },
      // 同id修改
      '/a': {
        target: 'http://localhost:3005/api/cha1',
        ws: true,
        changeOrigin: true,
          pathRewrite:{
            '^/a':''
          }
      },
      '/bag/add': {
        target: 'http://poke.touchmagic.cn/bag/add',
        ws: true,
        changeOrigin: true,
          pathRewrite:{
            '^/bag/add':''
          }
      },
    }
  }
}