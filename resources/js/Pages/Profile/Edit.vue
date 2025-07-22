<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProfileHeader from '@/Pages/Profile/ProfileHeader.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    user: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}
</script>

<template>

    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <ProfileHeader activeLink="myProfile" :user="props?.user"></ProfileHeader>

        <UpdateProfileInformationForm
            :must-verify-email="mustVerifyEmail"
            :status="status"
            class="max-w-xl"
        />

        <UpdatePasswordForm class="max-w-xl" />

    </AuthenticatedLayout>
</template>
