<template>
  <form @submit.prevent="onSubmit" autocomplete="off">
    <div class="form-field">
      <label for="pdf-title">Title</label>
      <input id="pdf-title" type="text" v-model="title" required placeholder="Enter a title for your PDF" />
    </div>
    <div class="form-field file">
      <div>
        <label for="pdf-file">Choose PDF document</label>
        <button v-if="file || existingPdfUrl" class="semibold" @click="onRemoveFile">
          Remove
        </button>
      </div>
      <input ref="fileInput" id="pdf-file" type="file" accept=".pdf" :required="!file && !existingPdfUrl"
        placeholder="Choose a file" @change="onFileChange" />
    </div>

    <div class="btn-wrapper">
      <button type="submit" class="semibold" :disabled="loading">
        <Loader v-if="loading" />
        <span>Upload Document</span>
      </button>
    </div>
  </form>
</template>

<script>
import Loader from "./Loader.vue";
export default {
  name: "UploadDocForm",
  components: {
    Loader,
  },
  data() {
    return {
      title: "",
      file: null,
      existingPdfUrl: null,
      loading: false,
    };
  },
  created() {
    if (this.$route.query.edit) {
      const pdfId = this.$route.query.edit;
      axios
        .get(`pdf-files/${pdfId}`)
        .then(({ data }) => {
          const pdf = data.data;
          this.title = pdf.title;
          this.existingPdfUrl = pdf.file;
        })
        .catch((error) => {
          alert(error.message);
        });
    }
  },
  methods: {
    onRemoveFile() {
      this.file = null;
      this.$refs.fileInput.value = "";
      this.existingPdfUrl = null;
    },
    onFileChange(e) {
      this.file = e.target.files[0];
    },
    async onSubmit() {
      this.loading = true;
      if ((this.file || this.existingPdfUrl) && this.title) {
        const { title, file } = this;
        const formData = new FormData();
        formData.append("title", title);
        if (this.file) {
          formData.append("file", file);
        }
        if (this.$route.query.edit) {
          try {
            await axios.post(
              `pdf-files/${this.$route.query.edit}?_method=PATCH`,
              formData,
              {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              }
            );

            this.$router.push({
              query: {},
            });
          } catch (error) {
            alert(error.message);
          } finally {
            this.loading = false;
          }
          return;
        }

        try {
          await axios.post(
            `pdf-files`, formData
          );
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

.form-field.file>div {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.form-field.file>div>button {
  color: var(--main-color);
  background: transparent;
  border: 0;
  outline: 0;
}

.form-field.file>div>button:hover {
  color: var(--main-color-dark);
}

.btn-wrapper {
  margin-top: 50px;
  text-align: center;
}

.btn-wrapper button {
  border: 0;
  outline: 0;
  padding: 10px 35px;
  border-radius: 25px;
  background: var(--main-color);
  color: white;
  cursor: pointer;
}

.btn-wrapper button:hover {
  background: var(--main-color-dark);
}
</style>
