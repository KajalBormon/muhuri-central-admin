<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <ConfigurationHeader activeLink="BasicInfo" :configuration="props?.configuration"></ConfigurationHeader>

        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

            <VForm @submit="submit()" class="form">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ $t('configuration.header.title.basicInformation') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div>
                        <!-- Company Name -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.companyName') }}</label>
                                <Field type="text" :placeholder="$t('configuration.placeholder.companyName')" name="name" class="form-control form-control-lg form-control-solid" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name"/>
                        </div>

                        <!-- Organization Number -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.organizationNumber') }}</label>
                            <Field type="number" :placeholder="$t('configuration.placeholder.organizationNumber')" name="organization_number" class="form-control form-control-lg form-control-solid" v-model="formData.organization_number"/>
                            <ErrorMessage :errorMessage="formData.errors.organization_number"/>
                        </div>

                        <!-- Country -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.country') }}</label>
                            <Multiselect
                                :placeholder="$t('configuration.placeholder.country')"
                                v-model="formData.country_id"
                                :searchable="true"
                                :options="allCountries"
                                label="name"
                                trackBy="name"
                            />
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
import Multiselect from '@vueform/multiselect';

const props = defineProps({
    countries: Object,
    configuration: Object,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    name: props.configuration?.name || '',
    organization_number: props.configuration?.organization_number || '',
    country_id: props.configuration?.country_id || ''
});

// assign all the countries from props to allCountries variable.
const allCountries = ref<Array<any>>([]);
if (Array.isArray(props.countries) && props.countries.length > 0) {
    allCountries.value = props.countries.map((country: { id: any; name: any; }) => ({value: country.id, name:country.name}));
}

const submit = () => {
    formData.patch(route('configurations.updateBasicInfo', props.configuration?.id), {
        preserveScroll: true,
    });
};
</script>
