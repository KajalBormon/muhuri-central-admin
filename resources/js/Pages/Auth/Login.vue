<template>
    <Head :title="`${props?.pageTitle}`" />
    <!--begin::Authentication Layout -->
    <div class="d-flex flex-column flex-root login-page" style="background-image: url('/media/auth/bg10.jpeg');">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <!--begin::Image-->
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        :src="getAssetPath('/media/auth/agency.png')" alt=""/>
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        :src="getAssetPath('/media/auth/agency-dark.png')" alt=""/>
                    <!--end::Image-->
                    <!--begin::Title-->
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
                        <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person
                        they’ve interviewed
                        <br/>and provides some background information about
                        <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
                        <br/>work following this is a transcript of the interview.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                            <!--begin::Form-->
                            <VForm class="form w-100" id="kt_sign_in_form" data-kt-redirect-url="index.html"
                                @submit="onSubmitLogin">
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <img alt="Logo" :src="getAssetPath('/media/logos/nonditosoft-logo.png')"
                                        class="h-60px h-lg-75px"/>
                                    <h1 class="text-gray-900 fw-bolder mb-3">{{ $t('auth.login.title') }}</h1>
                                </div>
                                <!--begin::Heading-->

                                <!--Email-->
                                <div class="fv-row mb-8">
                                    <Field class="form-control form-control-lg bg-transparent" type="text"
                                        name="email"
                                        autocomplete="off" v-model="formData.email" placeholder="Enter email"/>
                                    <ErrorMessage :errorMessage="formData.errors.email"/>
                                </div>

                                <!--Password-->
                                <div class="fv-row mb-3">
                                    <Field class="form-control form-control-lg bg-transparent" type="password"
                                        name="password" autocomplete="off" v-model="formData.password"
                                        placeholder="Enter password"/>
                                    <ErrorMessage :errorMessage="formData.errors.password"/>
                                </div>

                                <!--Forgot Password-->
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div></div>
                                    <Link :href="''" class="link-primary">
                                        {{ $t('auth.login.forgotPassword') }} ?
                                    </Link>
                                </div>

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <!-- Submit Button-->
                                    <SubmitButton :buttonValue="$t('buttonValue.signIn')" class="btn btn-lg w-100 mb-5"/>
                                </div>
                                <!--end::Submit button-->
                            </VForm>
                            <!--end::Form-->
                        </div>

                        <!--begin::Footer-->
                        <div class="d-flex flex-center">
                            <!-- Links -->
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <Link :href="''" target="_blank">{{ $t('links.footer.terms') }}</Link>
                                <Link :href="''" target="_blank">{{ $t('links.footer.plans') }}</Link>
                                <Link :href="''" target="_blank">{{ $t('links.footer.contactUs') }}</Link>
                            </div>
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Authentication Layout -->
</template>
<style>
#app, .login-page {
    height: 100%;
}

</style>

<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import {getAssetPath} from "@/Core/helpers/Assets";
import {Field, Form as VForm} from "vee-validate";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import {Link, useForm} from "@inertiajs/vue3"
import Swal from "sweetalert2/dist/sweetalert2.js";
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const props = defineProps({
    pageTitle: String
});

const formData = useForm({
    email: '',
    password: ''
});

const onSubmitLogin = async () => {
    formData.post(route('login'), {
        onSuccess: () => {
            Swal.fire({
                text: `${t('confirmation.successfulLogin')}!`,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: `${t('confirmation.gotIt')}!`,
                heightAuto: false,
                customClass: {
                    confirmButton: "btn fw-semibold btn-light-primary",
                },
            });
        },
        onFinish: () => {
            formData.reset('password');
        },
    });
};
</script>
