<template>
  <!--begin::Footer-->
  <div
    class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6"
    id="kt_app_sidebar_footer"
  >
    <a
      href="https://rosterbee.com"
      class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
      data-bs-toggle="tooltip"
      data-bs-trigger="hover"
      data-bs-dismiss-="click"
      title="Rostering made easy"
    >
      <span class="btn-label">RosterBee</span>
      <KTIcon icon-name="document" icon-class="btn-icon fs-2 m-0" />
    </a>
  </div>
  <!--end::Footer-->
</template>

<script setup lang="ts">
// import { KTIcon } from "@/core/helpers/kt-icon/KTIcon";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
</script>
