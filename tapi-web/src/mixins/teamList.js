export default {
  data() {
    return {
      page: 1,
      limit: 10,
      total: 0,
      tableData: [],
      searchInfo: {},
    };
  },
  methods: {
    handleSizeChange(val) {
      this.limit = val;
      this.getTableData();
    },
    handleCurrentChange(val) {
      this.page = val;
      this.getTableData();
    },
    async getTableData(tid = this.tid, page = this.page, limit = this.limit) {
      const res = await this.listApi({ tid, page, limit, ...this.searchInfo });

      this.tableData = res.data;
      this.total = parseInt(res.meta.total);
      this.page = parseInt(res.meta.current_page);
      this.limit = parseInt(res.meta.per_page);
    },
  },
};
