<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <ConfigurationHeader activeLink="ContactInfo" :configuration="props?.configuration"></ConfigurationHeader>

        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

            <VForm @submit="submit()" class="form">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">{{ $t('configuration.header.title.contactInformation') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <div>
                        <!-- Email -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.email') }}</label>
                            <Field type="email" class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.email')" name="email" v-model="formData.email"/>
                            <ErrorMessage :errorMessage="formData.errors.email"/>
                        </div>

                        <!-- Admin Email -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.adminEmail') }}</label>
                            <Field type="email" class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.adminEmail')" name="admin_email" v-model="formData.admin_email"/>
                            <ErrorMessage :errorMessage="formData.errors.admin_email"/>
                        </div>

                        <!-- Telephone Number -->
                        <div class="row mb-5">
                            <label class="fs-5 fw-semibold">{{ $t('configuration.label.telephoneNumber') }}</label>
                            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('configuration.placeholder.telephoneNumber')" name="telephone"
                                    v-model="formData.telephone"/>
                            <ErrorMessage :errorMessage="formData.errors.telephone"/>
                        </div>
                    </div>

                    <div class="separator separator-dashed mt-5"></div>

                    <!-- Address -->
                    <div>
                        <h3 class="text-dark font-weight-bold mt-7 mb-5">{{ $t('configuration.label.address') }}</h3>
                        <Address
                            v-model:address_line_one="address_line_one"
                            v-model:address_line_two="address_line_two"
                            v-model:floor="floor"
                            v-model:city="city"
                            v-model:state="state"
                            v-model:zip_code="zip_code"
                            :errors="formData.errors"
                        ></Address>
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
import Address from "@/Components/Address.vue";
import {useForm} from '@inertiajs/vue3';
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { ref, watch } from 'vue';

const props = defineProps({
    configuration: Object,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}

// Fields of Address.vue
const address_line_one = ref(props.configuration?.address_line_one || '');
const address_line_two = ref(props.configuration?.address_line_two || '');
const floor = ref(props.configuration?.floor || '');
const city = ref(props.configuration?.city || '');
const state = ref(props.configuration?.state || '');
const zip_code = ref(props.configuration?.zip_code || '');

const formData = useForm({
    email: props.configuration?.email || '',
    admin_email: props.configuration?.admin_email || '',
    telephone: props.configuration?.telephone || '',
    address_line_one: address_line_one.value,
    address_line_two: address_line_two.value,
    floor: floor.value,
    city: city.value,
    state: state.value,
    zip_code: zip_code.value
});

// watcher to update values received from Address.vue
watch([address_line_one, address_line_two, floor, city, state, zip_code], ([address_line_one, address_line_two, floor, city, state, zip_code]) => {
    formData.address_line_one = address_line_one;
    formData.address_line_two = address_line_two;
    formData.floor = floor;
    formData.city = city;
    formData.state = state;
    formData.zip_code = zip_code;
});

const submit = () => {
    formData.patch(route('configurations.updateContactInfo', props.configuration?.id), {
        preserveScroll: true,
    });
};
</script>
