<template>
    <div class="modal fade" id="kt_modal_update_email" ref="editUserModalRef" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_email_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ $t('user.header.title.updateEmailAddress') }}</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div id="kt_modal_update_email_close" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <KTIcon icon-name="cross" icon-class="fs-1" />
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Form-->
                <VForm @submit="submit()" :model="formData" ref="formRef">
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!-- Start: Notice -->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">{{ $t('user.header.info.email.validEmail') }}</div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!-- End: Notice -->

                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_update_email_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_email_header" data-kt-scroll-wrappers="#kt_modal_update_email_scroll" data-kt-scroll-offset="300px">

                            <!--Email-->
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">{{ $t('user.label.email') }}</label>
                                <Field type="email" :placeholder="$t('user.placeholder.email')" class="form-control form-control-lg form-control-solid" name="email" v-model="formData.email"/>
                                <ErrorMessage :errorMessage="formData.errors.email" />
                            </div>
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--Discard Button-->
                        <div data-bs-dismiss="modal" class="btn btn-light me-3">
                            {{ $t('buttonValue.discard') }}
                        </div>

                        <!-- Submit Button -->
                        <SubmitButton :id="props.user?.id" />
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
import { useForm, usePage } from '@inertiajs/vue3';
import toastr from 'toastr';
import 'toastr/toastr.scss';

const formRef = ref < null | HTMLFormElement > (null);
const editUserModalRef = ref < null | HTMLElement > (null);

const props = defineProps({
    user: Object
})

const formData = useForm({
    name: props.user?.name || '',
    email: props.user?.email || ''
});

watch([() => props.user?.name, () => props.user?.email], ([name, email]) => {
    formData.name = name || '';
    formData.email = email || '';
});

const submit = () => {
    const url = route('users.updateEmail', props.user?.id);
    formData.patch(url, {
        preserveScroll: true,
        onSuccess: () => {
            hideModal(editUserModalRef.value);
            const flash = usePage().props.flash;
            let { success } = flash as any;

            if (flash && success) {
                toastr.success(success);
                success = null;
            }
        }
    })
};

</script>
