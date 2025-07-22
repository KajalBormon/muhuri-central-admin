<template>
    <button @click="showConfirmation" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="props?.title">
        <KTIcon :icon-name="props?.iconName" icon-class="fs-3 text-primary"/>
    </button>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import Swal from 'sweetalert2';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { router } from '@inertiajs/vue3';
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const props = defineProps({
    iconName: String,
    obj: Object,
    confirmRoute: String,
    title: String,
    messageTitle: String,
});

const showConfirmation = async () => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    const result = await swalWithBootstrapButtons.fire({
        title: props?.messageTitle,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `${t('buttonValue.confirm')}!`,
        cancelButtonText: `${t('buttonValue.cancel')}`,
        reverseButtons: true
    });

    if (result.isConfirmed) {
        Swal.fire({
            title: `${t('confirmation.wait')}`,
            timer: 1000,
                didOpen: () => {
                Swal.showLoading();
            }
        });

        router.visit(route(props.confirmRoute as string, props.obj?.id), {
            method: 'patch',
            preserveScroll: true
        });
    }
};
</script>
