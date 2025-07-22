<template>
    <input @change="showStatusConfirmation" class="form-check-input w-45px h-30px cursor-pointer me-3" type="checkbox" data-bs-toggle="tooltip" :title="$t('tooltip.title.changeStatus')" id="googleswitch" :checked="props.obj?.is_active"/>
    <label class="form-check-label" for="googleswitch"></label>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import Swal from 'sweetalert2';
import i18n from '@/Core/plugins/i18n';
import { router } from '@inertiajs/vue3';
import {getFullName} from "@/Core/helpers/Helper";

const { t } = i18n.global;

const props = defineProps({
    obj: Object,
    confirmRoute: String,
    cancelRoute: String,
    iconClass: String
});

const showStatusConfirmation = async () => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    const result = await swalWithBootstrapButtons.fire({
        title: `${t('confirmation.changeStatus')} ${props.obj?.name || props.obj?.fiscal_year || props.obj?.parentName || getFullName(props?.obj)}?`,
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
            data: {
                'is_active': props.obj?.is_active?.toString()
            },
            preserveScroll: true,
            replace: true
        });
    }
    else {
        if(props.cancelRoute) {
            router.visit(route(props.cancelRoute as string), {
                replace: true,
                preserveScroll: true
            });
        } else {
            let toggler = document.getElementById('googleswitch') as HTMLInputElement;
            if(toggler) {
                toggler.checked = props.obj?.is_active;
            }
        }
    }
};
</script>
