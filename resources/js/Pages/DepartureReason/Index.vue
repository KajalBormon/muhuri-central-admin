<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search Departure Reasons" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Departure Reason-->
                        <button v-if="checkPermission('can-create-departure-reason')" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_departure_reason">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                                Add Departure Reason
                        </button>
                        <!--end::Add Departure Reason-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- JDeparture Reason Name -->
                    <template v-slot:name="{ row: departureReason }">
                        {{ departureReason.name }}
                    </template>

                    <!-- Departure Reason Slug -->
                    <template v-slot:slug="{ row: departureReason }">
                        {{ departureReason.slug}}
                    </template>

                    <!-- Departure Reason Status -->
                    <template v-slot:is_active="{ row: departureReason }">
                        <div class="form-check form-check-solid form-switch">
                            <ChangeStatusButton v-if="checkPermission('can-edit-departure-reason')" :obj="departureReason" confirmRoute="departure-reasons.changeStatus" cancelRoute="departure-reasons.index" />
                        </div>
                    </template>

                    <!-- Departure Reason Actions -->
                    <template v-slot:actions="{ row: departureReason }" v-if="checkPermission('can-edit-departure-reason') || checkPermission('can-delete-departure-reason')">
                        <!-- Edit -->
                        <button v-if="checkPermission('can-edit-departure-reason')" type="button" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px"  :title="$t('tooltip.title.edit')" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_departure_reason" @click="assignDepartureReasonData(departureReason)">
                            <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                        </button>

                        <!-- Delete -->
                        <DeleteConfirmationButton v-if="checkPermission('can-delete-departure-reason')" :obj="departureReason" confirmRoute="departure-reasons.destroy" />
                    </template>

                    <template v-slot:actions="{ row: departureReason }" v-else>
                        {{ $t('confirmation.permissionDenied') }}
                    </template>
                </Datatable>
            </div>
        </div>

        <CreateDepartureReasonModal></CreateDepartureReasonModal>
        <EditDepartureReasonModal :departureReason="departureReasonData"></EditDepartureReasonModal>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';
import CreateDepartureReasonModal from '@/Pages/DepartureReason/Modals/CreateDepartureReasonModal.vue';
import EditDepartureReasonModal from '@/Pages/DepartureReason/Modals/EditDepartureReasonModal.vue';
import { ref, onMounted, defineProps } from 'vue';
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import { MenuComponent } from "@/Assets/ts/components";
import arraySort from "array-sort";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { checkPermission } from "@/Core/helpers/Permission";
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const props = defineProps({
    departureReasons: Object as() => IDepartureReason[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface IDepartureReason {
    id: number;
    name: string;
    slug: string;
    is_active: boolean;
}

const tableHeader = ref([
    {
        columnName: t('label.name'),
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 175
    },
    {
        columnName: t('label.slug'),
        columnLabel: "slug",
        sortEnabled: true,
        columnWidth: 230
    },
    {
        columnName: t('label.status'),
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 230
    },
    {
        columnName: t('label.actions'),
        columnLabel: "actions",
        sortEnabled: false,
        columnWidth: 135
    }
]);

const tableData = ref < IDepartureReason[] > ([]);
const initDepartureReasons = ref < IDepartureReason[] > ([]);

onMounted(() => {
    if (props.departureReasons) {
        initDepartureReasons.value = props.departureReasons.map(departureReason => ({
            id: departureReason.id,
            name: departureReason.name,
            slug: departureReason.slug,
            is_active: departureReason.is_active,
        }));
        tableData.value = initDepartureReasons.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initDepartureReasons.value];
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

interface DepartureReasonData {
    id: number | null;
    name: string | null;
}

const departureReasonData = ref<DepartureReasonData>({
    id: null,
    name: null,
});

// Need for updating Departure Reason
const assignDepartureReasonData = (departureReason: IDepartureReason) => {
    departureReasonData.value.id = departureReason.id;
    departureReasonData.value.name = departureReason.name;
};
</script>
