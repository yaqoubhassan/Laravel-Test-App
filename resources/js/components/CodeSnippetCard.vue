<template>
  <div class="link-card card">
    <h3 class="card-title">
      {{ snippet.title }}
    </h3>

    <span class="description">
      {{ snippet.description }}
    </span>

    <pre>
      <code ref="code_span" v-text="snippet.snippet"></code>
    </pre>

    <div class="card-footer">
      <button @click="copyAccessCode">Copy Snippet</button>
      <button v-if="onAdminRoute" @click="onEdit">Edit</button>
      <button v-if="onAdminRoute" @click="onDelete">Delete</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "CodeSnippetCard",
  props: {
    snippet: {
      type: Object,
      required: true,
    },
    onAdminRoute: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    onEdit() {
      this.$router.push({
        query: {
          newResource: "html-snippet",
          edit: this.snippet.id,
        },
      });
    },
    onDelete() {
      const confirmed = confirm(
        "Are you sure you want to delete this snippet?"
      );
      if (confirmed) {
        axios.delete(`html-snippets/${this.snippet.id}`).then(() => {
          this.$emit("deleted", this.snippet.id);
        });
      }
    },
    copyAccessCode() {
      const codeSpan = this.$refs.code_span;
      navigator.clipboard.writeText(codeSpan.innerText);
    },
  },
};
</script>

<style scoped>
.card-footer button:first-child {
  margin-right: 10px;
}

span {
  display: block;
  margin: 5px;
  color: gray;
}

pre {
  margin: 0;
}

code {
  font-family: "Fira Code", monospace;
  font-size: 0.9em;
  background: #2d2d2d;
  padding: 10px 15px;
  color: white;
  width: 100%;
  display: block;
  border-radius: 10px;
}
</style>
