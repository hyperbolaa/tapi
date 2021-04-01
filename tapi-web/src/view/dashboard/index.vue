<template>
  <div class="dashboard">
    <el-row :gutter="10">
      <el-col :span="8">
        <div class="grid-content bg-purple">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>平台通知</span>
            </div>
            <div class="list-cont">
              <div v-for="item in noticeData" :key="item.id" class="list-item">
                <div @click="showNotice(item)"><el-link icon="el-icon-bell">{{ item.name }}</el-link><span style="float: right;">{{ item.created }}</span></div>
              </div>
            </div>
          </el-card>
        </div>
      </el-col>
      <el-col :span="8">
        <div class="grid-content bg-purple">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>我的关注</span>
              <el-button style="float: right; padding: 3px 0" type="text">更多</el-button>
            </div>
            <div class="list-cont">
              <div v-for="item in followData" :key="item.id" class="list-item">
                <router-link :to="{ name: 'project-api-all', params: { pid: item.id }}"><el-link icon="el-icon-star-on">{{ item.name }}</el-link></router-link>
              </div>
            </div>
          </el-card>
        </div>
      </el-col>
      <el-col :span="8">
        <div class="grid-content bg-purple">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>我的团队</span>
              <el-button style="float: right; padding: 3px 0" type="text">更多</el-button>
            </div>
            <div class="list-cont">
              <div v-for="item in teamData" :key="item.id" class="list-item">
                <router-link :to="{ name: 'team', params: { tid: item.id }}"><el-link icon="el-icon-school">{{ item.name }}</el-link></router-link>
              </div>
            </div>
          </el-card>
        </div>
      </el-col>
    </el-row>

    <el-dialog :visible.sync="dialogVisible" custom-class="user-dialog" :title="dialogTitle">
      <div class="notice-cont">
        <div style="color: rgb(144, 147, 153); display: flex; align-items: center;">
          <span style="margin-left: 10px;">发布时间：{{ dialogData.created }}</span>
        </div>
        <el-scrollbar class="default-scrollbar" wrap-class="default-scrollbar__wrap">
          {{ dialogData.content }}
        </el-scrollbar>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { getNotice, getFollow, getTeam } from '@/api/dashboard';
export default {
  name: 'Dashboard',
  data() {
    return {
      dialogVisible: false,
      dialogTitle: '',
      dialogData: {},
      noticeData: [],
      followData: [],
      teamData: [],
    };
  },
  created() {
    this.getNoticeData();
    this.getFollowData();
    this.getTeamData();
  },
  methods: {
    async getNoticeData() {
      const res = await getNotice();
      this.noticeData = res.data;
    },
    async getFollowData() {
      const res = await getFollow();
      this.followData = res.data;
    },
    async getTeamData() {
      const res = await getTeam();
      this.teamData = res.data;
    },
    showNotice(row){
      this.dialogData = row;
      this.dialogTitle = row.name;
      this.dialogVisible = true;
    },
  },
};
</script>

<style lang="scss" scoped>
.dashboard .list-item{
  padding: 10px;
  margin-bottom: 10px;
}
.dashboard .list-item:hover{
  background-color:silver;
}
.dashboard .list-cont{
  min-height: 400px;
}
.dashboard .default-scrollbar{
  margin: 20px 10px;
}
.dashboard .el-scrollbar__wrap.default-scrollbar__wrap {
  overflow-x: auto;
}
</style>
