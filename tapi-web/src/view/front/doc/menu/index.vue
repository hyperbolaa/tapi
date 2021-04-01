<template>
  <div class="doc-menu">
    <div class="cont-menu">
      <el-tree
        ref="tree"
        :data="data"
        node-key="id"
        icon-class="el-icon-arrow-right"
        :current-node-key="currentNode"
        @node-click="selectNode"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'DocMenu',
  props: {
    pid: {
      default: '',
      type: String,
      required: true,
    },
  },
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
      currentNode: 1,
      data: JSON.parse(JSON.stringify(data)),
    };
  },
  created() {
    console.log('menu', this.pid);
  },
  methods: {
    selectNode(data) {
      this.$bus.emit('docChange', data.id);
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
.doc-menu .el-tree-node.is-current>.el-tree-node__content{
  background-color: #d5ebfc;
}
</style>
