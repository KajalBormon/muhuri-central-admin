<template>
    <Head :title="`${props?.pageTitle}`" />
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <KTHeader/>
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <KTSidebar/>
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <FlashMessage v-if="$page.props.flash" :flash="$page.props.flash"/>
                        <KTToolbar :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle"/>
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <slot/>
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <KTFooter/>
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <KTScrollTop />
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {nextTick, onBeforeMount, onMounted, ref} from 'vue';
import KTSidebar from '@/Layouts/default-layout/components/sidebar/Sidebar.vue';
import KTHeader from '@/Layouts/default-layout/components/header/Header.vue';
import KTToolbar from '@/Layouts/default-layout/components/toolbar/Toolbar.vue';
import KTFooter from '@/Layouts/default-layout/components/footer/Footer.vue';
import LayoutService from "@/Core/services/LayoutService";
import {initializeComponents, reinitializeComponents} from "@/Core/plugins/keenthemes";
import KTScrollTop from "@/Layouts/default-layout/components/extras/ScrollTop.vue";
import FlashMessage from '@/Components/Message/FlashMessage.vue';

const showingNavigationDropdown = ref(false);
onBeforeMount(() => {
    LayoutService.init();
});

onMounted(() => {
    initializeComponents();
    nextTick(() => {
        reinitializeComponents();
    });
});

const props = defineProps({
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}
// watch(
//     () => route.path,
//     () => {
//         nextTick(() => {
//             reinitializeComponents();
//         });
//     }
// );
</script>

