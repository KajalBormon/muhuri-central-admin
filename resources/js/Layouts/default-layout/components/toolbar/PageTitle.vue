<template>
    <!--begin::Page title-->
    <div v-if="pageTitleDisplay"
         :class="`page-title d-flex flex-${pageTitleDirection} justify-content-center flex-wrap me-3`">
        <template v-if="props.pageTitle">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                <!-- {{ pageTitle }} -->
                {{ props.pageTitle }}
            </h1>
            <!--end::Title-->

            <span v-if="pageTitleDirection === 'row' && pageTitleBreadcrumbDisplay"
                  class="h-20px border-gray-200 border-start mx-3"></span>

            <!--begin::Breadcrumb-->
            <ul v-if="props.breadcrumbs && pageTitleBreadcrumbDisplay"
                class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <template v-for="(item, i) in props.breadcrumbs" :key="i">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted" v-if="i !== (props.breadcrumbs!.length) - 1">
                        <Link :href="item.url" class="text-muted text-hover-primary"> {{ item.title }}</Link>
                    </li>
                    <li v-else class="breadcrumb-item text-muted">{{ item.title }}</li>
                    <!--end::Item-->

                    <li v-if="i !== props.breadcrumbs.length - 1" class="breadcrumb-item text-muted">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                </template>
            </ul>
            <!--end::Breadcrumb-->
        </template>
    </div>
    <div v-else class="align-items-stretch"></div>
    <!--end::Page title-->
</template>

<script lang="ts" setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/vue3'

const pageTitleDisplay = true;
const pageTitleBreadcrumbDisplay = true;
const pageTitleDirection = ref('column');
const props = defineProps({
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}
</script>
