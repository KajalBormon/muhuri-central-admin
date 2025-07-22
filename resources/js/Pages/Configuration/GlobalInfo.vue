<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <ConfigurationHeader activeLink="GlobalInfo" :configuration="props?.configuration"></ConfigurationHeader>

        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

            <VForm @submit="submit()" class="form">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ $t('configuration.header.title.globalInformation') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!-- Domain Admin Portal -->
                    <div class="row mb-5">
                        <label class="fs-5 fw-semibold">{{ $t('configuration.label.domainAdminPortal') }}</label>
                        <Field type="text" :placeholder="$t('configuration.placeholder.domainAdminPortal')" name="domain_admin_portal" class="form-control form-control-lg form-control-solid" v-model="formData.domain_admin_portal"/>
                        <ErrorMessage :errorMessage="formData.errors.domain_admin_portal"/>
                    </div>
                    <!-- Http Protocol -->
                    <div class="row mb-5">
                        <label class="fs-5 fw-semibold">{{ $t('configuration.label.httpProtocol') }}</label>
                        <Field type="text" :placeholder="$t('configuration.placeholder.httpProtocol')" name="http_protocol" class="form-control form-control-lg form-control-solid" v-model="formData.http_protocol"/>
                        <ErrorMessage :errorMessage="formData.errors.http_protocol"/>
                    </div>
                    <!-- Support Email -->
                    <div class="row mb-5">
                        <label class="fs-5 fw-semibold">{{ $t('configuration.label.supportEmail') }}</label>
                        <Field type="text" :placeholder="$t('configuration.placeholder.supportEmail')" name="support_email" class="form-control form-control-lg form-control-solid" v-model="formData.support_email"/>
                        <ErrorMessage :errorMessage="formData.errors.support_email"/>
                    </div>
                    <!-- Support Telephone -->
                    <div class="row mb-5">
                        <label class="fs-5 fw-semibold">{{ $t('configuration.label.supportTelephone') }}</label>
                        <Field type="text" :placeholder="$t('configuration.placeholder.supportTelephone')" name="support_telephone" class="form-control form-control-lg form-control-solid" v-model="formData.support_telephone"/>
                        <ErrorMessage :errorMessage="formData.errors.support_telephone"/>
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
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";

const props = defineProps({
    dateFormats: Object,
    weekDays: Object,
    configuration: Object,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    domain_admin_portal: props.configuration?.domain_admin_portal || '',
    http_protocol: props.configuration?.http_protocol || '',
    support_email: props.configuration?.support_email || '',
    support_telephone: props.configuration?.support_telephone || '',
});

const submit = () => {
    formData.patch(route('configurations.updateGlobalInfo', props.configuration?.id), {
        preserveScroll: true,
    });
};
</script>
