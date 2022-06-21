<template>
  <div class="link-card card">
    <h3 class="card-title">
      {{ link.title }}
    </h3>

    <div class="center">
      <button @click="onLinkClicked">Open URL</button>
    </div>

    <div v-if="onAdminRoute" class="card-footer">
      <button @click="onEdit">Edit</button>
      <button @click="onDelete">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "LinkCard",
  props: {
    link: {
      type: Object,
      required: true,
    },
    onAdminRoute: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    onLinkClicked() {
      const { link } = this;
      if (link.shouldOpenInNewTab) {
        window.open(link.url, "_blank");
      } else {
        window.location.href = link.url;
      }
    },
    onEdit() {
      this.$router.push({
        query: {
          newResource: "link",
          edit: this.link.id,
        },
      });
    },
    onDelete() {
      const confirmed = confirm("Are you sure you want to delete this link?");
      if (confirmed) {
        axios.delete(`links/${this.link.id}`).then(() => {
          this.$emit("deleted", this.link.id);
        }); 
      }
    },
  },
};
</script>

<style scoped>
.card-footer button:first-child {
  margin-right: 10px;
}
.center {
  text-align: center;
  margin: 20px 0 10px;
}

.center button {
  background: transparent;
  border: none;
  color: var(--main-color);
  border: 1px solid var(--main-color);
  padding: 5px 10px;
  border-radius: 10px;
  font-weight: 600;
}
</style>
