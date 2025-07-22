<template>
    <button @click="showDeleteConfirmation" class="btn btn-icon btn-flex btn-active-light-danger w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.delete')">
        <KTIcon icon-name="trash" :icon-class="'text-danger ' + (iconClass ? iconClass : 'fs-3')"/>
    </button>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import Swal from 'sweetalert2';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import i18n from '@/Core/plugins/i18n';
import { router } from '@inertiajs/vue3';
import {getFullName} from "@/Core/helpers/Helper";

const { t } = i18n.global;

const props = defineProps({
    obj: Object,
    confirmRoute: String,
    roleId: Number,
    attendanceId: Number,
    employee: Object,
    iconClass: String,
});

const showDeleteConfirmation = async () => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    const result = await swalWithBootstrapButtons.fire({
        title: `${t('confirmation.remove.others')} ${props.obj?.name || getFullName(props?.employee)}?`,
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

        if(props?.roleId){
            router.visit(route(props.confirmRoute as string, {role: props?.roleId, user: props.obj?.id}), {
                method: 'delete',
                data: {},
                replace: true,
                preserveScroll: true,
            });
        }
        else if(props?.attendanceId){
            router.visit(route(props.confirmRoute as string, [props.employee?.id, props?.attendanceId]), {
                method: 'delete',
                data: {},
                replace: true,
                preserveScroll: true,
            });
        }
        else{
            router.visit(route(props.confirmRoute as string, props.obj?.id), {
                method: 'delete',
                data: {},
                replace: true,
                preserveScroll: true,
            });
        }
    }
};
</script>
