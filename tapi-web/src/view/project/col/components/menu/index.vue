<template>
  <div class="main-left">
    <el-card class="project-category">
      <el-row :gutter="10">
        <el-col :span="16">
          <el-input
            v-model="filterText"
            placeholder="搜索接口"
            clearable
          />
        </el-col>
        <el-col :span="6" :offset="2">
          <el-button type="primary" style="float: right;" @click="addCat">添加集合</el-button>
        </el-col>
      </el-row>
      <div class="cont-menu" style="margin-top: 10px;">
        <el-tree
          ref="tree"
          :data="data"
          node-key="id"
          :filter-node-method="filterNode"
          style="height:300px;"
        >
          <span slot-scope="{ node, data }" class="custom-tree-node">
            <template v-if="data.type === 'cat'">
              <span @click="() => selectCat(data)"><i class="el-icon-folder-opened" />{{ node.label }}</span>
              <span>
                <el-tooltip content="克隆集合" placement="top">
                  <i class="el-icon-document-copy" @click="() => copyCat(data)" />
                </el-tooltip>
                <el-tooltip content="添加接口" placement="top">
                  <i class="el-icon-plus" @click="() => addCatApi(data)" />
                </el-tooltip>
                <el-tooltip content="修改集合" placement="top">
                  <i class="el-icon-edit" @click="() => editCat(data)" />
                </el-tooltip>
                <el-tooltip content="删除集合" placement="top">
                  <i class="el-icon-delete" @click="() => delCat(data)" />
                </el-tooltip>
              </span>
            </template>
            <template v-else>
              <span @click="() => selectApi(data)">{{ node.label }}</span>
              <span>
                <el-tooltip content="删除用例" placement="top">
                  <i class="el-icon-delete" @click="() => delApi(data)" />
                </el-tooltip>
              </span>
            </template>
          </span>
        </el-tree>
      </div>
    </el-card>
  </div>
</template>

<script>
export default {
  name: 'ColMenu',
  data() {
    const data = [{
      id: 2,
      label: '公共测试集',
      type: 'cat',
      children: [{
        id: 5,
        label: '二级 2-1',
        type: 'api',
      }, {
        id: 6,
        label: '二级 2-2',
        type: 'api',
      }],
    }, {
      id: 3,
      label: '小程序',
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
    }];
    return {
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
    selectCat(data) {
      console.log('selectCat');
    },
    selectApi(data) {
      console.log('selectApi');
    },
    addCat() {
      console.log('addCat');
    },
    copyCat(data) {
      console.log('copyCat');
    },
    addCatApi(data) {
      console.log('add');
    },
    editCat(data) {
      console.log('edit');
    },
    delCat(data) {
      console.log('del');
    },
    delApi(data) {
      console.log('del');
    },
  },
};
</script>
<style lang="scss">
.project-category .el-card__body{
  padding: 10px;
}
.custom-tree-node {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
}
.custom-tree-node .el-tooltip{
  padding-left: 8px;
}
</style>
