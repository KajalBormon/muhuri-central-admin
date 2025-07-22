<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.brand?.id ? $t('brand.title.edit') : $t('brand.title.add') }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Fiscal Year and Note -->
                        <div class="row mb-5 g-4">
                            <!-- Brand -->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">{{ $t('brand.label.brandName') }}</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('brand.placeholder.brandName')" name="name" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name" />
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.brand?.id" />
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
    brand: Object,
    pageTitle: String,
    breadcrumbs: Array as() => Breadcrumb[],
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    name: props.brand?.name || '',
});

const submit = () =>{
    if(props.brand?.id){
        //for updating fiscal years
        formData.patch(route('brands.update', props.brand?.id), {
            preserveScroll: true,
        });
    }else{
        //for storing fiscal years
        formData.post(route('brands.store'), {
            preserveScroll: true,
        });
    }

}

</script>


