<template>
  <div class="link-card card">
    <h3 class="card-title">
      {{ pdf.title }}
    </h3>

    <div class="center">
      <button @click="onViewDoc">Download File</button>
    </div>

    <div v-if="onAdminRoute" class="card-footer">
      <button @click="onEdit">Edit</button>
      <button @click="onDelete">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "PdfCard",
  props: {
    pdf: {
      type: Object,
      required: true,
    },
    onAdminRoute: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    onViewDoc() {
      window.open(this.pdf.file, "_blank");
    },
    onEdit() {
      this.$router.push({
        query: {
          newResource: "pdf",
          edit: this.pdf.id,
        },
      });
    },
    onDelete() {
      const confirmed = confirm("Are you sure you want to delete this PDF?");
      if (confirmed) {
        axios.delete(`pdf-files/${this.pdf.id}`).then(() => {
          this.$emit("deleted", this.pdf.id);
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
