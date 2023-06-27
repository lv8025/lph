<template>
  <div>
    <el-menu>
      <el-submenu index="1" @contextmenu="handleContextMenu($event, '参数1')">
        <template slot="title">菜单项1</template>
        <el-submenu index="1-1" @contextmenu.stop="handleContextMenu1($event, '参数2')">
          <template slot="title">菜单项1</template>
          <el-menu-item index="1-1-1">子菜单项1</el-menu-item>
          <el-menu-item index="1-1-2">子菜单项2</el-menu-item>
        </el-submenu>
      </el-submenu>
    </el-menu>
  </div>
</template>

<script>
import { Menu, Submenu, MenuItem } from 'element-ui';
export default {
  components: {
    'el-menu': Menu,
    'el-submenu': Submenu,
    'el-menu-item': MenuItem
  },
  methods: {
    handleContextMenu(event, param) {
      event.preventDefault();
      console.log('右键菜单被触发', param);
    },
    handleContextMenu1(event, param) {
      event.stopPropagation();
      console.log('右键菜单被触发1', param);
    },
  }
}
</script>
