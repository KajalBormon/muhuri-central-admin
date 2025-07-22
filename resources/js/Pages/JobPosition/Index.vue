<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search Job Positions" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Job Position-->
                        <button v-if="checkPermission('can-create-job-position')" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_job_position">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                                Add Job Position
                        </button>
                        <!--end::Add Job Position-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Job Position Name -->
                    <template v-slot:name="{ row: jobPosition }">
                        {{ jobPosition.name }}
                    </template>

                    <!-- Job Position Slug -->
                    <template v-slot:slug="{ row: jobPosition }">
                        {{ jobPosition.slug}}
                    </template>

                    <!-- Job Position Status -->
                    <template v-slot:is_active="{ row: jobPosition }">
                        <div class="form-check form-check-solid form-switch">
                            <ChangeStatusButton v-if="checkPermission('can-edit-job-position')" :obj="jobPosition" confirmRoute="job-positions.changeStatus" cancelRoute="job-positions.index" />
                        </div>
                    </template>

                    <!-- Job Position Actions -->
                    <template v-slot:actions="{ row: jobPosition }" v-if="checkPermission('can-edit-job-position') || checkPermission('can-delete-job-position')">
                        <!-- Edit -->
                        <button v-if="checkPermission('can-edit-job-position')" type="button" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px"  :title="$t('tooltip.title.edit')" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_job_position" @click="assignJobPositionData(jobPosition)">
                            <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                        </button>

                        <!-- Delete -->
                        <DeleteConfirmationButton v-if="checkPermission('can-delete-job-position')" :obj="jobPosition" confirmRoute="job-positions.destroy" />
                    </template>

                    <template v-slot:actions="{ row: jobPosition }" v-else>
                        {{ $t('confirmation.permissionDenied') }}
                    </template>
                </Datatable>
            </div>
        </div>

        <CreateJobPositionModal></CreateJobPositionModal>
        <EditJobPositionModal :jobPosition="jobPositionData"></EditJobPositionModal>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';
import CreateJobPositionModal from '@/Pages/JobPosition/Modals/CreateJobPositionModal.vue';
import EditJobPositionModal from '@/Pages/JobPosition/Modals/EditJobPositionModal.vue';
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
    jobPositions: Object as() => IJobPosition[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface IJobPosition {
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

const tableData = ref < IJobPosition[] > ([]);
const initJobPositions = ref < IJobPosition[] > ([]);

onMounted(() => {
    if (props.jobPositions) {
        initJobPositions.value = props.jobPositions.map(jobPosition => ({
            id: jobPosition.id,
            name: jobPosition.name,
            slug: jobPosition.slug,
            is_active: jobPosition.is_active,
        }));
        tableData.value = initJobPositions.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initJobPositions.value];
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

interface JobPositionData {
    id: number | null;
    name: string | null;
}

const jobPositionData = ref<JobPositionData>({
    id: null,
    name: null,
});

// Need for updating Job Position
const assignJobPositionData = (jobPosition: IJobPosition) => {
    jobPositionData.value.id = jobPosition.id;
    jobPositionData.value.name = jobPosition.name;
};
</script>
