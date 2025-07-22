<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" :placeholder="$t('user.placeholder.searchUsers')" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!-- Start: Filter -->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-filter fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>{{ $t('buttonValue.filter') }}
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold">{{ $t('user.filterOptions.title') }}</div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->

                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <!-- Start: Role filter -->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{ $t('user.filterOptions.subtitle.label.role') }}:</label>
                                    <Multiselect
                                        :placeholder="$t('user.filterOptions.subtitle.placeholder.role')"
                                        mode="tags"
                                        v-model=selectedRole
                                        :searchable="true"
                                        :options="allRoles"
                                        label="name"
                                        trackBy="name"
                                    />
                                </div>
                                <!-- End: Role filter -->

                                <!-- Start: Status filter -->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{ $t('user.filterOptions.subtitle.label.status') }}:</label>
                                    <Multiselect
                                        :placeholder = "$t('user.filterOptions.subtitle.placeholder.status')"
                                        v-model=selectedStatus
                                        :searchable="true"
                                        :options="allStatus"
                                    />
                                </div>
                                <!-- End: Status filter -->

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" @click="applyReset()">{{ $t('buttonValue.reset') }}</button>
                                    <button class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter" @click="applyFilter()">{{ $t('buttonValue.apply') }}</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--End: Filter-->
                        <!--begin::Add User-->
                        <Link v-if="checkPermission('can-create-user')" :href="route('users.create')" class="btn btn-primary">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            {{ $t('user.header.add') }}
                        </Link>
                        <!--end::Add User-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- User Name -->
                    <template v-slot:name="{ row: user }">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <Link v-if="checkPermission('can-edit-user')" :href="route('users.edit', user.id)">
                                    <div class="symbol-label">
                                        <!-- <img :src="getAssetPath('media/avatars/300-1.jpg')" alt="Emma Smith" class="w-100" /> -->
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(user) }}</div>
                                    </div>
                                </Link>
                                <div v-else class="symbol-label">
                                    <!-- <img :src="getAssetPath('media/avatars/300-1.jpg')" alt="Emma Smith" class="w-100" /> -->
                                    <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(user) }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <Link v-if="checkPermission('can-view-details-user')" :href="route('users.show', user.id)" class="text-gray-800 text-hover-primary mb-1">
                                    {{ user.name }}
                                </Link>
                                <span v-else>{{ user.name }}</span>
                                <span class = "text-gray-600">{{ user.email }}</span>
                            </div>
                        </div>
                    </template>

                    <!-- Roles -->
                    <template v-slot:roles="{ row: user }">
                        <div v-if="user.roles.length > 0" class="text-muted">
                            <div v-for="role in user.roles" :key="role.id">
                            {{ role.name }}
                            </div>
                        </div>
                        <div v-else>
                            ---
                        </div>
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: user }">
                        <div class = "badge" :class="{'badge-success': user?.is_active, 'badge-danger': !user?.is_active}">{{ user?.is_active ? 'Active' : 'Inactive' }}</div>
                    </template>

                    <!-- Last login -->
                    <template v-slot:last_login_at="{ row: user }">
                        <div class="badge badge-light fw-bold">{{ user.last_login_at }}</div>
                    </template>

                    <!-- Joining date -->
                    <template v-slot:created_at="{ row: user }">
                        {{ new Date(user.created_at).toISOString().slice(0, 10) + ' ' + new Date(user.created_at).toISOString().slice(11, 19) }}

                    </template>
                </Datatable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted,defineProps } from 'vue';
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import { MenuComponent } from "@/Assets/ts/components";
import arraySort from "array-sort";
import { Link } from '@inertiajs/vue3';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import Multiselect from '@vueform/multiselect';
import { checkPermission } from "@/Core/helpers/Permission";
import { getInitials } from '@/Core/helpers/Helper';
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const props = defineProps({
    users: Object as() => IUser[] | undefined,
    roles: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const selectedRole = ref([]);
const selectedStatus = ref<string>('');

interface IUser {
    id: number;
    name: string;
    email: string;
    roles: string[];
    is_active: string;
    created_at: string;
    last_login_at: string;
}

const tableHeader = ref([{
        columnName: t('user.label.name'),
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: t('user.label.role'),
        columnLabel: "roles",
        sortEnabled: true,
        columnWidth: 120
    },
    {
        columnName: t('user.label.status'),
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: t('user.label.lastLogin'),
        columnLabel: "last_login_at",
        sortEnabled: true,
        columnWidth: 130
    },
    {
        columnName: t('user.label.joiningDate'),
        columnLabel: "created_at",
        sortEnabled: true,
        columnWidth: 130
    },
]);

const tableData = ref < IUser[] > ([]);
const initUsers = ref < IUser[] > ([]);

onMounted(() => {
    if (props.users) {
        initUsers.value = props.users.map(user => ({
            id: user.id,
            name: user.name,
            email: user.email,
            roles: user.roles,
            is_active: user.is_active,
            created_at: user.created_at,
            last_login_at: user.last_login_at,
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
    // as role is an array we have done like the following
    for (let key in obj) {
        if (key === "roles") {
            // Iterate over roles array and check if any role name includes the search value
            for (let role of obj[key]) {
                if (role.name && role.name.includes(value)) {
                    return true;
                }
            }
        } else if (!Number.isInteger(obj[key]) && !(typeof obj[key] === "object")) {
            if (obj[key] && obj[key].includes && obj[key].includes(value)) {
                return true;
            }
        }
    }
    return false;
};

// assign all the roles from props to allRoles variable.
const allRoles = ref<Array<any>>([]);
if (Array.isArray(props.roles) && props.roles.length > 0) {
    allRoles.value = props.roles.map(role => ({value: role.name, name:role.name}));
}

// all Status
const allStatus = ['Active', 'Inactive'];

const applyFilter = () => {
    const roleFilter = selectedRole.value;
    const statusFilter = selectedStatus.value;
    if (roleFilter.length == 0 && (statusFilter == null || statusFilter.length == 0)) {
        // If nothing is selected, show all users
        tableData.value = initUsers.value;
    } else {
        if(roleFilter.length > 0 && ( statusFilter != null && statusFilter.length > 0)) {
            // Filter users based on selected roles and status
            const isActive = statusFilter == 'Active' ? "1" : "0";
            tableData.value = initUsers.value.filter(user => {
                    return roleFilter.some((role: any) => {
                        return user.roles.some((userRole: any) => {
                            return (userRole.name === role) && user.is_active == isActive;
                        });
                    });
                });
        } else if(roleFilter.length > 0) {
            // Filter users based on selected roles
            tableData.value = initUsers.value.filter(user => {
                return roleFilter.some((role: any) => {
                    return user.roles.some((userRole: any) => {
                        return userRole.name === role;
                    });
                });
            });
        } else {
            // Filter users based on selected status
            const isActive = statusFilter == 'Active' ? "1" : "0";
            tableData.value = initUsers.value.filter(user => {
                return user.is_active == isActive;
            });
        }
    }
};

const applyReset = () => {
    selectedRole.value = [];
    selectedStatus.value = '';
    tableData.value = initUsers.value;
}
const sortData = (sort: Sort) => {
    const reverse: boolean = sort.order === "asc";
    if (sort.label) {
        arraySort(tableData.value, sort.label, {
            reverse
        });
    }
};
</script>
