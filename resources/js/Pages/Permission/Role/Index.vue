<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
            <div class="content flex-row-fluid" id="kt_content">
                <!--begin::Add new Role-->
                <div class="d-flex justify-content-end mb-3" data-kt-customer-table-toolbar="base" v-if="checkPermission('can-create-role')">
                    <Link :href="route('roles.create')" class="btn btn-primary">
                        <KTIcon icon-name="plus" icon-class="fs-2" />
                            {{ $t('role.header.add') }}
                    </Link>
                </div>
                <!--end::Add new Role-->

                <!--begin::Row-->
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                    <!--begin::Col-->
                    <div class="col-md-4" v-for="role in props?.roles" :key="role.id">
                        <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ role.name }}</h2>
                                </div>
                                <!-- change status -->
                                <div  class="d-flex justify-content-end align-items-center">
                                    <div class="form-check form-check-solid form-switch">
                                        <ChangeStatusButton v-if="role.is_editable==1 && checkPermission('can-edit-role')" :obj="role" confirmRoute="roles.changeStatus" cancelRoute="roles.index" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <div class="fw-bold text-gray-600 mb-5">
                                    Total users with this role: {{ role.users?.length }}
                                </div>

                                <!--begin::Permissions-->
                                <!-- Run the loop for 5 permissions -->
                                <div class="d-flex flex-column text-gray-600" >
                                    <div class="d-flex align-items-center py-2" v-for="permission in role.permissions.slice(0,5)" :key="permission.id">
                                        <span class="bullet bg-primary me-3"></span>{{ permission.name }}
                                    </div>

                                    <!-- See More Button (if there are more then 5 permissions) -->
                                    <div class="d-flex align-items-center py-2" v-if="role.permissions.length > 5 ">
                                        <span class="bullet bg-primary me-3" ></span>

                                        <Link v-if="checkPermission('can-view-details-role')" :href="route('roles.show', role.id)">
                                            <i>and {{ role.permissions.length - 5 }} more...</i>
                                        </Link>
                                        <span v-else>
                                            <i>and {{ role.permissions.length - 5 }} more...</i>
                                        </span>
                                    </div>
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->

                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                <!-- View -->
                                <Link v-if="checkPermission('can-view-details-role')" :href="route('roles.show', role.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px me-2" data-bs-toggle="tooltip" :title="$t('tooltip.title.view')">
                                    <KTIcon icon-name="eye" icon-class="fs-1 text-primary" />
                                </Link>

                                <!-- Edit -->
                                <Link v-if="role.is_editable && checkPermission('can-edit-role')" :href="route('roles.edit', role.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px me-2" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                    <KTIcon icon-name="pencil" icon-class="fs-1 text-primary" />
                                </Link>

                                <!-- Delete -->
                                <DeleteConfirmationButton v-if="role.is_deletable && checkPermission('can-delete-role')" iconClass = "fs-1" :obj="role" confirmRoute="roles.destroy" />
                            </div>
                            <!--end::Card footer-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';
import { checkPermission } from "@/Core/helpers/Permission";

const props = defineProps({
    roles: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}
</script>
