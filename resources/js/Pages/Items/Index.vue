<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

    <ItemsHeader :activeTab="($page.props.itemType as string)"></ItemsHeader>

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search items" />
                    </div>
                    <!--end::Search-->
                </div>
                <div class="card-toolbar">
                    <!--begin::Add Item-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <button v-if="checkPermission('can-create-item')" type="button" class="btn btn btn-primary me-3 ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_add_item">
                        <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Item
                        </button>
                    </div>
                    <!--end::Add Item-->
                </div>

            </div>

            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="false" :items-per-page="Infinity"
                :pagination-enabled="false" :checkbox-enabled="false">
                    <!-- Parent Name -->
                    <template v-slot:parentName="{ row: item }">
                        {{ item.parentName }}
                    </template>

                    <!-- Name -->
                    <template v-slot:name="{ row: item }">
                        {{ item.name }}
                    </template>

                    <!-- slug -->
                    <template v-slot:slug="{ row: item }">
                        {{ item.slug }}
                    </template>

                    <!-- category -->
                    <template v-slot:categoryName="{ row: item }">
                        {{ item.categoryName }}
                    </template>

                    <!-- type -->
                    <template v-slot:type="{ row: item }">
                        {{ item.type }}
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: item }">
                        <div class="form-check form-check-solid form-switch text-start">
                            <ChangeStatusButton v-if="checkPermission('can-edit-item')" :obj="item" confirmRoute="items.changeStatus" cancelRoute="items.getItemsBySale" />
                        </div>
                    </template>

                    <!-- Edit -->
                    <template v-slot:action="{ row: item }">
                        <Link v-if="checkPermission('can-edit-item')" :href="route('items.edit', item.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px me-2" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                        <KTIcon icon-name="pencil" icon-class="fs-1 text-primary" />
                        </Link>
                    </template>

                </Datatable>
            </div>
        </div>
        <AddItemModal
        :itemType="props.itemType"
        :items="props?.items"
        :allParentItems="allParentItems"
        :categories="props?.categories"
        >
        </AddItemModal>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted,defineProps, watch, computed } from 'vue';
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import arraySort from "array-sort";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import { MenuComponent } from "@/Assets/ts/components";
import { checkPermission } from "@/Core/helpers/Permission";
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import ItemsHeader from '@/Pages/Items/ItemsHeader.vue';
import AddItemModal from '@/Pages/Items/Modals/AddItemModal.vue';

const props = defineProps({
    items: Object as() => IItems[] | undefined,
    categories: Array,
    parentItems: Object,
    itemType: String,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String
});

interface IItems {
    id: number;
    parent_id: number,
    name: string;
    slug: string;
    type: string;
    category_id: number,
    status: string;
    is_active: boolean;
}

interface Breadcrumb {
    url: string;
    title: string;
}

const tableHeader = ref([{
        columnName: "Parent",
        columnLabel: "parentName",
        sortEnabled: true,
        columnWidth: 150
    },
    {
        columnName: "Name",
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Slug",
        columnLabel: "slug",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: "Type",
        columnLabel: "type",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: "Category",
        columnLabel: "categoryName",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: "Status",
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 100,
    },
    {
        columnName: "Action",
        columnLabel: "action",
        sortEnabled: true,
        columnWidth: 100,
    }
]);

const tableData = ref < IItems[] > ([]);
const initItems = ref < IItems[] > ([]);

onMounted(() => {
    if (props.items) {
        initItems.value = props.items.map((item: any) => ({
            id: item.id,
            parent_id: item.parent_id,
            parentName: !item.parent_id ? item.name : null,
            name: !item.parent_id ? null : item.name,
            slug: item.slug,
            type: item.type,
            category_id: item.category_id,
            categoryName: item?.category_id ? item.company_category?.name : null,
            status: item.status,
            is_active: item.is_active
        }));
        tableData.value = [...initItems.value];
    }
});

const items = ref(usePage().props.items);
const itemType = ref(usePage().props.itemType);

watch(() => usePage().props.itemType, (newType: any) => {
    router.get(route('items.index', { itemType: newType }), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            items.value = usePage().props.items;
        }
    } as any);
});

// assign all the parentItems from props to allParentItems variable.
const allParentItems = ref<Array<any>>([]);
if (Array.isArray(props.parentItems) && props.parentItems.length > 0) {
    allParentItems.value = props.parentItems.map(parentItem => ({value: parentItem.id, text:parentItem.name}));
}

const search = ref<string>("");

const searchData = () => {
    if (!search.value) {
        tableData.value = [...initItems.value];
    } else {
        tableData.value = initItems.value.filter(item => searchingFunc(item, search.value));
    }
    MenuComponent.reinitialization();
};

const searchingFunc = (obj: any, value: string): boolean => {
    for (let key in obj) {
        const fieldValue = obj[key];
        if (
            fieldValue &&
            typeof fieldValue === "string" &&
            fieldValue.toLowerCase().includes(value.toLowerCase())
        ) {
            return true;
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
