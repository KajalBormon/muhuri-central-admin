<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search Payment Methods" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Payment Method-->
                        <Link v-if="checkPermission('can-create-payment-method')" :href="route('payment-methods.create')" class="btn btn-primary me-3">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Payment Method
                        </Link>
                        <!--end::Add Payment Method -->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="false" :items-per-page="Infinity" :pagination-enabled="false" :checkbox-enabled="false">
                    <!-- Name -->
                    <template v-slot:name="{ row: paymentMethod }">
                        {{ paymentMethod.name }}
                    </template>

                    <!-- Slug -->
                    <template v-slot:slug="{ row: paymentMethod }">
                        {{ paymentMethod.slug }}
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: paymentMethod }">
                        <div class="form-check form-check-solid form-switch d-flex justify-content-start">
                            <ChangeStatusButton v-if="checkPermission('can-edit-payment-method')" :obj="paymentMethod" confirmRoute="payment-methods.changeStatus" cancelRoute="payment-methods.index" />
                        </div>
                    </template>

                    <!-- Actions -->
                    <template v-slot:actions="{ row: paymentMethod }">
                        <div class="d-flex align-items-center justify-content-end">
                            <Link v-if="checkPermission('can-edit-payment-method')" :href="route('payment-methods.edit', paymentMethod.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                            <!-- Delete -->
                            <DeleteConfirmationButton v-if="checkPermission('can-delete-payment-method')" iconClass="fs-1" :obj="paymentMethod" confirmRoute="payment-methods.destroy" title="Delete Payment Method" :messageTitle="`${paymentMethod.name} ?`"/>
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
    paymentMethods: Object as () => IPaymentMethod[] | undefined,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface IPaymentMethod{
    id: number;
    name: string;
    slug: string;
    is_active: number;
}

const tableHeader = ref([
    {
        columnName: 'Name',
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: 'Slug',
        columnLabel: "slug",
        sortEnabled: true,
        columnWidth: 200
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
    },
]);

const tableData = ref < IPaymentMethod[] > ([]);
const initPaymentMethods = ref < IPaymentMethod[] > ([]);

onMounted(() => {
    if (props.paymentMethods) {
        initPaymentMethods.value = props.paymentMethods.map(paymentMethod => ({
            id: paymentMethod.id,
            name: paymentMethod.name,
            slug: paymentMethod.slug,
            is_active: paymentMethod.is_active
        }));
        tableData.value = initPaymentMethods.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initPaymentMethods.value];
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
