<template>
  <form @submit.prevent="onSubmit" autocomplete="off">
    <div class="form-field">
      <label for="link-title">Title</label>
      <input id="link-title" type="text" v-model="title" required placeholder="Enter the link title" />
    </div>
    <div class="form-field">
      <label for="link-url">URL</label>
      <input id="link-url" type="text" v-model="url" required placeholder="Enter URL" />
    </div>
    <div class="form-field">
      <input type="checkbox" id="open-new-tab" v-model="openInNewTab" />
      <label for="open-new-tab"> Open in new tab </label>
    </div>

    <div class="btn-wrapper">
      <button type="submit" class="semibold">{{ buttonName }}</button>
    </div>
  </form>
</template>

<script>
export default {
  name: "AddLinkForm",
  data() {
    return {
      title: "",
      url: "",
      openInNewTab: false,
    };
  },
  computed: {
    buttonName() {
      return this.$route.query.edit ? "Update Link" : "Add Link";
    },
  },
  created() {

    if (this.$route.query.edit) {
      const linkId = this.$route.query.edit;
      axios
        .get(`links/${linkId}`)
        .then(({ data: response }) => {
          const link = response.data;
          this.title = link.title;
          this.url = link.link;
          this.openInNewTab = link.open_in_new_tab;
        })
        .catch((error) => {
          alert(error.message)
        });
    }
  },
  methods: {
    async onSubmit() {
      if (this.url && this.title) {
        const { title, url, openInNewTab } = this;
        const formData = {
          title,
          link: url,
          open_in_new_tab: openInNewTab,
        };

        if (this.$route.query.edit) {
          try {
            await axios.patch(
              `links/${this.$route.query.edit}`,
              formData
            )
            this.$router.push({
              query: {}
            });
          } catch (error) {
            alert(error.message);
          }
          return;
        }

        try {
          await axios.post(`links`, formData);
          this.$router.push({
            query: {}
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
</style>
