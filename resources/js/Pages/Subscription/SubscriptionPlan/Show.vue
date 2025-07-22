<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="tabTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-toolbar m-0">
                    <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a id="kt_referrals_subscription_plan_details_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)" @click="activeTab = 1" :class="{ 'active': activeTab === 1 }">
                                Subscription Plan Details
                            </a>
                        </li>

                        <li v-if="checkPermission('can-view-subscription-plan-feature')" class="nav-item" role="presentation">
                            <a id="kt_referrals_subscription_plan_feature_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)" @click="activeTab = 2" :class="{ 'active': activeTab === 2 }">
                                Subscription Plan Features
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-title m-0" v-show="activeTab === 1">
                    <div class="d-flex align-items-center position-relative my-1">
                        <Link v-if="checkPermission('can-edit-subscription-plan')" :href="route('subscription-plans.edit', props.subscriptionPlan?.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" title="Edit">
                            <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                        </Link>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div id="kt_referred_subscription_plan_details_tab_content" class="tab-content">
                    <!-- Subscription Plan Details -->
                    <div id="subscription_plan_details" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 1">
                        <!-- Name -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Name</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.name }}</span>
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Slug</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.slug }}</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Price</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.price }}</span>
                            </div>
                        </div>

                        <!-- Plan Type -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Plan Type</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.plan_type }}</span>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Duration</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.duration }}</span>
                            </div>
                        </div>

                        <!-- Trial Duration -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Trial Duration</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.trial_duration }}</span>
                            </div>
                        </div>

                        <!-- Discount Amount -->
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Discount Amount</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-900">{{ props.subscriptionPlan?.discount_amount }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="subscription_plan_feature" class="py-0 tab-pane fade active show" role="tabpanel" v-show="activeTab === 2">
                        <div class="show">
                            <VForm @submit="submit()" class="form">
                                <div class="card-body border-top p-9">
                                    <div class="fv-row">
                                        <label class="fs-5 fw-bold form-label mb-2">Select any Subscription Plan Features</label>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <tr>
                                                        <td>
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                                <input class="form-check-input" type="checkbox" id="kt_subscription_plans_select_all" v-model="selectAll" @change="selectAllSubscriptionPlanFeatures" />
                                                                <span class="form-check-label" for="kt_subscription_plans_select_all">Select All</span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr v-for="subscriptionPlanFeature in props.subscriptionPlanFeatures" :key="subscriptionPlanFeature.id">
                                                        <td>
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" :value="subscriptionPlanFeature.id" v-model="formData.subscription_plan_features" />
                                                                <span class="form-check-label">{{ subscriptionPlanFeature.title }}</span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <SubmitButton :id="props.subscriptionPlan?.id" />
                                </div>
                            </VForm>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, defineProps, watch, computed } from 'vue';
import { Link } from '@inertiajs/vue3'
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { checkPermission } from "@/Core/helpers/Permission";
import { Form as VForm } from "vee-validate";
import { useForm, router, usePage } from '@inertiajs/vue3';
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import toastr from 'toastr';
import 'toastr/toastr.scss';

const activeTab = ref(1);

const props = defineProps({
    subscriptionPlanFeatures: Object as() => ISubscriptionPlanFeature[] | undefined,
    subscriptionPlan: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

const tabTitle = ref(props?.pageTitle);

watch(activeTab, () => {
    tabTitle.value = activeTab.value === 1 ? 'Subscription Plan Details' : 'Subscription Plan Features';
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface ISubscriptionPlanFeature {
    id: number;
    title: string;
}

const formData = useForm({
    subscription_plan_features: props?.subscriptionPlan?.subscription_plan_features || []
});

const selectAll = ref(false);

const allSelected = computed(() => {
    if(props?.subscriptionPlanFeatures) {
        return props?.subscriptionPlanFeatures?.length > 0 && props.subscriptionPlanFeatures?.every(feature => formData.subscription_plan_features.includes(feature.id));
    }
});

watch(allSelected, (newValue) => {
    if (newValue !== undefined) {
        selectAll.value = newValue;
    }
});

// if select all button is checked assign all the ids to formData.subscription_plan_features
const selectAllSubscriptionPlanFeatures = () => {
    if (selectAll.value) {
        if (props.subscriptionPlanFeatures) {
            formData.subscription_plan_features = props?.subscriptionPlanFeatures?.map((subscriptionPlanFeature => subscriptionPlanFeature.id));
        }
    }
    else {
        formData.subscription_plan_features = [];
    }
};

onMounted(() => {
    if (props.subscriptionPlan?.subscription_plan_features) {
        formData.subscription_plan_features = props.subscriptionPlan?.subscription_plan_features?.map((feature: { id: any; }) => feature.id);
    }
});

const submit = () => {
    // for updating subscription plan
    formData.patch(route('subscription-plans.featuresUpdate', props.subscriptionPlan?.id), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('subscription-plans.show', props.subscriptionPlan?.id), { replace: true });
            const flash = usePage().props.flash;
            let {success} = flash as any;

            if (flash && success) {
                toastr.success(success);
            }
        }
    });
};
</script>
