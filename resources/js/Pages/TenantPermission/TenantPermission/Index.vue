<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" :placeholder="$t('permission.placeholder.searchPermissions')" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Permission-->
                        <Link v-if="checkPermission('can-create-tenant-permission')" :href="route('tenant-permissions.create')" class="btn btn-primary">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Tenant Permission
                        </Link>
                        <!--end::Add Permission-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>

            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Name -->
                    <template v-slot:name="{ row: tenantPermission }">
                        {{ tenantPermission.name }}
                    </template>

                    <!-- Guard name -->
                    <template v-slot:guard_name="{ row: tenantPermission }">
                        {{ tenantPermission.guard_name }}
                    </template>

                    <!-- Group name -->
                    <template v-slot:group_name="{ row: tenantPermission }">
                        {{ tenantPermission.group_name }}
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: tenantPermission }">
                        <div class="form-check form-check-solid form-switch d-flex justify-content-start">
                            <ChangeStatusButton v-if="checkPermission('can-edit-tenant-permission')" :obj="tenantPermission" confirmRoute="tenant-permissions.changeStatus" cancelRoute="tenant-permissions.index" />
                        </div>
                    </template>

                    <!-- Permission Actions -->
                    <template v-slot:actions="{ row: tenantPermission }">
                        <div class="d-flex align-items-center justify-content-end">
                            <Link v-if="checkPermission('can-edit-tenant-permission')" :href="route('tenant-permissions.edit', tenantPermission.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                            <!-- Delete -->
                            <DeleteConfirmationButton v-if="checkPermission('can-delete-tenant-permission')" iconClass="fs-1" :obj="tenantPermission" confirmRoute="tenant-permissions.destroy" title="Delete Tenant Permission" :messageTitle="`${tenantPermission.name} ?`"/>
                        </div>
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
import { checkPermission } from "@/Core/helpers/Permission";
import i18n from '@/Core/plugins/i18n';
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';

const { t } = i18n.global;

const props = defineProps({
    tenantPermissions: Object as () => ITenantPermissions[],
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface ITenantPermissions {
    id: number;
    name: string;
    guard_name: string;
    group_name: string;
    is_active: boolean;
}

const tableHeader = ref([
    {
        columnName: 'Name',
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 150
    },
    {
        columnName: 'Guard Name',
        columnLabel: "guard_name",
        sortEnabled: true,
        columnWidth: 150
    },
    {
        columnName: 'Group Name',
        columnLabel: "group_name",
        sortEnabled: true,
        columnWidth: 150
    },
    {
        columnName: 'Status',
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100
    },
        {
        columnName: 'Actions',
        columnLabel: "actions",
        sortEnabled: true,
        columnWidth: 100
    }
]);

const tableData = ref < ITenantPermissions[] > ([]);
const initTenantPermissions = ref < ITenantPermissions[] > ([]);

onMounted(() => {
    if (props.tenantPermissions) {
        initTenantPermissions.value = props.tenantPermissions.map(tenantPermission => ({
            id: tenantPermission.id,
            name: tenantPermission.name,
            guard_name: tenantPermission.guard_name,
            group_name: tenantPermission.group_name,
            is_active: tenantPermission.is_active
        }));
        tableData.value = initTenantPermissions.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initTenantPermissions.value];
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
