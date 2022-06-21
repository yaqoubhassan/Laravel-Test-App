<template>
  <div class="tabs">
    <div
      v-for="tab in tabs"
      :key="tab.id"
      class="tab"
      :class="{
        active: activeTab.id === tab.id,
      }"
      @click="onChangeTab(tab)"
    >
      {{ tab.name }}
    </div>
  </div>
</template>

<script>
export default {
  name: "Tabs",
  props: {
    tabs: {
      type: Array,
      required: true,
    },
    activeTab: {
      type: Object,
      required: true,
    },
  },
  methods: {
    onChangeTab(tab) {
      this.$emit("update:activeTab", tab);
    },
  },
};
</script>

<style scoped>
.tabs {
  font-weight: 500;
  display: flex;
  align-items: center;
  background: #dbffeb;
  padding: 4px 4px;
  border-radius: 12px;
  width: max-content;
  height: max-content;
}
.tabs .tab {
  flex-grow: 1;
  cursor: pointer;
  text-align: center;
  border-radius: 12px;
  padding: 0.5rem 1.5rem;
}

.tabs .tab.active {
  background-color: #fff;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 0 #0000, 0 4px 6px -1px #dbffeb,
    0 2px 4px -2px #eaebff;
  color: var(--main-color);
}
</style>
