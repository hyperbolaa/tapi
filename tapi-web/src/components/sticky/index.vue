<template>
  <div :style="{height:'50px',zIndex:zIndex}">
    <div
      class="sub-navbar"
      :style="{bottom:(isSticky ? stickyBottom +'px' : ''),zIndex:zIndex,position:position,width:width}"
    >
      <slot>
        <div>sticky</div>
      </slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Sticky',
  props: {
    stickyBottom: {
      type: Number,
      default: 0,
    },
    zIndex: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      active: false,
      position: '',
      width: undefined,
      isSticky: false,
    };
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll, true);
    window.addEventListener('resize', this.handleResize, true);
  },
  activated() {
    this.handleScroll();
  },
  destroyed() {
    window.removeEventListener('scroll', this.handleScroll, true);
    window.removeEventListener('resize', this.handleResize, true);
  },
  methods: {
    sticky() {
      if (this.active) {
        return;
      }
      this.position = 'fixed';
      this.active = true;
      this.width = this.width + 'px';
      this.isSticky = true;
    },
    handleReset() {
      if (!this.active) {
        return;
      }
      this.reset();
    },
    reset() {
      this.position = '';
      this.width = 'auto';
      this.active = false;
      this.isSticky = false;
    },
    handleScroll() {
      const width = this.$el.getBoundingClientRect().width;
      this.width = width || 'auto';
      const offsetBottom = this.$el.getBoundingClientRect().bottom;
      if (offsetBottom > window.innerHeight) {
        this.sticky();
        return;
      }
      this.handleReset();
    },
    handleResize() {
      if (this.isSticky) {
        this.width = this.$el.getBoundingClientRect().width + 'px';
      }
    },
  },
};
</script>
