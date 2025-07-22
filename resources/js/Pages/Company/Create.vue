<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Add Company</h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Plan Name and Workspace Name -->
                        <div class="row mb-5 g-4">
                        <!-- Category -->
                            <div class="col-md-4 fv-row">
                                <label class="fs-5 required fw-semibold mb-2">Category</label>
                                <Multiselect
                                    placeholder="Category"
                                    v-model="formData.category_id"
                                    :searchable="true"
                                    label="text"
                                    trackBy="text"
                                    :options="categories"
                                />
                                <ErrorMessage :errorMessage="formData.errors.category_id" />
                            </div>
                            <!-- Plan Name -->
                            <div class="col-md-4 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Subscription Plan</label>
                                <Multiselect
                                    placeholder="Subscription Plan"
                                    v-model="formData.subscription_plan_id"
                                    :searchable="true"
                                    label="text"
                                    trackBy="text"
                                    :options="subscriptionPlans"
                                />
                                <ErrorMessage :errorMessage="formData.errors.subscription_plan_id" />
                            </div>

                            <!-- Workspace Name -->
                            <div class="col-md-4 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Workspace</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Workspace" name="workspace" v-model="formData.workspace"/>
                                <ErrorMessage :errorMessage="formData.errors.workspace" />
                            </div>
                        </div>

                        <!-- Company Name -->
                        <div class="row mb-5 g-4">
                            <!-- Company Name (English) -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Company Name (English)</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Company Name in English" name="name" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name" />
                            </div>

                            <!-- Company Name (Bangla) -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Company Name (Bangla)</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Company Name in Bangla" name="name_bn" v-model="formData.name_bn"/>
                                <ErrorMessage :errorMessage="formData.errors.name_bn" />
                            </div>
                        </div>

                        <!-- Category, Mobile Number and Additional mobile number -->
                        <div class="row mb-5 g-4">
                            <!-- Mobile Number -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 required fw-semibold mb-2">Mobile Number</label>
                                <Field type="tel" class="form-control form-control-lg form-control-solid" placeholder="Mobile Number" name="mobile_number" v-model="formData.mobile_number"/>
                                <ErrorMessage :errorMessage="formData.errors.mobile_number" />
                            </div>

                            <!-- Additional mobile number -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Additional Mobile Number</label>
                                <Field type="tel" class="form-control form-control-lg form-control-solid" placeholder="Additional Mobile Number" name="additional_mobile_number" v-model="formData.additional_mobile_number"/>
                                <ErrorMessage :errorMessage="formData.errors.additional_mobile_number" />
                            </div>
                        </div>

                        <!-- Password and Confirm Password -->
                        <div class="row mb-5 g-4">
                            <!-- Password -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 required fw-semibold mb-2">Password</label>
                                <Field type="password" class="form-control form-control-lg form-control-solid" placeholder="Password" name="password" v-model="formData.password"/>
                                <ErrorMessage :errorMessage="formData.errors.password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 required fw-semibold mb-2">Confirm Password</label>
                                <Field type="password" class="form-control form-control-lg form-control-solid" placeholder="Password" name="password_confirmation" v-model="formData.password_confirmation"/>
                                <ErrorMessage :errorMessage="formData.errors.password_confirmation" />
                            </div>

                            <div class="separator separator-dashed mt-5"></div>
                            <!-- Address -->
                            <div>
                                <h3 class="text-dark font-weight-bold mt-7 mb-5">Address</h3>
                                <div class="row mb-5 g-4">
                                    <!-- Divisions -->
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">Division</label>
                                        <Multiselect
                                            placeholder="Division"
                                            v-model="formData.division_id"
                                            :searchable="true"
                                            label="text"
                                            trackBy="text"
                                            :options="divisions"
                                        />
                                        <ErrorMessage :errorMessage="formData.errors.division_id" />
                                    </div>

                                    <!-- Districts -->
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">District</label>
                                        <Multiselect
                                            placeholder="District"
                                            v-model="formData.district_id"
                                            :searchable="true"
                                            label="text"
                                            trackBy="text"
                                            :options="districts"
                                        />
                                        <ErrorMessage :errorMessage="formData.errors.district_id" />
                                    </div>
                                </div>

                                <div class="row mb-5 g-4">
                                    <!-- Upazila -->
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">Upazila</label>
                                        <Multiselect
                                            placeholder="Upazila"
                                            v-model="formData.upazila_id"
                                            :searchable="true"
                                            label="text"
                                            trackBy="text"
                                            :options="upazilas"
                                        />
                                        <ErrorMessage :errorMessage="formData.errors.upazila_id" />
                                    </div>

                                    <!-- Unions -->
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">Union</label>
                                        <Multiselect
                                            placeholder="Union"
                                            v-model="formData.union_id"
                                            :searchable="true"
                                            label="text"
                                            trackBy="text"
                                            :options="unions"
                                        />
                                        <ErrorMessage :errorMessage="formData.errors.union_id" />
                                    </div>
                                </div>

                                <div class="row mb-5 g-4">
                                    <div class="col-md-12 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">Village</label>
                                        <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Village" name="village" v-model="formData.village"/>
                                        <ErrorMessage :errorMessage="formData.errors.village" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton />
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
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    subscription_plan_id: '',
    workspace: '',
    name: '',
    name_bn: '',
    category_id: '',
    mobile_number: '',
    additional_mobile_number: '',
    plan_type: '',
    password: '',
    password_confirmation: '',
    division_id: '',
    district_id: '',
    upazila_id: '',
    union_id: '',
    village: ''
});

