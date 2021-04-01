<template>
  <el-container class="tapi-doc">
    <el-header>
      <div class="company-name">
        天喻教育科技有限公司提供技术支持
      </div>
      <div class="company-about">
        <el-link icon="el-icon-discover" href="https://www.baidu.com" target="_blank">关于我们</el-link>
      </div>
    </el-header>
    <el-container>
      <el-aside>
        <el-scrollbar class="default-scrollbar" wrap-class="default-scrollbar__wrap">
          <transition :duration="{ enter: 800, leave: 100 }" mode="out-in" name="el-fade-in-linear">
            <DocMenu :pid="pid" />
          </transition>
        </el-scrollbar>
      </el-aside>
      <el-main>
        <el-scrollbar class="default-scrollbar" wrap-class="default-scrollbar__wrap">
          <transition :duration="{ enter: 800, leave: 100 }" mode="out-in" name="el-fade-in-linear">
            <DocDetail :pid="pid" />
          </transition>
        </el-scrollbar>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import DocMenu from '@/view/front/doc/menu/index';
import DocDetail from '@/view/front/doc/detail/index';

export default {
  name: 'Doc',
  components: {
    DocMenu,
    DocDetail,
  },
  data() {
    return {
      pid: '',
    };
  },
  created() {
    this.pid = 'ssss';
  },
};
</script>

<style lang="scss">
.tapi-doc .el-header{
  box-shadow: 20px 30px 50px #e9fbff;
}
.tapi-doc .el-header .company-name {
  height: 60px;
  line-height: 60px;
  display: inline-block;
  float: left;
  font-weight: bold;
}
.tapi-doc .el-header .company-about {
  float: right;
  height: 60px;
  line-height: 60px;
  text-align: center;
  vertical-align: middle;
}
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
