<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search fiscal years" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Fiscal Year-->
                        <Link v-if="checkPermission('can-create-fiscal-year')" :href="route('fiscal-years.create')" class="btn btn-primary me-3">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Fiscal Year
                        </Link>
                        <!--end::Add Fiscal Year-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="false" :items-per-page="Infinity"
                :pagination-enabled="false" :checkbox-enabled="false">
                    <!-- Fiscal Year -->
                    <template v-slot:fiscal_year="{ row: fiscalYear }">
                        {{ fiscalYear.fiscal_year }}
                    </template>

                    <!-- start_date -->
                    <template v-slot:start_date="{ row: fiscalYear }">
                        {{ fiscalYear.start_date }}
                    </template>

                    <!-- end_date -->
                    <template v-slot:end_date="{ row: fiscalYear }">
                        {{ fiscalYear.end_date }}
                    </template>

                    <!-- Running Status -->
                    <template v-slot:status="{ row: fiscalYear }">
                        <div class = "badge" :class="{'badge-success': fiscalYear.status === 'running'}">
                            {{ fiscalYear.status }}
                        </div>
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: fiscalYear }">
                        <div class="form-check form-check-solid form-switch">
                            <ChangeStatusButton v-if="checkPermission('can-edit-fiscal-year')" :obj="fiscalYear" confirmRoute="fiscal-years.changeStatus" cancelRoute="fiscal-years.index" />
                        </div>
                    </template>

                    <!-- Fiscal Year Actions -->
                    <template v-slot:actions="{ row: fiscalYear }" v-if="checkPermission('can-edit-fiscal-year')">
                        <div class="d-flex align-items-center justify-content-end">
                            <!-- Edit -->
                            <Link v-if="checkPermission('can-edit-fiscal-year') && fiscalYear.status !== 'end'" :href="route('fiscal-years.edit', fiscalYear.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                            <!-- Start Year -->
                            <FiscalYearConfirmationButton v-if="checkPermission('can-edit-fiscal-year') && fiscalYear.status==='pending'" iconName = "add-notepad" :obj="fiscalYear" confirmRoute="fiscal-years.startFiscalYear" title="Start Year" :messageTitle="`Are you sure want to start year ${fiscalYear.fiscal_year} ?`"/>
                            <!-- End Year -->
                            <FiscalYearConfirmationButton v-if="checkPermission('can-edit-fiscal-year') && fiscalYear.status==='running'" iconName = "timer" :obj="fiscalYear" confirmRoute="fiscal-years.closeFiscalYear" title="End Year" :messageTitle="`Are you sure want to end year ${fiscalYear.fiscal_year} ?`" />
                        </div>
                    </template>
                    <template v-slot:actions="{ row: fiscalYear }" v-else>
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
import arraySort from "array-sort";
import { Link } from '@inertiajs/vue3';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { MenuComponent } from "@/Assets/ts/components";
import { checkPermission } from "@/Core/helpers/Permission";
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import FiscalYearConfirmationButton from '@/Components/Button/FiscalYearConfirmationButton.vue';

const props = defineProps({
    fiscalYears: Object as() => IFiscalYear[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String
});

interface IFiscalYear {
    id: number;
    fiscal_year: string;
    start_date: string;
    end_date: string;
    status: string;
    is_active: boolean;
}

interface Breadcrumb {
    url: string;
    title: string;
}

const tableHeader = ref([{
        columnName: "Year",
        columnLabel: "fiscal_year",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Start Date",
        columnLabel: "start_date",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "End Date",
        columnLabel: "end_date",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Running Status",
        columnLabel: "status",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Status",
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Actions",
        columnLabel: "actions",
        sortEnabled: true,
        columnWidth: 100
    },
]);

const tableData = ref < IFiscalYear[] > ([]);
const initFiscalYears = ref < IFiscalYear[] > ([]);

onMounted(() => {
    if (props.fiscalYears) {
        initFiscalYears.value = props.fiscalYears.map(fiscalYear => ({
            id: fiscalYear.id,
            fiscal_year: fiscalYear.fiscal_year,
            start_date: fiscalYear.start_date,
            end_date: fiscalYear.end_date,
            status: fiscalYear.status,
            is_active: fiscalYear.is_active
        }));
        tableData.value = initFiscalYears.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initFiscalYears.value];
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
