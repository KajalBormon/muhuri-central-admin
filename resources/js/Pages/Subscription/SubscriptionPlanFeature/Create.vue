<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.subscriptionPlanFeature?.id ? 'Edit Subscription Plan Feature' : 'Add Subscription Plan Feature' }} </h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Title-->
                        <div class="row mb-5 g-4">
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Title</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Feature Title" name="title" v-model="formData.title"/>
                                <ErrorMessage :errorMessage="formData.errors.title" />
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.subscriptionPlanFeature?.id" />
                    </div>
                </VForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Field, Form as VForm } from "vee-validate";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";

const props = defineProps({
    subscriptionPlanFeature: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    title: props.subscriptionPlanFeature?.title || ''
});

const submit = () => {
    if(props.subscriptionPlanFeature?.id) {
        // for updating subscriptionPlanFeature
        formData.patch(route('subscription-plan-features.update', props.subscriptionPlanFeature?.id), {
            preserveScroll: true,
        });
    } else {
        // for adding subscriptionPlanFeature
            formData.post(route('subscription-plan-features.store'), {
            preserveScroll: true,
        });
    }
};
</script>

