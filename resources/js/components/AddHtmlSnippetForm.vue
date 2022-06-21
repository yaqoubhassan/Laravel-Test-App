<template>
  <form @submit.prevent="onSubmit" autocomplete="off">
    <div class="form-field">
      <label for="link-title">Title</label>
      <input id="link-title" type="text" v-model="title" required placeholder="Enter the snippet title" />
    </div>
    <div class="form-field">
      <label for="snippet-description">Description</label>
      <textarea id="snippet-description" type="text" v-model="description" required
        placeholder="Enter snippet description"></textarea>
    </div>
    <div class="form-field">
      <label for="html-code">HTML Snippet</label>
      <textarea id="html-code" type="text" v-model="code" required placeholder="Enter the HTML code"></textarea>
    </div>

    <div class="btn-wrapper">
      <button type="submit" class="semibold">{{ buttonName }}</button>
    </div>
  </form>
</template>

<script>
export default {
  name: "AddHtmlSnippet",
  data() {
    return {
      title: "",
      description: "",
      code: "",
    };
  },
  created() {
    /* Check if there's a query param called `edit` whose value is a snippet ID.
     * If it exists, then we're editing an existing snippet, so fetch it's data and populate the form.
     */
    if (this.$route.query.edit) {
      const snippetId = this.$route.query.edit;
      axios
        .get(`html-snippets/${snippetId}`)
        .then(({ data: response }) => {
          const snippet = response.data;
          this.title = snippet.title;
          this.description = snippet.description;
          this.code = snippet.snippet;
        })
        .catch((error) => {
          alert(error.message);
        });
    }
  },
  computed: {
    buttonName() {
      return this.$route.query.edit ? "Update Snippet" : "Add Snippet";
    },
  },
  methods: {
    async onSubmit() {
      const { title, description, code } = this;
      const formData = {
        title,
        description,
        snippet: code,
      };

      if (title && description && code) {
        if (this.$route.query.edit) {
          try {
            await axios.patch(
              `html-snippets/${this.$route.query.edit}`,
              formData
            );

            this.$router.push({
              query: {},
            });
          } catch (error) {
            alert(error.message);
          }
          return;
        }

        try {
          await axios.post(`/api/snippets`, formData);
          this.$router.push({
            query: {},
          });
        } catch (error) {
          alert(error.message);
        }
      }
    },
  },
};
</script>

<style scoped>
form {
  width: 500px;
  margin: 0 auto;
}

.form-field {
  margin-bottom: 1.3rem;
}

.form-field label {
  font-weight: 500;
}

.btn-wrapper {
  margin-top: 50px;
  text-align: center;
}

textarea {
  width: 100%;
  resize: none;
}

textarea#html-code {
  resize: vertical;
  height: 200px;
}

textarea#snippet-description {
  height: 100px;
}
</style>
