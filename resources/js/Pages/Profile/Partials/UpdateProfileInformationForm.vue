<script lang="ts" setup>
import { Field, Form as VForm } from "vee-validate";
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";

defineProps < {
    mustVerifyEmail ? : Boolean;
    status ? : String;
} > ();

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    router.visit(route('profile.update'), {
        method: 'patch',
        data: {
            'name' : form.name,
            'email': form.email,
        },
        replace: true,
        preserveScroll: true,
    });
}
</script>

<template>
    <section>
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ $t('user.header.profile.update.profileInfo') }}</h3>
                </div>
                <!--end::Card title-->
            </div>

            <div class="card-body border-top p-9">
                <VForm @submit="submit()" class="form">
                    <div class="d-flex flex-column mb-5 fv-row">
                        <label class="fs-5 fw-semibold mb-2">{{ $t('user.label.email') }}</label>
                        <div class="text-muted">{{ form.email }}</div>
                    </div>

                    <div class="d-flex flex-column mb-5 fv-row">
                        <label class="fs-5 fw-semibold mb-2">{{ $t('user.label.name') }}</label>
                        <Field name="country_id" class="form-control form-control-lg form-control-solid" v-model="form.name" :placeholder="$t('user.placeholder.name')"/>
                        <ErrorMessage :errorMessage="form.errors.name" />
                    </div>

                    <div v-if="mustVerifyEmail && user.email_verified_at === null">
                        <p class="text-sm mt-2 text-gray-800">
                            {{ $t('user.header.info.email.unverified') }}
                            <Link :href="route('verification.send')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ $t('user.header.info.email.verification') }}
                            </Link>
                        </p>

                        <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
                            {{ $t('user.header.info.email.newVerification') }}
                        </div>
                    </div>

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="user?.id" />
                    </div>
                </VForm>
            </div>
        </div>
    </section>
</template>
