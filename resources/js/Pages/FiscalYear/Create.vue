<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.fiscalYear?.id ? 'Edit' : 'Add' }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Fiscal Year and Note -->
                        <div class="row mb-5 g-4">
                            <!-- Fiscal Year -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Fiscal Year</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Fiscal Year" name="fiscal_year" v-model="formData.fiscal_year"/>
                                <ErrorMessage :errorMessage="formData.errors.fiscal_year" />
                            </div>

                            <!-- Note -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Note</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Note" name="note" v-model="formData.note"/>
                                <ErrorMessage :errorMessage="formData.errors.note" />
                            </div>
                        </div>

                        <!-- Start Date and End Date -->
                        <div class="row mt-2 mb-5 g-4">
                            <!-- Start Date -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Start Date</label>
                                <Field type="date" class="form-control form-control-lg form-control-solid" placeholder="Start Date" name="start_date" v-model="formData.start_date"/>
                                <ErrorMessage :errorMessage="formData.errors.start_date" />
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">End Date</label>
                                <Field type="date" class="form-control form-control-lg form-control-solid" placeholder="End Date" name="end_date" v-model="formData.end_date"/>
                                <ErrorMessage :errorMessage="formData.errors.end_date" />
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.fiscalYear?.id" />
                    </div>
                </VForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from '@inertiajs/vue3';
import { Field, Form as VForm } from "vee-validate";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";

const props = defineProps({
    fiscalYear: Object,
    pageTitle: String,
    breadcrumbs: Array as() => Breadcrumb[],
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    fiscal_year: props.fiscalYear?.fiscal_year || '',
    start_date: props.fiscalYear?.start_date || '',
    end_date: props.fiscalYear?.end_date || '',
    note: props.fiscalYear?.note || '',
});

const submit = () =>{
    if(props.fiscalYear?.id){
        //for updating fiscal years
        formData.patch(route('fiscal-years.update', props.fiscalYear?.id), {
            preserveScroll: true,
        });
    }else{
        //for storing fiscal years
        formData.post(route('fiscal-years.store'), {
            preserveScroll: true,
        });
    }

}

</script>


