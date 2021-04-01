<template>
  <div v-show="code > 0 " class="http-status">
    <el-row>
      <el-alert
        :title="title"
        :type="theme"
        :closable="false"
        effect="dark"
      />
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'HttpStatus',
  props: {
    code: {
      type: Number,
      default: 0,
    },
    text: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
    };
  },
  computed: {
    title() {
      return this.code + ' ' + this.text;
    },
    theme(){
      return this.code === 200 ? 'success' : 'error';
    },
  },
};
</script>
