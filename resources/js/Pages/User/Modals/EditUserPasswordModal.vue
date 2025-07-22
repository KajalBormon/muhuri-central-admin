<template>
    <div class="modal fade" id="kt_modal_update_password" ref="editUserModalRef" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_password_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ $t('user.header.title.updatePassword') }}</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div id="kt_modal_update_password_close" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_update_password_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_password_header" data-kt-scroll-wrappers="#kt_modal_update_password_scroll" data-kt-scroll-offset="300px">

                            <!--New Password-->
                            <div class="fv-row mb-7">
                                <label for="newpassword" class="form-label fs-6 fw-bold mb-3">{{ $t('user.label.newPassword') }}</label>
                                <Field type="password" class="form-control form-control-lg form-control-solid" name="password" id="password" v-model="formData.password" :placeholder="$t('user.placeholder.newPassword')"/>
                                <ErrorMessage :errorMessage="formData.errors.password" />
                            </div>

                            <!--Password Confirmation-->
                            <div class="fv-row mb-7">
                                <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">{{ $t('user.label.confirmNewPassword') }}</label>
                                <Field type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation" id="password_confirmation" v-model="formData.password_confirmation" :placeholder="$t('user.placeholder.confirmNewPassword')"/>
                                <ErrorMessage :errorMessage="formData.errors.password_confirmation" />
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
import { ref } from "vue";
import { hideModal } from "@/Core/helpers/Modal";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { Field, Form as VForm } from "vee-validate";
import { useForm, usePage } from '@inertiajs/vue3';
import toastr from 'toastr';
import 'toastr/toastr.scss';

const formRef = ref < null | HTMLFormElement > (null);
const editUserModalRef = ref < null | HTMLElement > (null);

const props = defineProps({
    user: Object,
})

const formData = useForm({
    current_password: '',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    const url = route('users.updatePassword', props.user?.id);
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
        },
        onError: () => {
            if (formData.errors.password) {
                formData.reset('password', 'password_confirmation');
            }
            if (formData.errors.current_password) {
                formData.reset('current_password');
            }
        }
    })
};

</script>
