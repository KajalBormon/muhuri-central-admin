<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});
interface Breadcrumb {
    url: string;
    title: string;
}

const permissions = usePage().props.permissions;
if (permissions) {
    localStorage.setItem('permissions', JSON.stringify(permissions));
}
</script>

<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">{{ $t('confirmation.successfulLogin') }}!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