const divisions = ref<any[]>([]);
const districts = ref<any[]>([]);
const upazilas = ref<any[]>([]);
const unions = ref<any[]>([]);

const fetchDivisions = async () => {
    const response = await axios.get('/api/v1/divisions');
    divisions.value = response.data;
};

const fetchDistricts = async (divisionId: number) => {
    const response = await axios.get(`/api/v1/divisions/${divisionId}/districts`);
    districts.value = response.data;
};

const fetchUpazilas = async (districtId: number) => {
    const response = await axios.get(`/api/v1/districts/${districtId}/upazilas`);
    upazilas.value = response.data;
};

const fetchUnions = async (upazilaId: number) => {
    const response = await axios.get(`/api/v1/upazilas/${upazilaId}/unions`);
    unions.value = response.data;
};

watch(() => formData.division_id, (divisionId: any) => {
    formData.district_id = '';
    formData.upazila_id = '';
    formData.union_id = '';
    fetchDistricts(divisionId);
});

watch(() => formData.district_id, (districtId: any) => {
    formData.upazila_id = '';
    formData.union_id = '';
    fetchUpazilas(districtId);
});

watch(() => formData.upazila_id, (upazilaId: any) => {
    formData.union_id = '';
    fetchUnions(upazilaId);
});

const categories = ref<any[]>([]);
const subscriptionPlans = ref<any[]>([]);

const fetchCategories = async () => {
    const response = await axios.get('/company-categories');
    categories.value = response.data;
};

const fetchSubscriptionPlans = async (categoryId: number) => {
    const response = await axios.get(`/company-categories/${categoryId}/subscription-plans`);
    subscriptionPlans.value = response.data;

    //auto select 6 month duration plan that's Half Yearly
    const halfYearlyPlan = subscriptionPlans.value.find((plan: any) => plan.duration === 6 || plan.text?.includes('অর্ধ বার্ষিক'));

    if(halfYearlyPlan){
        formData.subscription_plan_id = halfYearlyPlan.value;
    } else {
        formData.subscription_plan_id = '';
    }
};

watch(() => formData.category_id, (categoryId: any) => {
    formData.subscription_plan_id = '';
    fetchSubscriptionPlans(categoryId);
});

onMounted(() => {
    fetchDivisions();
    fetchCategories();
});

const submit = () => {
    formData.post(route('companies.store'), {
        preserveScroll: true,
    });
};
</script>
