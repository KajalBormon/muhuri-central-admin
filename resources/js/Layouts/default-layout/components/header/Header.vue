<template>
    <!--begin::Header-->
    <div v-if="headerDisplay" id="kt_app_header" class="app-header">
      <!--begin::Header container-->
      <div
        class="app-container d-flex align-items-stretch justify-content-between"
        :class="{
          'container-fluid': headerWidthFluid,
          'container-xxl': !headerWidthFluid,
        }"
      >
        <div
          v-if="layout === 'light-header' || layout === 'dark-header'"
          class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15"
        >
          <a href="/">
            <img
              v-if="themeMode === 'light' && layout === 'light-header'"
              alt="Logo"
              :src="getAssetPath('/media/logos/default.svg')"
              class="h-20px h-lg-30px app-sidebar-logo-default theme-light-show"
            />
            <img
              v-if="
                layout === 'dark-header' ||
                (themeMode === 'dark' && layout === 'light-header')
              "
              alt="Logo"
              :src="getAssetPath('/media/logos/default-dark.svg')"
              class="h-20px h-lg-30px app-sidebar-logo-default"
            />
          </a>
        </div>
        <template v-else>
          <!--begin::sidebar mobile toggle-->
          <div
            class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2"
            v-tooltip
            title="Show sidebar menu"
          >
            <div
              class="btn btn-icon btn-active-color-primary w-35px h-35px"
              id="kt_app_sidebar_mobile_toggle"
            >
              <KTIcon icon-name="abstract-14" icon-class="fs-2 fs-md-1" />
            </div>
          </div>
          <!--end::sidebar mobile toggle-->
          <!--begin::Mobile logo-->
          <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="/" class="d-lg-none">
              <img
                alt="Logo"
                :src="getAssetPath('/media/logos/nonditosoft-logo.png')"
                class="h-25px"
              />
            </a>
          </div>
          <!--end::Mobile logo-->
        </template>
        <!--begin::Header wrapper-->
        <div
          class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
          id="kt_app_header_wrapper"
        >
          <KTHeaderMenu />
          <KTHeaderNavbar />
        </div>
        <!--end::Header wrapper-->
      </div>
      <!--end::Header container-->
    </div>
    <!--end::Header-->
  </template>

  <script lang="ts">
  import { getAssetPath } from "@/Core/helpers/Assets";
  import { defineComponent } from "vue";
  import KTHeaderMenu from "@/Layouts/default-layout/components/header/menu/Menu.vue";
  import KTHeaderNavbar from "@/Layouts/default-layout/components/header/Navbar.vue";
  import {
    headerDisplay,
    headerWidthFluid,
    layout,
    themeMode,
    headerDesktopFixed,
    headerMobileFixed,
  } from "@/Layouts/default-layout/config/helper";
  import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";

  export default defineComponent({
    name: "layout-header",
    components: {
        KTIcon,
      KTHeaderMenu,
      KTHeaderNavbar,
    },
    setup() {
      return {
        layout,
        headerWidthFluid,
        headerDisplay,
        themeMode,
        getAssetPath,
        headerDesktopFixed,
        headerMobileFixed,
      };
    },
  });
  </script>
