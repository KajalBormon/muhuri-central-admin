<script setup lang="ts">
import { ref } from 'vue';
import { Field, Form as VForm } from "vee-validate";
import { useForm, router,usePage } from '@inertiajs/vue3';
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);
const passwordFormDisplay = ref(false);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const user = usePage().props.auth.user;

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            router.visit(route('profile.edit'));
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ $t('user.header.profile.update.signInMethod') }}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->

            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Email Address-->
                <div class="d-flex flex-wrap align-items-center mb-8">
                    <div id="kt_signin_email">
                        <div class="fs-4 fw-bolder mb-1">{{ $t('user.label.email') }}</div>
                        <div class="fs-6 fw-semibold text-gray-600">
                            {{ user.email }}
                        </div>
                    </div>
                </div>
                <!--end::Email Address-->
                <!--begin::Password-->
                <div class="d-flex flex-wrap align-items-center mb-8">
                    <div id="kt_signin_password" :class="{ 'd-none': passwordFormDisplay }">
                        <div class="fs-4 fw-bolder mb-1">{{ $t('user.label.password') }}</div>
                        <div class="fs-6 fw-semibold text-gray-600">************</div>
                    </div>
                    <div id="kt_signin_password_edit" class="flex-row-fluid" :class="{ 'd-none': !passwordFormDisplay }">
                        <!--begin::Form-->
                        <VForm id="kt_signin_change_password" class="form" novalidate @submit="updatePassword()">
                            <div class="row mb-6">
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">{{ $t('user.label.currentPassword') }}</label>
                                        <Field type="password" class="form-control " name="current_password" id="current_password" v-model="form.current_password" :placeholder="$t('user.placeholder.currentPassword')"/>
                                        <ErrorMessage :errorMessage="form.errors.current_password" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">{{ $t('user.label.newPassword') }}</label>
                                        <Field type="password" class="form-control form-control-lg form-control-solid" name="password" id="password" v-model="form.password" :placeholder="$t('user.placeholder.newPassword')"/>
                                        <ErrorMessage :errorMessage="form.errors.password" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">{{ $t('user.label.confirmNewPassword') }}</label>
                                        <Field type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation" id="password_confirmation" v-model="form.password_confirmation" :placeholder="$t('user.placeholder.confirmNewPassword')"/>
                                        <ErrorMessage :errorMessage="form.errors.password_confirmation" />
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <SubmitButton :id="user?.id" />
                                <button id="kt_password_cancel" type="button" @click="passwordFormDisplay = !passwordFormDisplay" class="btn btn-color-gray-500 btn-active-light-primary px-6">
                                    {{ $t('buttonValue.cancel') }}
                                </button>
                            </div>
                        </VForm>
                        <!--end::Form-->
                    </div>
                    <div id="kt_signin_password_button" class="ms-auto" :class="{ 'd-none': passwordFormDisplay }">
                        <button @click="passwordFormDisplay = !passwordFormDisplay" class="btn btn-light fw-bolder">
                            {{ $t('user.label.resetPassword') }}
                        </button>
                    </div>
                </div>
                <!--end::Password-->
            </div>
            <!--end::Card body-->
        </div>
    </section>
</template>
