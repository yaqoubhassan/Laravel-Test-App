<template>
  <div class="resources">
    <Tabs v-if="currentTab" :tabs="tabs" :active-tab.sync="currentTab" />

    <div
      class="resources-list grid"
      :class="{
        'grid-cols-2': currentTab === 'html-snippets',
        'grid-cols-3': ['pdfs', 'links'].includes(currentTab.id),
      }"
    >
      <template v-if="currentTab.id === 'links'">
        <LinkCard
          v-for="link in links"
          :key="link.id"
          :link="link"
          :on-admin-route="onAdminRoute"
          @deleted="onDeleteLink"
        />
      </template>
      <template v-else-if="currentTab.id === 'html-snippets'">
        <CodeSnippetCard
          v-for="snippet in htmlSnippets"
          :key="snippet.id"
          :snippet="snippet"
          :on-admin-route="onAdminRoute"
          @deleted="onDeleteSnippet"
        />
      </template>
      <template v-else>
        <PdfCard
          v-for="pdf in pdfs"
          :key="pdf.id"
          :pdf="pdf"
          :on-admin-route="onAdminRoute"
          @deleted="handleDeletePdf"
        />
      </template>
    </div>
  </div>
</template>

<script>
import Tabs from "./Tabs.vue";
import tabs from "./assets/tabs";
import LinkCard from "./LinkCard.vue";
import PdfCard from "./PdfCard.vue";
import CodeSnippetCard from "./CodeSnippetCard.vue";

export default {
  name: "Resources",
  components: {
    Tabs,
    LinkCard,
    PdfCard,
    CodeSnippetCard,
  },
  props: {
    activeTab: {
      type: Object,
      required: true,
    },
    onAdminRoute: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      tabs,
      currentTab: null,

      links: [],
      htmlSnippets: [],
      pdfs: [],

      fakeLinks: [
        {
          id: 1,
          title: "Some Link",
          url: "https://www.google.com",
          shouldOpenInNewTab: true,
        },
        {
          id: 2,
          title: "Another Link",
          url: "https://www.google.com",
          shouldOpenInNewTab: false,
        },
      ],
      fakeHtmlSnippets: [
        {
          id: 1,
          title: "Some HTML Snippet",
          description: "Some description",
          html: "<h1>Some HTML Snippet</h1>",
        },
        {
          id: 2,
          title: "Another HTML Snippet",
          description: "Some description",
          html: "<h1>Another HTML Snippet</h1>",
        },
      ],
      fakePdfs: [
        {
          id: 1,
          title: "Some PDF",
          pdf: "https://www.google.com",
        },
        {
          id: 2,
          title: "Another PDF",
          pdf: "https://www.google.com",
        },
      ],
    };
  },
  watch: {
    currentTab(tab) {
      this.$emit("update:activeTab", tab);
      this.fetchResources();
    },
  },
  created() {
    this.currentTab = this.activeTab;
    
  },
  methods: {
    handleDeletePdf(id) {
      this.pdfs = this.pdfs.filter(item=>item.id !== id)
    },
    onDeleteSnippet(id) {
      const snippetsCopy = [...this.htmlSnippets].filter(s => s.id !== id)
      this.htmlSnippets = snippetsCopy;
    },
    onDeleteLink(id) {
      const linksCopy = [...this.links].filter(l => l.id !== id)
      this.links = linksCopy;
    },
    fetchResources() {
       switch (this.currentTab.id) {
        case "links":
          axios.get("links").then(({ data }) => {
            this.links = data.data.map(link => ({
              id: link.id,
              title: link.title,
              shouldOpenInNewTab: link.open_in_new_tab,
              url: link.link
            }));
          });
          break;
        case "html-snippets":
          axios.get("html-snippets").then(({ data }) => {
            this.htmlSnippets = data.data;
          });
          break;
        default:
          axios.get("pdf-files").then(({ data }) => {
            this.pdfs = data.data;

          });
          break;
      }
    }
  }
};
</script>

<style scoped>
.resources-list {
  margin-top: 2rem;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  grid-gap: 2rem;
}
.grid-cols-2 {
  grid-template-columns: repeat(2, minmax(250px, 1fr));
}
.grid-cols-3 {
  grid-template-columns: repeat(3, minmax(250px, 1fr));
}
</style>
