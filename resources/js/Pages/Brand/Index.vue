<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" :placeholder="$t('brand.placeholder.searchBrand')" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Brand-->
                        <Link v-if="checkPermission('can-create-brand')" :href="route('brands.create')" class="btn btn-primary me-3">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            {{ $t('brand.buttonValue.addBrand') }}
                        </Link>
                        <!--end::Add Brand -->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="false" :items-per-page="Infinity" :pagination-enabled="false" :checkbox-enabled="false">
                    <!-- Brand -->
                    <template v-slot:name="{ row: brand }">
                        {{ brand.name }}
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: brand }">
                        <div class="form-check form-check-solid form-switch d-flex justify-content-start">
                            <ChangeStatusButton v-if="checkPermission('can-edit-brand')" :obj="brand" confirmRoute="brands.changeStatus" cancelRoute="brands.index" />
                        </div>
                    </template>

                    <!-- Brand Actions -->
                    <template v-slot:actions="{ row: brand }">
                        <div class="d-flex align-items-center justify-content-end">
                            <Link v-if="checkPermission('can-edit-brand')" :href="route('brands.edit', brand.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                            <!-- Delete -->
                            <DeleteConfirmationButton v-if="checkPermission('can-delete-brand')" iconClass="fs-1" :obj="brand" confirmRoute="brands.destroy" title="Delete Brand" :messageTitle="`${brand.name} ?`"/>
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
import arraySort from "array-sort";
import { Link } from '@inertiajs/vue3';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { MenuComponent } from "@/Assets/ts/components";
import { checkPermission } from "@/Core/helpers/Permission";
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const props = defineProps({
    brands: Object as () => IBrand[] | undefined,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
   url: string;
   title: string;
}

interface IBrand{
    id: number;
    name: string;
    is_active: number;
}

const tableHeader = ref([
    {
        columnName: t('brand.label.brandName'),
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: t('label.status'),
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: t('label.actions'),
        columnLabel: "actions",
        sortEnabled: true,
        columnWidth: 100
    },
]);

const tableData = ref < IBrand[] > ([]);
const initBrands = ref < IBrand[] > ([]);

onMounted(() => {
    if (props.brands) {
        initBrands.value = props.brands.map(brand => ({
            id: brand.id,
            name: brand.name,
            is_active: brand.is_active
        }));
        tableData.value = initBrands.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initBrands.value];
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
