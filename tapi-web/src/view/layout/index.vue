<template>
  <el-container class="layout-cont">
    <el-container>
      <el-main class="main-cont">
        <transition :duration="{ enter: 800, leave: 100 }" mode="out-in" name="el-fade-in-linear">
          <div class="topfix" style="width: 100%;">
            <el-header class="header-cont">
              <div class="logo-cont">
                <router-link to="/console/dashboard"><img alt class="logoimg" src="~@/assets/logo.png"></router-link>
              </div>
              <el-breadcrumb class="breadcrumb" separator-class="el-icon-arrow-right">
                <el-breadcrumb-item
                  v-for="item in matched.slice(1,matched.length)"
                  :key="item.path"
                >{{ item.meta.title }}</el-breadcrumb-item>
              </el-breadcrumb>

              <div class="fl-right right-box">
                <div class="fuc-btn">
                  <router-link :to="{ name: 'document'}"><el-link icon="el-icon-document" target="_blank">使用文档</el-link></router-link>
                </div>
                <el-dropdown>
                  <span class="header-avatar">
                    <span style="margin-left: 5px">{{ userInfo.name }}</span>
                    <i class="el-icon-arrow-down" />
                  </span>
                  <el-dropdown-menu slot="dropdown" class="dropdown-group">
                    <el-dropdown-item icon="el-icon-crop" @click.native="toSystem">系统信息</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-user" @click.native="toPerson">个人中心</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-table-lamp" @click.native="LoginOut">退出登录</el-dropdown-item>
                  </el-dropdown-menu>
                </el-dropdown>
              </div>
            </el-header>
          </div>
        </transition>

        <transition mode="out-in" name="el-fade-in-linear">
          <router-view v-loading="loadingFlag" element-loading-text="正在加载中" class="admin-box" />
        </transition>

        <BottomInfo />
      </el-main>
    </el-container>

  </el-container>
</template>

<script>
import BottomInfo from '@/view/layout/bottomInfo/bottomInfo';
import { mapGetters, mapActions } from 'vuex';
export default {
  name: 'Layout',
  data() {
    return {
      loadingFlag: false,
    };
  },
  computed: {
    ...mapGetters('user', ['userInfo']),
    title() {
      return this.$route.meta.title || '当前页面';
    },
    matched() {
      return this.$route.matched;
    },
  },
  components: {
    BottomInfo,
  },
  mounted() {
    this.$bus.on('showLoading', () => {
      this.loadingFlag = true;
    });
    this.$bus.on('closeLoading', () => {
      this.loadingFlag = false;
    });
  },
  methods: {
    ...mapActions('user', ['LoginOut']),
    toSystem() {
      this.$router.push({ name: 'system-static' });
    },
    toPerson() {
      this.$router.push({ name: 'user-profile' });
    },
    toDoc() {
      this.$router.push({ name: 'doc' });
    },
  },
};
</script>

<style lang="scss">
$headerHigh: 60px;
$mainHight: 100vh;
.dropdown-group {
  min-width: 100px;
}
.topfix {
  position: fixed;
  top: 0;
  box-sizing: border-box;
  z-index: 999;
}
.admin-box {
  min-height: calc(100vh - 240px);
}
.el-scrollbar__wrap {
  padding-bottom: 17px;
}
.layout-cont {
  .right-box {
    text-align: center;
    vertical-align: middle;
    img {
      vertical-align: middle;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
  }

  .header-cont {
    height: $headerHigh !important;
    background: #fff;
    box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
    line-height: $headerHigh;
  }
  .main-cont {
    .breadcrumb {
      line-height: 60px;
      display: inline-block;
      padding: 0 24px;
      // padding: 6px;
      // border-bottom: 1px solid #eee;
    }

    &.el-main {
      overflow: auto;
      background: #fff;
      // padding: 0px 10px;
      // background: #fff;
    }
    height: $mainHight !important;
    overflow: visible;
    position: relative;
    .menu-total {
      // z-index: 5;
      // position: absolute;
      // top: 10px;
      // right: -35px;
      margin-left: -10px;
      float: left;
      margin-top: 15px;
      width: 30px;
      height: 30px;
      line-height: 30px;
      font-size: 30px;
      // border: 0 solid #ffffff;
      // border-radius: 50%;
      // background: #fff;
    }
    .el-menu-vertical {
      height: calc(100vh - 64px) !important;
      visibility: auto;
    }
    .el-menu--collapse {
      width: 54px;
      li {
        .el-tooltip,
        .el-submenu__title {
          padding: 0px 15px !important;
        }
      }
    }
    &::-webkit-scrollbar {
      display: none;
    }
  }
}
.logo-cont {
  height: 60px;
  line-height: 60px;
  display: inline-block;
  float: left;
  .logoimg {
    width: 40px;
    height: 40px;
    background: yellow;
    border-radius: 50%;
    margin: 10px;
  }
}
.fuc-btn{
  display: inline-block;
  .el-link--inner {
    margin-right: 15px;
  }
}
.header-avatar{
	display: flex;
	justify-content: center;
	align-items: center;
}
</style>
