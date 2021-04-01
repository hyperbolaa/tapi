<template>
  <div class="cont-project-Api">
    <el-row :gutter="10">
      <el-col :span="6">
        <ApiMenu />
      </el-col>
      <el-col :span="18">
        <div class="api-item-cont">
          <el-tabs v-model="activeName" class="role-box" type="border-card">
            <el-tab-pane label="预览" name="prev">
              <ApiPrev v-if="Object.keys(apiInfo).length > 0" ref="prev" />
            </el-tab-pane>
            <el-tab-pane label="编辑" name="edit">
              <ApiEdit v-if="Object.keys(apiInfo).length > 0" ref="prev" />
            </el-tab-pane>
            <el-tab-pane label="运行" name="run">
              <ApiRun v-if="Object.keys(apiInfo).length > 0" ref="prev" />
            </el-tab-pane>
          </el-tabs>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import ApiMenu from '@/view/project/api/components/menu';
import ApiPrev from '@/view/project/api/detail/prev';
import ApiEdit from '@/view/project/api/detail/edit';
import ApiRun from '@/view/project/api/detail/run';
import { store } from '@/store';

export default {
  name: 'ApiDetail',
  components: { ApiMenu, ApiPrev, ApiEdit, ApiRun },
  data() {
    return {
      activeName: 'prev',
      did: 0,
      apiInfo: {},
    };
  },
  watch: {
    $route() { // 因为组件缓存，必须监听路由, 不采用 router-view 方式解除缓存原因为初始化太多; 使用prop单向数据传递
      this.initData('change');
    },
  },
  mounted() { // 监听接口编辑
    this.$bus.on('apiSave', () => {
      this.initData('change');
    });
  },
  created() { // 组件prop对象为引用传递， 所以使用store处理
    this.initData('create');
  },
  methods: {
    initData(tag){
      this.did = parseInt(this.$route.params.did);
      this.getInfo(tag);
    },
    async getInfo(tag) {
      await store.dispatch('api/setApiInfo', this.did);
      const apiInfo = store.getters['api/apiInfo'];
      if (Object.keys(apiInfo).length > 0){
        this.apiInfo = apiInfo;
        tag === 'change' && this.$bus.emit('apiChange');
      } else {
        await this.$router.push({ name: '404' });
      }
    },
  },
};
</script>
<style lang="scss">

</style>
