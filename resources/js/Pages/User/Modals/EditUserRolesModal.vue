<template>
    <div class="modal fade" id="kt_modal_update_role" ref="editUserModalRef" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_update_role_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ $t('user.header.title.updateRoles') }}</h2>
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div id="kt_modal_update_role_close" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">

                            <!--Roles-->
                            <div class="fv-row mb-7 multiselect-parent-div">
                                <label class="fs-5 fw-semibold mb-2">{{ $t('user.label.assignRole') }}</label>
                                <Multiselect
                                    :placeholder="$t('user.placeholder.assignRole')"
                                    mode="tags"
                                    v-model="formData.roles"
                                    :searchable="true"
                                    :options="allRoles"
                                    label="name"
                                    trackBy="name"
                                />
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
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { ref, watch } from "vue";
import { hideModal } from "@/Core/helpers/Modal";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { Form as VForm } from "vee-validate";
import { useForm, usePage } from '@inertiajs/vue3';
import toastr from 'toastr';
import 'toastr/toastr.scss';
import Multiselect from '@vueform/multiselect';

const formRef = ref < null | HTMLFormElement > (null);
const editUserModalRef = ref < null | HTMLElement > (null);

const props = defineProps({
    user: Object,
    activeRoles: Object,
})

// assign all the roles from props to allRoles variable.
const allRoles = ref<Array<any>>([]);
if (Array.isArray(props.activeRoles) && props.activeRoles.length > 0) {
    allRoles.value = props.activeRoles.map(role => ({value: role.id, name:role.name}));
}

const formData = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    roles: props.user?.roles !== undefined ? props.user?.roles.map((role: any) => role.id) : []
});

watch([() => props.user?.name, () => props.user?.email, () => props.user?.roles], ([name, email, roles]) => {
    formData.name = name || '';
    formData.email = email || '';
    formData.roles = roles !== undefined ? roles.map((role: any) => role.id) : [];
});


const submit = () => {
    const url = route('users.updateRoles', props.user?.id);
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
