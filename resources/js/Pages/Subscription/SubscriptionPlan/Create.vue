<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.subscriptionPlan?.id ? 'Edit Subscription Plan' : 'Add Subscription Plan' }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Name and Slug-->
                        <div class="row mb-5 g-4">
                            <!-- Plan Name -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Name</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Plan Name" name="name" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name" />
                            </div>

                            <!-- Plan Slug -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Slug</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Plan Slug" name="slug" v-model="formData.slug"/>
                                <ErrorMessage :errorMessage="formData.errors.slug" />
                            </div>
                        </div>

                        <!-- Company category -->
                        <div class="row mb-5 g-4">
                          <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Company Category</label>
                                <Multiselect
                                    placeholder="Company Category"
                                    v-model="formData.category_id"
                                    :searchable="true"
                                    label="text"
                                    trackBy="text"
                                    :options="props?.companyCategories"
                                />
                                <ErrorMessage :errorMessage="formData.errors.category_id" />
                            </div>
                             <!-- Description -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Description</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Description" name="description" v-model="formData.description"/>
                                <ErrorMessage :errorMessage="formData.errors.description" />
                            </div>
                        </div>

                        <!-- Price and Plan Type-->
                        <div class="row mb-5 g-4">
                            <!-- Price -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Price</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Price" name="price" v-model="formData.price"/>
                                <ErrorMessage :errorMessage="formData.errors.price" />
                            </div>

                            <!-- Plan Type -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Plan Type</label>
                                <Multiselect
                                    placeholder="Plan Type"
                                    v-model="formData.plan_type"
                                    :searchable="true"
                                    label="text"
                                    trackBy="text"
                                    :options="planTypes"
                                />
                                <ErrorMessage :errorMessage="formData.errors.plan_type" />
                            </div>
                        </div>

                        <!-- Duration and Duration Unit-->
                        <div class="row mb-5 g-4">
                            <!-- Duration -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Duration</label>
                                <Field type="number" class="form-control form-control-lg form-control-solid" placeholder="Duration" name="duration" v-model="formData.duration"/>
                                <ErrorMessage :errorMessage="formData.errors.duration" />
                            </div>

                            <!-- Duration Unit -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Duration Unit</label>
                                <Multiselect
                                    placeholder="Duration Unit"
                                    v-model="formData.duration_unit"
                                    :searchable="true"
                                    label="text"
                                    trackBy="text"
                                    :options="durationUnits"
                                />
                                <ErrorMessage :errorMessage="formData.errors.duration_unit" />
                            </div>
                        </div>

                        <!-- Trial Duration and Trial Duration Unit-->
                        <div class="row mb-5 g-4">
                            <!-- Trial Duration -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Trial Duration</label>
                                <Field type="number" class="form-control form-control-lg form-control-solid" placeholder="Trial Duration" name="trial_duration" v-model="formData.trial_duration"/>
                                <ErrorMessage :errorMessage="formData.errors.trial_duration" />
                            </div>

                            <!-- Trial Duration Unit -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Trial Duration Unit</label>
                                <Multiselect
                                    placeholder="Trial Duration Unit"
                                    v-model="formData.trial_duration_unit"
                                    :searchable="true"
                                    label="text"
                                    trackBy="text"
                                    :options="trialDurationUnits"
                                />
                                <ErrorMessage :errorMessage="formData.errors.trial_duration_unit" />
                            </div>
                        </div>

                        <!-- Discount Amount and Note-->
                        <div class="row mb-5 g-4">
                            <!-- Discount Amount -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Discount Amount</label>
                                <Field type="number" class="form-control form-control-lg form-control-solid" placeholder="Discount Amount" name="discount_amount" v-model="formData.discount_amount"/>
                                <ErrorMessage :errorMessage="formData.errors.discount_amount" />
                            </div>

                            <!-- Note -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Note</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Note" name="note" v-model="formData.note"/>
                                <ErrorMessage :errorMessage="formData.errors.note" />
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.subscriptionPlan?.id" />
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
import Multiselect from '@vueform/multiselect';

const props = defineProps({
    subscriptionPlan: Object,
    planTypes: Object,
    durationUnits: Object,
    trialDurationUnits: Object,
    companyCategories: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    name: props.subscriptionPlan?.name || '',
    slug: props.subscriptionPlan?.slug || '',
    category_id: props.subscriptionPlan?.category_id || '',
    description: props.subscriptionPlan?.description || '',
    price: props.subscriptionPlan?.price || '',
    plan_type: props.subscriptionPlan?.plan_type || 'monthly',
    duration: props.subscriptionPlan?.duration || 1,
    duration_unit: props.subscriptionPlan?.duration_unit || '',
    trial_duration: props.subscriptionPlan?.trial_duration || 0,
    trial_duration_unit: props.subscriptionPlan?.trial_duration_unit || '',
    discount_amount: props.subscriptionPlan?.discount_amount || 0,
    note: props.subscriptionPlan?.note || ''
});

const submit = () => {
    if(props.subscriptionPlan?.id) {
        // for updating subscriptionPlan
        formData.patch(route('subscription-plans.update', props.subscriptionPlan?.id), {
            preserveScroll: true,
        });
    } else {
        // for adding subscriptionPlan
            formData.post(route('subscription-plans.store'), {
            preserveScroll: true,
        });
    }
};
</script>

