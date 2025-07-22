<template>
    <AuthenticatedLayout
        :breadcrumbs="props?.breadcrumbs"
        :pageTitle="props?.pageTitle"
    >
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">
                        {{ props.paymentMethod?.id ? "Edit Payment Method": "Add Payment Method" }}
                    </h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Name & Slug -->
                        <div class="row mb-5 g-4">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Name</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Name"
                                    name="name"
                                    v-model="formData.name"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.name"
                                />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Slug</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Slug"
                                    name="slug"
                                    v-model="formData.slug"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.slug"
                                />
                            </div>
                        </div>

                        <!-- Logo & Base URL -->
                        <div class="row mb-5 g-4">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Logo URL</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Logo URL"
                                    name="logo"
                                    v-model="formData.logo"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.logo"
                                />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Base URL</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Base URL"
                                    name="base_url"
                                    v-model="formData.base_url"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.base_url"
                                />
                            </div>
                        </div>

                        <!-- App Key & App Secret -->
                        <div class="row mb-5 g-4">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">App Key</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="App Key"
                                    name="app_key"
                                    v-model="formData.app_key"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.app_key"
                                />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">App Secret</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="App Secret"
                                    name="app_secret"
                                    v-model="formData.app_secret"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.app_secret"
                                />
                            </div>
                        </div>

                        <!-- Username & Password -->
                        <div class="row mb-5 g-4">
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Username</label>
                                <Field
                                    type="text"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Username"
                                    name="username"
                                    v-model="formData.username"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.username"
                                />
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Password</label>
                                <Field
                                    type="password"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Password"
                                    name="password"
                                    v-model="formData.password"
                                />
                                <ErrorMessage
                                    :errorMessage="formData.errors.password"
                                />
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div
                        class="card-footer d-flex justify-content-end py-6 px-9"
                    >
                        <SubmitButton :id="props.paymentMethod?.id" />
                    </div>
                </VForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Field, Form as VForm } from "vee-validate";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";

const props = defineProps({
    paymentMethod: Object,
    pageTitle: String,
    breadcrumbs: Array as () => Breadcrumb[],
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    name: props.paymentMethod?.name || "",
    slug: props.paymentMethod?.slug || "",
    logo: props.paymentMethod?.logo || "",
    base_url: props.paymentMethod?.base_url || "",
    app_key: props.paymentMethod?.app_key || "",
    app_secret: props.paymentMethod?.app_secret || "",
    username: props.paymentMethod?.username || "",
    password: props.paymentMethod?.password || ""
});

const submit = () => {
    if (props.paymentMethod?.id) {
        //for updating payment methods
        formData.patch(
            route("payment-methods.update", props.paymentMethod?.id),
            {
                preserveScroll: true,
            },
        );
    } else {
        //for storing payment methods
        formData.post(route("payment-methods.store"), {
            preserveScroll: true,
        });
    }
};
</script>
