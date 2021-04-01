<template>
  <div class="cont-project">
    <el-menu
      mode="horizontal"
      :default-active="active"
      @select="selectMenuItem"
    >
      <template v-for="item in menuList">
        <el-menu-item :key="item.id" :index="item.index">
          <span slot="title">{{ item.name }}</span>
        </el-menu-item>
      </template>
    </el-menu>

    <router-view />
  </div>
</template>

<script>

export default {
  name: 'Project',
  data() {
    return {
      pid: 0,
      menuList: [],
      active: '',
    };
  },
  watch: {
    $route() {
      this.pid = parseInt(this.$route.params.pid);
      this.setMenuList();
    },
  },
  created() {
    this.pid = parseInt(this.$route.params.pid);
    this.setMenuList();
  },
  methods: {
    setMenuList(){ // 二级导航
      this.menuList = [
        { id: 0, index: '/console/project/' + this.pid + '/api', name: '接口列表' },
        { id: 1, index: '/console/project/' + this.pid + '/col', name: '测试集合' },
        { id: 2, index: '/console/project/' + this.pid + '/trend', name: '项目动态' },
        { id: 3, index: '/console/project/' + this.pid + '/data', name: '数据管理' },
        { id: 4, index: '/console/project/' + this.pid + '/member', name: '成员管理' },
        { id: 5, index: '/console/project/' + this.pid + '/setting', name: '项目设置' },
        { id: 6, index: '/console/project/' + this.pid + '/wiki', name: 'wiki' },
      ];
      this.menuList.map(item => {
        if (this.$route.path.indexOf(item.index) !== -1){
          this.active = item.index;
        }
      });
    },
    selectMenuItem(index) {
      if (index === this.$route.path) {
        return;
      }
      this.$router.push({ path: index });
    },
  },
};
</script>
<style lang="scss">

</style>

