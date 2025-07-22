<template>
    <!--begin::Sidebar-->
    <div
        ref="sidebarRef"
        id="kt_app_sidebar"
        class="app-sidebar flex-column"
        data-kt-drawer="true"
        data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}"
        data-kt-drawer-overlay="true"
        data-kt-drawer-width="225px"
        data-kt-drawer-direction="start"
        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
    >
        <SidebarLogo :sidebar-ref="sidebarRef"></SidebarLogo>
        <SidebarMenu></SidebarMenu>
        <SidebarFooter></SidebarFooter>

    </div>
    <!--end::Sidebar-->
</template>

<script setup lang="ts">

import SidebarFooter from "@/Layouts/default-layout/components/sidebar/SidebarFooter.vue";
import SidebarMenu from "@/Layouts/default-layout/components/sidebar/SidebarMenu.vue";
import SidebarLogo from "@/Layouts/default-layout/components/sidebar/SidebarLogo.vue";
import {ref} from "vue";
const sidebarRef = ref<HTMLFormElement | null>(null);

</script>
