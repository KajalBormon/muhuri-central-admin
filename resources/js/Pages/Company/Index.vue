<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search companies" />
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
                            </i>
                            Filter
                        </button>

                         <!--begin::Add Company -->
                        <Link :href="route('companies.create')" class="btn btn-primary">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                                Add Company
                        </Link>
                        <!--end::Add Company -->

                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->

                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <!-- Start: Status filter -->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Status:</label>
                                    <Multiselect
                                        placeholder = "Select Status"
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
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Name -->
                    <template v-slot:name="{ row: company }">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(company) }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <Link v-if="checkPermission('can-view-details-company')" :href="route('companies.show', company.id)" class="text-gray-800 text-hover-primary mb-1">
                                    {{ company.name }}
                                </Link>
                                <span v-else>{{ company.name }}</span>
                                <span class = "text-gray-600">{{ company.mobile_number }}</span>
                            </div>
                        </div>
                    </template>

                    <!-- Workspace -->
                    <template v-slot:workspace="{ row: company }">
                        {{ company.workspace }}
                    </template>

                    <!-- Subscription  -->
                    <template v-slot:subscription="{ row: company }">
                        <span><b>{{ company.subscription?.subscription_plan?.name }}</b></span>
                        <br>
                        <span v-if="company.subscription?.subscription_plan?.price && company.subscription?.subscription_plan?.plan_type">
                            ${{ company.subscription?.subscription_plan?.price }}/
                            {{ company.subscription?.subscription_plan?.plan_type }}
                        </span>
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: company }">
                        <div class = "badge" :class="{'badge-success': company?.is_active, 'badge-danger': !company?.is_active}">{{ company?.is_active ? 'Active' : 'Inactive' }}</div>
                    </template>

                    <!-- Is Onboarding Completed -->
                    <template v-slot:is_onboarding_completed="{ row: company }">
                        <div class = "badge" :class="{'badge-success': company?.is_onboarding_completed, 'badge-danger': !company?.is_onboarding_completed}">{{ company?.is_onboarding_completed ? 'Yes' : 'No' }}</div>
                    </template>

                    <!-- Joining date -->
                    <template v-slot:created_at="{ row: company }">
                        {{ new Date(company.created_at).toISOString().slice(0, 10) + ' ' + new Date(company.created_at).toISOString().slice(11, 19) }}
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
    companies: Object as() => ICompany[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const selectedStatus = ref<string>('');

interface ICompany {
    id: number;
    name: string;
    mobile_number: string;
    workspace: string;
    subscription: string;
    is_active: string;
    is_onboarding_completed: boolean;
    created_at: string;
}

const tableHeader = ref([{
        columnName: "Company Name",
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: "Workspace",
        columnLabel: "workspace",
        sortEnabled: true,
        columnWidth: 120
    },
    {
        columnName: "Subscription",
        columnLabel: "subscription",
        sortEnabled: true,
        columnWidth: 120
    },
    {
        columnName: "Status",
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Onboarding Completed",
        columnLabel: "is_onboarding_completed",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Joining Date",
        columnLabel: "created_at",
        sortEnabled: true,
        columnWidth: 100
    },
]);

const tableData = ref < ICompany[] > ([]);
const initCompanies = ref < ICompany[] > ([]);

onMounted(() => {
    if (props.companies) {
        initCompanies.value = props.companies.map(company => ({
            id: company.id,
            name: company.name,
            mobile_number: company.mobile_number,
            workspace: company.workspace,
            subscription: company.subscription,
            is_active: company.is_active,
            is_onboarding_completed: company.is_onboarding_completed,
            created_at: company.created_at
        }));
        tableData.value = initCompanies.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initCompanies.value];
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

// all Status
const allStatus = ['Active', 'Inactive'];

const applyFilter = () => {
    const statusFilter = selectedStatus.value;
    // Filter companies based on selected status
    const isActive = statusFilter == 'Active' ? "1" : "0";
    tableData.value = initCompanies.value.filter(company => {
        return company.is_active == isActive;
    });
};

const applyReset = () => {
    selectedStatus.value = '';
    tableData.value = initCompanies.value;
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
