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
                        <Link v-if="checkPermission('can-create-permission')" :href="route('permissions.create')" class="btn btn-primary">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            {{ $t('permission.header.add') }}
                        </Link>
                        <!--end::Add Permission-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>

            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Permission Name -->
                    <template v-slot:name="{ row: permission }">
                        <div class="d-flex align-items-center">
                            <Link v-if="checkPermission('can-edit-permission')" :href="route('permissions.edit', permission.id)">
                                {{ permission.name }}
                            </Link>
                            <div v-else>
                                {{ permission.name }}
                            </div>
                        </div>
                    </template>

                    <!-- Group -->
                    <template v-slot:group_name="{ row: permission }">
                        {{ permission.group_name }}
                    </template>

                    <!-- Display Name -->
                    <template v-slot:display_name="{ row: permission }">
                        {{ permission.display_name }}
                    </template>

                    <!-- Status -->
                    <template v-slot:actions="{ row: permission }"  v-if="checkPermission('can-edit-permission')">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="form-check form-check-solid form-switch">
                                <ChangeStatusButton v-if="checkPermission('can-edit-permission')" :obj="permission" confirmRoute="permissions.changeStatus" cancelRoute="permissions.index" />
                            </div>
                        </div>
                    </template>
                    <template v-slot:actions="{ row: branch }" v-else>
                        {{ $t('confirmation.permissionDenied') }}
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

const { t } = i18n.global;

const props = defineProps({
    permissions: Object as() => IPermission[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface IPermission {
    id: number;
    name: string;
    group_name: string;
    display_name: string;
    is_active: string;
}

const tableHeader = ref([{
        columnName: t('permission.label.name'),
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: t('permission.label.groupName'),
        columnLabel: "group_name",
        sortEnabled: true,
        columnWidth: 120
    },
    {
        columnName: t('permission.label.displayName'),
        columnLabel: "display_name",
        sortEnabled: true,
        columnWidth: 120
    },
    {
        columnName: t('buttonValue.actions'),
        columnLabel: "actions",
        sortEnabled: true,
        columnWidth: 100
    },
]);

const tableData = ref < IPermission[] > ([]);
const initPermissions = ref < IPermission[] > ([]);

onMounted(() => {
    if (props.permissions) {
        initPermissions.value = props.permissions.map(permission => ({
            id: permission.id,
            name: permission.name,
            group_name: permission.group_name,
            display_name: permission.display_name,
            is_active: permission.is_active,
        }));
        tableData.value = initPermissions.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initPermissions.value];
    if (search.value !== "") {
        tableData.value = tableData.value.filter(item => searchingFunc(item, search.value));
    }
    MenuComponent.reinitialization();
};

const searchingFunc = (obj: any, value: string): boolean => {
    for (let key in obj) {
        if (!Number.isInteger(obj[key]) && !(typeof obj[key] === "object")) {
            if (obj[key] && obj[key].includes && obj[key].includes(value)) {
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
