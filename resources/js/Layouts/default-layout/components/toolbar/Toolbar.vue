<template>
  <!--begin::Toolbar-->
  <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <!--begin::Toolbar container-->
    <div
      id="kt_app_toolbar_container"
      class="app-container d-flex flex-stack"
      :class="{
        'container-fluid': toolbarWidthFluid,
        'container-xxl': !toolbarWidthFluid,
      }"
    >
      <PageTitle :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle"/>

    </div>
    <!--end::Toolbar container-->
  </div>
  <!--end::Toolbar-->
</template>

<script setup lang="ts">
import { ref } from "vue";
import PageTitle from "@/Layouts/default-layout/components/toolbar/PageTitle.vue";

const toolbarWidthFluid = ref(true);
const props = defineProps({
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}
</script>
