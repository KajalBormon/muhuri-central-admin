<template>
<!--begin::Authentication Layout -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-1" style="background-image: url('/media/misc/auth-bg.png');">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
            <!--begin::Logo-->
            <Link :href="''" class="mb-0 mb-lg-12">
                <img alt="Logo" :src="getAssetPath('/media/logos/nonditosoft-logo.png')" class="h-60px h-lg-75px"/>
            </Link>
            <!--end::Logo-->

            <!--begin::Image-->
            <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" :src="getAssetPath('/media/misc/auth-screens.png')" alt=""/>
            <!--end::Image-->

            <!--begin::Title-->
            <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                Fast, Efficient and Productive
            </h1>
            <!--end::Title-->

            <!--begin::Text-->
            <div class="d-none d-lg-block text-white fs-base text-center">
                In this kind of post,
                <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>

                introduces a person they’ve interviewed <br />
                and provides some background information about

                <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>
                and their <br />
                work following this is a transcript of the interview.
            </div>
            <!--end::Text-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->

    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-2">
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                <!--begin::Form-->
                <VForm class="form w-100" id="kt_login_signin_form" @submit="onSubmitLogin">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <h1 class="text-gray-900 mb-3">Sign In</h1>
                        <div class="text-gray-500 fw-semibold fs-4">
                            New Here?
                            <Link :href="''" class = "link-primary fw-bold">Create an Account</Link>
                        </div>
                    </div>
                    <!--end::Heading-->

                    <!-- Email -->
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bold text-gray-900">Email</label>
                        <Field tabindex="1" class="form-control form-control-lg " type="text" name="email" autocomplete="off" v-model="formData.email" placeholder = "Enter email"/>
                        <ErrorMessage :errorMessage="formData.errors.email" />
                    </div>

                    <!-- Password and Forgot Password-->
                    <div class="fv-row mb-10">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>
                            <!-- Forgot Password -->
                            <Link :href="''" class="link-primary fs-6 fw-bold">
                                Forgot Password ?
                            </Link>
                        </div>
                        <Field tabindex="2" class="form-control form-control-lg" type="password" name="password" autocomplete="off" v-model="formData.password" placeholder = "Enter password"/>
                        <ErrorMessage :errorMessage="formData.errors.password" />
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center">
                        <!-- Submit Button-->
                        <SubmitButton buttonValue="Continue" class="btn btn-lg w-100 mb-5"/>

                        <!--begin::Separator-->
                        <div class="text-center text-muted text-uppercase fw-bold mb-5">or</div>
                        <!--end::Separator-->

                        <!--Google link-->
                        <a href="#" class="btn btn-flex flex-center btn-info btn-lg w-100 mb-5">
                            <img alt="Logo" :src="getAssetPath('/media/svg/brand-logos/google-icon.svg')" class="h-20px me-3"/>
                            Continue with Google
                        </a>

                        <!--begin::Facebook link-->
                        <a href="#" class="btn btn-flex flex-center btn-info btn-lg w-100 mb-5">
                            <img alt="Logo" :src="getAssetPath('/media/svg/brand-logos/facebook-4.svg')" class="h-20px me-3"/>
                            Continue with Facebook
                        </a>

                        <!--begin::Apple link-->
                        <a href="#" class="btn btn-flex flex-center btn-info btn-lg w-100">
                            <img alt="Logo" :src="getAssetPath('/media/svg/brand-logos/apple-black.svg')" class="h-20px me-3"/>
                            Continue with Apple
                        </a>
                    </div>
                    <!--end::Actions-->
                </VForm>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="d-flex flex-center flex-wrap px-5">
            <!--begin::Links-->
            <div class="d-flex fw-semibold text-primary fs-base">
                <a href="#" class="px-5" target="_blank">Terms</a>

                <a href="#" class="px-5" target="_blank">Plans</a>

                <a href="#" class="px-5" target="_blank">Contact Us</a>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Body-->
</div>

<!--end::Authentication Layout -->
</template>

<script lang="ts" setup>
import { getAssetPath } from "@/Core/helpers/Assets";
import { ref } from "vue";
import { Field, Form as VForm } from "vee-validate";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { Link, useForm } from "@inertiajs/vue3"
import Swal from "sweetalert2/dist/sweetalert2.js";


const submitButton = ref<HTMLButtonElement | null>(null);
const formData = useForm({
    email: '',
    password: ''
});

const onSubmitLogin = async () => {
    formData.post(route('login'), {
        onSuccess: () => {
            Swal.fire({
            text: "You have successfully logged in!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
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
