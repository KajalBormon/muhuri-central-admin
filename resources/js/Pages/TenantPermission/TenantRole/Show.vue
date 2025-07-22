<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
            <div class="content flex-row-fluid" id="kt_content">
                <div class="d-flex flex-column flex-lg-row">
                    <!-- Start: Role Details -->
                    <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                        <div class="card card-flush">
                            <!-- Card Header -->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2 class="mb-0">{{ props?.tenantRole?.name }}</h2>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body pt-0">
                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600" v-for="permission in props?.tenantRole?.permissions" :key="permission.id">
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>{{ permission?.name }}</div>
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--Card footer-->
                            <div class="card-footer pt-0">
                                <!-- Edit -->
                                <Link v-if="props?.tenantRole?.is_editable && checkPermission('can-edit-tenant-role')" :href="route('tenant-roles.edit', props?.tenantRole?.id)" class="btn btn-light btn-active-primary" data-bs-toggle="tooltip" title="Edit">
                                    {{ $t('role.header.edit') }}
                                </Link>
                            </div>
                        </div>
                    </div>
                    <!-- End: Role Details -->

                    <!-- Assigned Users -->
                    <div class="flex-lg-row-fluid ms-lg-10">
                        <div class="card card-flush mb-6 mb-xl-9">
                            <!-- Card header -->
                            <div class="card-header pt-5">
                                <div class="card-title">
                                    <h2 class="d-flex align-items-center">Tenant Role</h2>
                                </div>
                                <div class="card-toolbar">

                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div>
                                    <table class="table align-middle table-row-bordered fs-6 gy-5 mb-0">
                                        <!-- Table Header -->
                                        <thead class="fs-6 fw-semibold text-gray-600">
                                            <tr style="border-color: #9a9a9f">
                                                <th class="text-start">Name</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>

                                        <!-- Table Body -->
                                        <tbody class="fw-semibold">
                                            <tr>
                                                <td class="text-start">
                                                    {{ props?.tenantRole?.name }}
                                                </td>
                                                <td class="text-center">
                                                    <div class = "badge" :class="{'badge-success': props?.tenantRole?.is_active, 'badge-danger': !props?.tenantRole?.is_active}">{{ props?.tenantRole?.is_active ? 'Active' : 'Inactive' }}</div>
                                                </td>
                                                <td class="text-end">
                                                    <DeleteConfirmationButton v-if="checkPermission('can-delete-tenant-role')" iconClass="fs-1" :obj="tenantRole" confirmRoute="tenant-roles.destroy" title="Delete Tenant Role" :messageTitle="`${props?.tenantRole?.name} ?`"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                    <!-- End: Assigned Users -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script lang="ts" setup>
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import { MenuComponent } from "@/Assets/ts/components";
import arraySort from "array-sort";
import { Link } from '@inertiajs/vue3'
import { checkPermission } from "@/Core/helpers/Permission";
import { getFullName, getInitials } from '@/Core/helpers/Helper';
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const props = defineProps({
    tenantRole: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

</script>
