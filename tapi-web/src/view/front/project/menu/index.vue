<template>
  <div class="doc-menu">
    <el-input
      v-model="filterText"
      placeholder="搜索接口"
      clearable
    />
    <div class="cont-menu">
      <el-tree
        ref="tree"
        :data="data"
        node-key="id"
        icon-class="el-icon-arrow-right"
        :filter-node-method="filterNode"
        :highlight-current="highLight"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PjMenu',
  data() {
    const data = [
      {
        id: 1,
        label: '项目说明',
        type: 'all',
      },
      {
        id: 2,
        label: '一级 2',
        type: 'cat',
      },
      {
        id: 3,
        label: '一级 3',
        type: 'cat',
        children: [{
          id: 7,
          label: '二级 3-1',
          type: 'api',
        }, {
          id: 8,
          label: '二级 3-2',
          type: 'api',
        }],
      },
    ];
    return {
      highLight: true,
      filterText: '',
      data: JSON.parse(JSON.stringify(data)),
    };
  },
  watch: {
    filterText(val) {
      this.$refs.tree.filter(val);
    },
  },
  methods: {
    filterNode(value, data) {
      if (!value) {
        return true;
      }
      return data.label.indexOf(value) !== -1;
    },
  },
};
</script>
<style lang="scss">
.doc-menu{
  padding: 20px;
}
.doc-menu .cont-menu{
  margin-top: 10px;
}
</style>
