<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.user?.id ? $t('user.header.edit') : $t('user.header.add') }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Name -->
                        <div class="d-flex flex-column mb-5 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">{{ $t('user.label.name') }}</label>
                            <Field type="text" class="form-control form-control-lg form-control-solid" :placeholder="$t('user.placeholder.name')" name="name" v-model="formData.name"/>
                            <ErrorMessage :errorMessage="formData.errors.name" />
                        </div>

                        <!-- Email -->
                        <div class="d-flex flex-column mb-5 fv-row">
                            <label class="required fs-5 fw-semibold mb-2">{{ $t('user.label.email') }}</label>
                            <Field type="email" class="form-control form-control-lg form-control-solid" :placeholder="$t('user.placeholder.email')" name="email" v-model="formData.email"/>
                            <ErrorMessage :errorMessage="formData.errors.email" />
                        </div>

                        <!-- Assign Role -->
                        <div lass="mb-5 fv-row">
                            <label class="fs-5 fw-semibold mb-2">{{ $t('user.label.assignRole') }}</label>
                            <Multiselect
                                :placeholder="$t('user.placeholder.assignRole')"
                                mode="tags"
                                v-model="formData.roles"
                                :searchable="true"
                                :options="allRoles"
                                label="name"
                                trackBy="name"
                                />
                        </div>
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.user?.id" />
                    </div>
                </VForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Field, Form as VForm } from "vee-validate";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { ref } from 'vue';
import Multiselect from '@vueform/multiselect';

const props = defineProps({
    user: Object,
    roles: Object,
    currentRoles: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface Role {
  id: number;
}

// assign all the roles from props to allRoles variable.
const allRoles = ref<Array<any>>([]);
if (Array.isArray(props.roles) && props.roles.length > 0) {
    allRoles.value = props.roles.map(role => ({value: role.id, name:role.name}));
}

const formData = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '12345',
    roles: props?.currentRoles !== undefined ? props.currentRoles.map((role: Role) => role.id) : []
});

const submit = () => {
    if (props.user?.id) {
        // for updating user
        formData.put(route('users.update', props.user?.id), {
            preserveScroll: true,
        });
    } else {
        // for adding new user
        formData.post(route('users.store'), {
            preserveScroll: true,
        });
    }
};
</script>
