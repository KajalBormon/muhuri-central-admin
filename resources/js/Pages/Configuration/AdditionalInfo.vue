<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <ConfigurationHeader activeLink="AdditionalInfo" :configuration="props?.configuration"></ConfigurationHeader>

        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

            <VForm @submit="submit()" class="form">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ $t('configuration.header.title.additionalInformation') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div>
                        <!-- Date Format -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.dateFormat') }}</label>
                            <Multiselect
                                :placeholder = "$t('configuration.placeholder.dateFormat')"
                                v-model="formData.date_format"
                                :searchable="true"
                                :options="dateFormats"
                                label="text"
                                trackBy="text"
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
import {Form as VForm} from "vee-validate";
import {useForm} from '@inertiajs/vue3';
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import Multiselect from '@vueform/multiselect';

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
    date_format: props.configuration?.date_format || '',
});

const submit = () => {
    formData.patch(route('configurations.updateAdditionalInfo', props.configuration?.id), {
        preserveScroll: true,
    });
};
</script>
