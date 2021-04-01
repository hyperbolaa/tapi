<template>
  <div>
    <el-timeline>
      <el-timeline-item timestamp="2018/4/12" placement="top">
        <el-card>
          <h4>更新 Github 模板</h4>
          <p>王小虎 提交于 2018/4/12 20:46</p>
        </el-card>
      </el-timeline-item>
      <el-timeline-item timestamp="2018/4/3" placement="top">
        <el-card>
          <h4>更新 Github 模板</h4>
          <p>王小虎 提交于 2018/4/3 20:46</p>
        </el-card>
      </el-timeline-item>
      <el-timeline-item timestamp="2018/4/2" placement="top">
        <el-card>
          <h4>更新 Github 模板</h4>
          <p>王小虎 提交于 2018/4/2 20:46</p>
        </el-card>
      </el-timeline-item>
    </el-timeline>
  </div>
</template>

<script>
import { store } from '@/store';

export default {
  name: 'TeamTrend',
  data() {
    return {
      teamInfo: {},
      trendInfo: [],
    };
  },
  watch: {
    $route() {
      this.initData();
    },
  },
  created() {
    this.initData();
  },
  methods: {
    initData(){
      this.teamInfo = store.getters['team/teamInfo'];
      this.getTrend();
    },
    getTrend(){
      console.log('getTrend', this.teamInfo.id);
    },
  },
};
</script>

<style lang="scss">

</style>
