<template>
  <div class="right_container">
    <div class="search-term">
      <el-form :inline="true" :model="searchInfo" class="demo-form-inline">
        <el-form-item label="时间">
          <el-date-picker
            v-model="searchInfo.date"
            type="daterange"
            unlink-panels
            range-separator="至"
            start-placeholder="开始日期"
            end-placeholder="结束日期"
            :picker-options="pickerOptions"
            value-format="yyyy-MM-dd"
          />
        </el-form-item>
        <el-form-item label="操作对象">
          <el-select v-model="searchInfo.tag" clearable placeholder="请选择">
            <el-option
              v-for="item in searchOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchData">查询</el-button>
        </el-form-item>
      </el-form>
    </div>

    <el-table :data="tableData" border stripe>
      <el-table-column label="管理员" min-width="100" prop="userName" />
      <el-table-column label="时间" min-width="150" prop="created" />
      <el-table-column label="操作对象" min-width="150" prop="tagName" />
      <el-table-column label="操作内容" min-width="300" prop="content" />
    </el-table>
    <el-pagination
      :current-page="page"
      :page-size="limit"
      :page-sizes="[10, 30, 50, 100]"
      :style="{float:'right',padding:'20px'}"
      :total="total"
      layout="total, sizes, prev, pager, next, jumper"
      @current-change="handleCurrentChange"
      @size-change="handleSizeChange"
    />
  </div>
</template>

<script>
// 获取列表内容封装在mixins内部  getTableData方法 初始化已封装完成
import dayjs from 'dayjs';
import { getLogList } from '@/api/operation';
import infoList from '@/mixins/infoList';
export default {
  name: 'Operation',
  mixins: [infoList],
  data() {
    return {
      listApi: getLogList,
      pickerOptions: {
        shortcuts: [{
          text: '本周',
          onClick(picker) {
            const end = dayjs().endOf('week').format('YYYY-MM-DD').toString();
            const start = dayjs().startOf('week').format('YYYY-MM-DD').toString();
            picker.$emit('pick', [start, end]);
          },
        }, {
          text: '上周',
          onClick(picker) {
            const end = dayjs().endOf('week').subtract(1, 'week').format('YYYY-MM-DD').toString();
            const start = dayjs().startOf('week').subtract(1, 'week').format('YYYY-MM-DD').toString();
            picker.$emit('pick', [start, end]);
          },
        }, {
          text: '本月',
          onClick(picker) {
            const end = dayjs().endOf('month').format('YYYY-MM-DD').toString();
            const start = dayjs().startOf('month').format('YYYY-MM-DD').toString();
            picker.$emit('pick', [start, end]);
          },
        }, {
          text: '上月',
          onClick(picker) {
            const end = dayjs().endOf('month').subtract(1, 'month').endOf('month').format('YYYY-MM-DD').toString();
            const start = dayjs().startOf('month').subtract(1, 'month').format('YYYY-MM-DD').toString();
            picker.$emit('pick', [start, end]);
          },
        }],
      },
      searchOptions: [
        { label: '用户', value: 'user' },
        { label: '业务', value: 'cate' },
      ],
    };
  },
  async created() {
    this.getTableData();
  },
  methods: {
    // 搜索
    searchData() {
      this.page = 1;
      this.limit = 10;
      this.getTableData();
    },
  },
};
</script>
<style lang="scss">

.button-box {
  padding: 10px 20px;
  .el-button {
    float: right;
  }
}

.user-dialog {
  .header-img-box {
    width: 200px;
    height: 200px;
    border: 1px dashed #ccc;
    border-radius: 20px;
    text-align: center;
    line-height: 200px;
    cursor: pointer;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409eff;
  }
  .avatar-uploader-icon {
    border: 1px dashed #d9d9d9 !important;
    border-radius: 6px;
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
}
</style>
