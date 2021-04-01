<template>
  <div style="padding-top: 10px;">
    <div class="edit">
      <mavon-editor v-model="content" :ishljs="true" :default-open="'preview'" />
      <el-button type="primary" size="small" style="float: right;" @click="submit">更新</el-button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProjectWiki',
  data() {
    return {
      content: `<p>hello world</p>`,
    };
  },
  methods: {
    // onEditorReady(editor) { // 准备编辑器--https://github.com/hinesboy/mavonEditor

    // },
    onEditorBlur() {}, // 失去焦点事件
    onEditorFocus() {}, // 获得焦点事件
    onEditorChange() {}, // 内容改变事件
    saveHtml() {
      console.log(this.content);
    }, // 保存方法
    submit(){},
  },
};
</script>
