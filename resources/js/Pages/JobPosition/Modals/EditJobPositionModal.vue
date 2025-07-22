<template>
    <div class="modal fade" id="kt_modal_edit_job_position" ref="editJobPositionModalRef" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_job_position_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Edit Job Position</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div id="kt_modal_edit_job_position_close" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <KTIcon icon-name="cross" icon-class="fs-1" />
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Form-->
                <VForm @submit="submit()" :model="formData" ref="formRef">
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_edit_job_position_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_job_position_header" data-kt-scroll-wrappers="#kt_modal_edit_job_position_scroll" data-kt-scroll-offset="300px">
                            <!--Name-->
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">{{ $t('label.name') }}</label>
                                <Field type="text" :placeholder="$t('placeholder.name')"  class="form-control form-control-lg form-control-solid" name="name" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name" />
                            </div>
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--Discard Button-->
                        <button type="reset" id="kt_modal_edit_job_position_cancel" class="btn btn-light me-3">
                            {{ $t('buttonValue.discard') }}
                        </button>

                        <!-- Submit Button -->
                        <SubmitButton :id="props.jobPosition?.id" />
                    </div>
                    <!--end::Modal footer-->
                </VForm>
                <!--end::Form-->
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { ref, watch } from "vue";
import { hideModal } from "@/Core/helpers/Modal";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { Field, Form as VForm } from "vee-validate";
import { useForm, router, usePage } from '@inertiajs/vue3';
import toastr from 'toastr';
import 'toastr/toastr.scss';

const formRef = ref < null | HTMLFormElement > (null);
const editJobPositionModalRef = ref < null | HTMLElement > (null);

const props = defineProps({
    jobPosition: Object
})

const formData = useForm({
    name: props.jobPosition?.name || ''
});

watch([() => props.jobPosition?.name], ([name]) => {
    formData.name = name || '';
});

const submit = () => {
    const url = route('job-positions.update', props.jobPosition?.id);
    formData.put(url, {
        preserveScroll: true,
        onSuccess: () => {
            hideModal(editJobPositionModalRef.value);
            router.visit(route('job-positions.index'), { replace: true, preserveScroll: true,});
            const flash = usePage().props.flash;
            let {success} = flash as any;

            if (flash && success) {
                toastr.success(success);
            }
        }
    })
};
</script>
