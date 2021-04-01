<template>
  <div style="padding-top: 10px;">
    <el-row :gutter="10">
      <el-col :span="12">
        <div>
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>数据导入</span>
            </div>
            <div class="text item">
              <el-select v-model="value" placeholder="请选择">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </div>
          </el-card>
        </div>
      </el-col>
      <el-col :span="12">
        <div>
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>数据导出</span>
            </div>
            <div class="text item">
              <el-select v-model="value" placeholder="请选择">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </div>
          </el-card>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'ProjectData',
  data() {
    return {
      options: [{
        value: '选项1',
        label: '黄金糕',
      }, {
        value: '选项2',
        label: '双皮奶',
      }, {
        value: '选项3',
        label: '蚵仔煎',
      }, {
        value: '选项4',
        label: '龙须面',
      }, {
        value: '选项5',
        label: '北京烤鸭',
      }],
      value: '',
    };
  },
};
</script>

<style lang="scss">

</style>
