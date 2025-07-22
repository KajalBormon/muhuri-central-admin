<template>
    <!-- Address Line One -->
    <div class="d-flex flex-column mb-5 fv-row">
        <label class="fs-5 fw-semibold mb-2">{{ $t('commonComponents.addressComponent.label.addressLineOne') }}</label>
        <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('commonComponents.addressComponent.placeholder.addressLineOne')" name="address_line_one" v-model="address_line_one"/>
        <ErrorMessage :errorMessage="errors?.address_line_one" />
    </div>

    <!-- Address Line Two -->
    <div class="d-flex flex-column mb-5 fv-row">
        <label class="fs-5 fw-semibold mb-2">{{ $t('commonComponents.addressComponent.label.addressLineTwo') }}</label>
        <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('commonComponents.addressComponent.placeholder.addressLineTwo')" name="address_line_two" v-model="address_line_two"/>
        <ErrorMessage :errorMessage="errors?.address_line_two" />
    </div>

    <!-- Floor and City-->
    <div class="row mb-5 g-4">
        <!-- Floor -->
        <div class="col-md-6 fv-row">
            <label class="fs-5 fw-semibold mb-2">{{ $t('commonComponents.addressComponent.label.floor') }}</label>
            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('commonComponents.addressComponent.placeholder.floor')" name="floor" v-model="floor"/>
            <ErrorMessage :errorMessage="errors?.floor" />
        </div>

        <!-- City -->
        <div class="col-md-6 fv-row">
            <label class="fs-5 fw-semibold mb-2">{{ $t('commonComponents.addressComponent.label.city') }}</label>
            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('commonComponents.addressComponent.placeholder.city')" name="city" v-model="city"/>
            <ErrorMessage :errorMessage="errors?.city" />
        </div>
    </div>

    <!-- State and Zip Code-->
    <div class="row mb-5 g-4">
        <!-- State -->
        <div class="col-md-6 fv-row">
            <label class="fs-5 fw-semibold mb-2">{{ $t('commonComponents.addressComponent.label.state') }}</label>
            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('commonComponents.addressComponent.placeholder.state')" name="state" v-model="state"/>
            <ErrorMessage :errorMessage="errors?.state" />
        </div>

        <!-- Zip Code -->
        <div class="col-md-6 fv-row">
            <label class="fs-5 fw-semibold mb-2">{{ $t('commonComponents.addressComponent.label.zipCode') }}</label>
            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('commonComponents.addressComponent.placeholder.zipCode')" name="zip_code" v-model="zip_code"/>
            <ErrorMessage :errorMessage="errors?.zip_code" />
        </div>
    </div>
</template>

<script setup>
import { Field } from 'vee-validate';
import ErrorMessage from '@/Components/Message/ErrorMessage.vue';

const props = defineProps({
    errors: Array | null
})
const address_line_one = defineModel('address_line_one');
const address_line_two = defineModel('address_line_two');
const floor = defineModel('floor');
const city = defineModel('city');
const state = defineModel('state');
const zip_code = defineModel('zip_code');
</script>
