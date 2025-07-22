<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <ConfigurationHeader activeLink="SmsService" :configuration="props?.configuration"></ConfigurationHeader>

        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

            <VForm @submit="submit()" class="form">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ $t('configuration.header.title.smsService') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div>
                        <!-- Base Url -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.smsServiceBaseUrl') }}</label>
                            <Field type="url" class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.smsServiceBaseUrl')" name="sms_service_base_url" v-model="formData.sms_service_base_url"/>
                            <ErrorMessage :errorMessage="formData.errors.sms_service_base_url"/>
                        </div>

                        <!-- API Key -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.smsServiceApiKey') }}</label>
                            <div class="input-group">
                                <Field
                                    :type="isSmsApiKeyVisible ? 'text' : 'password'"
                                    class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.smsServiceApiKey')" name="sms_service_api_key" v-model="formData.sms_service_api_key"
                                />
                                <span class="input-group-text" @click="toggleSmsApiKeyVisibility" style="cursor: pointer;">
                                    <!-- Toggle Icons -->
                                    <i v-if="isSmsApiKeyVisible" class="fas fa-eye-slash fs-5"></i>
                                    <i v-else class="fas fa-eye fs-5"></i>
                                </span>
                            </div>
                            <ErrorMessage :errorMessage="formData.errors.sms_service_api_key"/>
                        </div>

                        <!-- Sms Service Sender Id -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.smsServiceSenderId') }}</label>
                            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.smsServiceSenderId')" name="sms_service_sender_id" v-model="formData.sms_service_sender_id"/>
                            <ErrorMessage :errorMessage="formData.errors.sms_service_sender_id"/>
                        </div>

                        <!-- OTP Expiry Time Minutes -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.otpExpiryTimeMinutes') }}</label>
                            <Field type="number" class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.otpExpiryTimeMinutes')" name="otp_expiry_time_minutes" v-model="formData.otp_expiry_time_minutes"/>
                            <ErrorMessage :errorMessage="formData.errors.otp_expiry_time_minutes"/>
                        </div>

                        <!-- SMS Rate -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.smsRate') }}</label>
                            <Field type="number" step="0.01" class="form-control form-control-lg form-control-solid"
                                placeholder="Enter SMS Rate" name="sms_rate" v-model="formData.sms_rate"/>
                            <ErrorMessage :errorMessage="formData.errors.sms_rate"/>
                        </div>

                        <!-- Free SMS Quantity -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.freeSmsQuantity') }}</label>
                            <Field type="number" class="form-control form-control-lg form-control-solid"
                                placeholder="Enter Free SMS Quantity" name="free_sms_quantity" v-model="formData.free_sms_quantity"/>
                            <ErrorMessage :errorMessage="formData.errors.free_sms_quantity"/>
                        </div>

                    </div>
                </div>
                <!--end::Card body-->

                <!-- Submit Button-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <SubmitButton :obj="props?.configuration" />
                </div>
            </VForm>
        </div>
    </AuthenticatedLayout>
</template>

<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ConfigurationHeader from '@/Pages/Configuration/ConfigurationHeader.vue';
import {Field, Form as VForm} from "vee-validate";
import {useForm} from '@inertiajs/vue3';
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { ref } from 'vue';

const props = defineProps({
    configuration: Object,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    sms_service_base_url: props.configuration?.sms_service_base_url || '',
    sms_service_api_key: props.configuration?.sms_service_api_key || '',
    sms_service_sender_id: props.configuration?.sms_service_sender_id || '',
    otp_expiry_time_minutes: props.configuration?.otp_expiry_time_minutes || '',
    sms_rate: props.configuration?.sms_rate || '',
    free_sms_quantity: props.configuration?.free_sms_quantity || '',
});

const submit = () => {
    formData.patch(route('configurations.updateSmsService', props.configuration?.id), {
        preserveScroll: true,
    });
};

const isSmsApiKeyVisible = ref(false);

const toggleSmsApiKeyVisibility = () => {
    isSmsApiKeyVisible.value = !isSmsApiKeyVisible.value;
};
</script>
