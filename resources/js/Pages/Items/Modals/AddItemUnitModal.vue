<template>
    <div class="modal fade" id="kt_modal_add_item_unit" ref="addItemUnitModalRef" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_email_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Item Unit</h2>
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
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_update_item_unit" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_item_unit_header" data-kt-scroll-wrappers="#kt_modal_update_item_unit_scroll" data-kt-scroll-offset="300px">

                            <!--Name-->
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Name</label>
                                <Field type="text" placeholder="Name" class="form-control form-control-lg form-control-solid" name="name" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name" />
                            </div>

                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Value</label>
                                <Field type="text" placeholder="Value" class="form-control form-control-lg form-control-solid" name="value" v-model="formData.value"/>
                                <ErrorMessage :errorMessage="formData.errors.value" />
                            </div>

                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Display Name</label>
                                <Field type="text" placeholder="Display Name" class="form-control form-control-lg form-control-solid" name="display_name" v-model="formData.display_name"/>
                                <ErrorMessage :errorMessage="formData.errors.display_name" />
                            </div>

                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Form Display Name</label>
                                <Field type="text" placeholder="Display Name" class="form-control form-control-lg form-control-solid" name="form_display_name" v-model="formData.form_display_name"/>
                                <ErrorMessage :errorMessage="formData.errors.form_display_name" />
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
                        <SubmitButton :id="props.item?.id" />
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
import { ref, watch, defineProps } from "vue";
import { useForm, usePage } from '@inertiajs/vue3';
import { hideModal } from "@/Core/helpers/Modal";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { Field, Form as VForm } from "vee-validate";
import toastr from 'toastr';
import 'toastr/toastr.scss';

const formRef = ref < null | HTMLFormElement > (null);
const addItemUnitModalRef = ref < null | HTMLElement > (null);

const props = defineProps({
    item: Object
})

const formData = useForm({
    name: '',
    value: '',
    display_name: '',
    form_display_name: '',
});

const submit = () => {
    const url = route('items.storeItemUnit', props.item?.id);
    formData.post(url, {
        preserveScroll: true,
        onSuccess: () => {
            hideModal(addItemUnitModalRef.value);
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
