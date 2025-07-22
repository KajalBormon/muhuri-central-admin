<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">
    <div class="row flex">
        <div class="col-md-6">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">For Item {{ props.item?.name }}</h3>
                    </div>
                </div>
                <!--end::Card header-->

                <div class="show">
                    <VForm @submit="submit()" class="form">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!-- Item and item Unit -->
                            <div class="row mb-5 g-4">
                                <!-- Item Type -->
                                <div class="col-md-12 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Item Type</label>
                                    <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Item Type" name="type" v-model="formData.type" readonly/>
                                    <ErrorMessage :errorMessage="formData.errors.type" />
                                </div>

                                <!-- Item Category name -->
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-3 fs-5">
                                        Item Category
                                    </label>
                                    <Multiselect
                                        placeholder="Item Category Name"
                                        v-model="formData.category_id"
                                        :searchable="true"
                                        label="text"
                                        trackBy="value"
                                        :options="props?.categories"
                                    />
                                    <ErrorMessage :errorMessage="formData.errors.category_id" />
                                </div>

                                <!-- Parent Item name -->
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-3 fs-5">
                                        Parent Item Name
                                    </label>
                                    <Multiselect
                                        placeholder="Parent Item Name"
                                        v-model="formData.parent_id"
                                        :searchable="true"
                                        label="text"
                                        trackBy="value"
                                        :options="allParentItems"
                                    />
                                    <ErrorMessage :errorMessage="formData.errors.parent_id" />
                                </div>

                                <!-- Item Name -->
                                <div class="col-md-12 fv-row">
                                    <label class="required form-label mb-3 fs-5">
                                        Name
                                    </label>
                                    <!--end::Label-->
                                    <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Item Name" name="name" v-model="formData.name"/>
                                    <ErrorMessage :errorMessage="formData.errors.name" />
                                </div>

                                <div class="col-md-12 fv-row">
                                    <label class="required form-label mb-3 fs-5">
                                        Slug
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Item Slug" name="slug" v-model="formData.slug"/>
                                    <ErrorMessage :errorMessage="formData.errors.slug" />
                                </div>

                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-3 fs-5">
                                        Description
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Description" name="description" v-model="formData.description"/>
                                    <ErrorMessage :errorMessage="formData.errors.description" />
                                </div>
                            </div>
                        </div>
                        <!--end::Card body-->
                        <!-- Submit Button-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <SubmitButton :id="props.item?.id" />
                        </div>
                    </VForm>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Item Unit</h3>
                    </div>
                    <!--begin::Add Item-->
                    <div class="card-toolbar">
                    <!--begin::Add Item-->
                    <div v-if="checkPermission('can-create-item-unit')" class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <button type="button" class="btn btn btn-primary me-3 ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_add_item_unit">
                        <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Item Unit
                        </button>
                    </div>
                    <!--end::Add Item-->
                </div>
                    <!--end::Add Item-->
                </div>
                <div class="card-body border-top p-9">
                    <div class="row mb-5 g-4 flex" v-for="(itemUnit, index) in itemUnits" :key="index">
                        <div class="col-md-8">
                            <p>Unit name: {{ itemUnit.name }}</p>
                            <p>Unit value: {{ itemUnit.value }}</p>
                            <p>Display name: {{ itemUnit.display_name }}</p>
                            <p>Form display name: {{ itemUnit.form_display_name }}</p>
                        </div>

                        <div class="col-md-4">
                            <button v-if="checkPermission('can-edit-item-unit')" type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_item_unit" @click="openEditModal(itemUnit)">
                                <i class="ki-duotone ki-pencil fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>

                            <!-- Delete -->
                            <DeleteConfirmationButton v-if="checkPermission('can-delete-item-unit')" iconClass = "fs-1" :obj="itemUnit" confirmRoute="items.destroyItemUnit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <EditItemUnitModal :itemUnit="singleItemUnit"></EditItemUnitModal>
    <AddItemUnitModal :item="props?.item"></AddItemUnitModal>
    </AuthenticatedLayout>
</template>


<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, defineProps } from "vue";
import { useForm, usePage, router } from '@inertiajs/vue3';
import { Field, Form as VForm } from "vee-validate";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import Multiselect from '@vueform/multiselect';
import EditItemUnitModal from "@/Pages/Items/Modals/EditItemUnitModal.vue";
import AddItemUnitModal from '@/Pages/Items/Modals/AddItemUnitModal.vue'
import DeleteConfirmationButton from "@/Components/Button/DeleteConfirmationButton.vue";
import { checkPermission } from "@/Core/helpers/Permission";
import toastr from 'toastr';
import 'toastr/toastr.scss';

const props = defineProps({
    item: Object,
    categories: Array,
    parentItems: Object,
    itemUnits: Array as () => IItemUnits[],
    pageTitle: String,
    breadcrumbs: Array as() => Breadcrumb[]
});

interface IItemUnits {
    id: number,
    name: string;
    value: string;
    display_name: string;
    form_display_name: string;
    item_id: number;
}

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    category_id: props.item?.category_id || '',
    type: props.item?.type || '',
    parent_id: props.item?.parent_id || '',
    name: props.item?.name || '',
    slug: props.item?.slug || '',
    description: props.item?.description || ''
});

const allParentItems = ref<Array<any>>([]);
if (Array.isArray(props.parentItems) && props.parentItems.length > 0) {
    allParentItems.value = props.parentItems.map(parentItem => ({value: parentItem.id, text:parentItem.name}));
}

const singleItemUnit = ref({});
const openEditModal= (itemUnit: any) => {
    singleItemUnit.value = itemUnit;
}

const submit = () =>{
    if(props.item?.id){
        //for updating item
        formData.patch(route('items.update', props.item?.id), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('items.edit', props.item?.id), { replace: true });
                const flash = usePage().props.flash;
                let {success, error} = flash as any;
                if (flash && success) {
                    toastr.success(success);
                } else if (flash && error) {
                    toastr.error(error);
                }
            }
        });
    }
}

</script>


