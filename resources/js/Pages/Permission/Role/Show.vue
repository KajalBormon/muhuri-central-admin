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
                                    <h2 class="mb-0">{{ props.role?.name }}</h2>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body pt-0">
                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600" v-for="permission in props.role?.permissions" :key="permission.id">
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>{{ permission.name }}</div>
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--Card footer-->
                            <div class="card-footer pt-0">
                                <!-- Edit -->
                                <Link v-if="props.role?.is_editable && checkPermission('can-edit-role')" :href="route('roles.edit', props.role?.id)" class="btn btn-light btn-active-primary" data-bs-toggle="tooltip" title="Edit">
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
                                    <h2 class="d-flex align-items-center">{{ $t('role.header.usersAssigned') }}
                                        <span class="text-gray-600 fs-6 ms-1">({{ props.users?.length }})</span></h2>
                                </div>
                                <div class="card-toolbar">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1" data-kt-view-roles-table-toolbar="base">
                                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-roles-table-filter="search" class="form-control form-control-solid w-250px ps-15" :placeholder="$t('user.placeholder.searchUsers')" v-model="search" @input="searchData()"/>
                                    </div>
                                    <!--end::Search-->
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                                    <!-- User Name -->
                                    <template v-slot:name="{ row: user }" >
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <Link v-if = "checkPermission('can-edit-user')" :href="route('users.edit', user.id)">
                                                    <div class="symbol-label">
                                                        <!-- <img :src="getAssetPath('media/avatars/300-1.jpg')" alt="Emma Smith" class="w-100" /> -->
                                                        <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(user) }}</div>
                                                    </div>
                                                </Link>
                                                <div class="symbol-label" v-else>
                                                    <!-- <img :src="getAssetPath('media/avatars/300-1.jpg')" alt="Emma Smith" class="w-100" /> -->
                                                    <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getFullName(user) }}</div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <Link v-if = "checkPermission('can-edit-user')"  :href="route('users.edit', user.id)" class="text-gray-800 text-hover-primary mb-1">
                                                    {{ user.name }}
                                                </Link>
                                                <span v-else>{{ user.name }}</span>
                                                <span class = "text-gray-600">{{ user.email }}</span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Status -->
                                    <template v-slot:is_active="{ row: user }">
                                        <div class = "badge" :class="{'badge-success': user?.is_active, 'badge-danger': !user?.is_active}">{{ user?.is_active ? 'Active' : 'Inactive' }}</div>
                                    </template>

                                    <!-- Joined Date -->
                                    <template v-slot:created_at="{ row: user }">
                                        {{ new Date(user.created_at).toISOString().slice(0, 10) + ' ' + new Date(user.created_at).toISOString().slice(11, 19) }}
                                    </template>

                                    <!-- User Actions -->
                                    <template v-slot:actions="{ row: user }">
                                        <!-- Remove User from Role -->
                                        <DeleteConfirmationButton v-if="checkPermission('can-edit-role')" iconClass = "fs-1" :obj="user" :roleId="props.role?.id" confirmRoute="roles.removeUserFromRole" />
                                        <span v-else>{{ $t('confirmation.permissionDenied') }}</span>
                                    </template>

                                </Datatable>
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
    role: Object,
    users: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});
interface Breadcrumb {
    url: string;
    title: string;
}

interface IUser {
    id: number;
    name: string;
    email: string;
    created_at: string;
}

const tableHeader = ref([{
        columnName: t('user.label.name'),
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 175
    },
    {
        columnName: t('user.label.status'),
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: t('user.label.joiningDate'),
        columnLabel: "created_at",
        sortEnabled: true,
        columnWidth: 130
    },
    {
        columnName: t('buttonValue.actions'),
        columnLabel: "actions",
        sortEnabled: true,
        columnWidth: 130
    },
]);

const tableData = ref < IUser[] > ([]);
const initUsers = ref < IUser[] > ([]);

onMounted(() => {
    if (props.users) {
        initUsers.value = props.users.map((user: any) => ({
            id: user.id,
            name: user.name,
            email: user.email,
            is_active: user.is_active,
            created_at: user.created_at,
        }));
        tableData.value = initUsers.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initUsers.value];
    if (search.value !== "") {
        tableData.value = tableData.value.filter(item => searchingFunc(item, search.value));
    }
    MenuComponent.reinitialization();
};

const searchingFunc = (obj: any, value: string): boolean => {
    for (let key in obj) {
        if (!Number.isInteger(obj[key]) && !(typeof obj[key] === "object")) {
            if (obj[key].includes(value)) {
                return true;
            }
        }
    }
    return false;
};

const sortData = (sort: Sort) => {
    const reverse: boolean = sort.order === "asc";
    if (sort.label) {
        arraySort(tableData.value, sort.label, {
            reverse
        });
    }
};
</script>
