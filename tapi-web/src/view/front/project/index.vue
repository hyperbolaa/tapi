<template>
  <el-container class="tapi-doc">
    <el-aside>
      <el-scrollbar class="default-scrollbar" wrap-class="default-scrollbar__wrap">
        <transition :duration="{ enter: 800, leave: 100 }" mode="out-in" name="el-fade-in-linear">
          <PjMenu />
        </transition>
      </el-scrollbar>
    </el-aside>
    <el-main>
      <el-scrollbar class="default-scrollbar" wrap-class="default-scrollbar__wrap">
        <transition :duration="{ enter: 800, leave: 100 }" mode="out-in" name="el-fade-in-linear">
          <PjDetail />
        </transition>
      </el-scrollbar>
    </el-main>
  </el-container>
</template>

<script>
import PjMenu from '@/view/front/project/menu/index';
import PjDetail from '@/view/front/project/detail/index';

export default {
  name: 'Pj',
  components: {
    PjMenu,
    PjDetail,
  },
  data() {
    return {

    };
  },
};
</script>

<style lang="scss">
.tapi-doc .el-aside{
  background-color: white;
  overflow: hidden;
  border-right: 1px solid silver;
}
.tapi-doc .el-main{
  background-color: white;
  overflow: hidden;
  padding: 0;
}
.tapi-doc .default-scrollbar{
  height:calc(100vh - 60px);
}
.tapi-doc .el-scrollbar__wrap.default-scrollbar__wrap {
  overflow-x: auto;
}
</style>
