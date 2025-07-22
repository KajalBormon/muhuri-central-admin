<template>
    <div class="modal fade" id="kt_modal_add_item" ref="editUserModalRef" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header d-flex justify-content-between">
                    <!--begin::Title-->
                    <h2>Add Items With Item Unit</h2>
                    <!--end::Title-->
                    <!--begin::Close-->
                    <div v-if="currentStep === 3" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="modal-body py-lg-10 px-lg-10">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
                        <!--begin::Aside-->
                        <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px align-items-center">
                            <!--begin::Nav-->
                            <div class="stepper-nav ps-lg-10">
                                <!--begin::Step 1-->
                                <div class="stepper-item" :class="currentStep === 1 ? 'current' : ''" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                            <span class="stepper-number">1</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Item</h3>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="stepper-item" :class="currentStep === 2 ? 'current' : ''" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                            <span class="stepper-number">2</span>
                                        </div>
                                        <!--begin::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Item Unit</h3>
                                        </div>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="stepper-item" :class="currentStep === 3 ? 'current' : ''" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="ki-duotone ki-check stepper-check fs-2"></i>
                                            <span class="stepper-number">3</span>
                                        </div>
                                        <!--begin::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Completed</h3>
                                        </div>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 3-->
                            </div>
                            <!-- end::Nav -->
                        </div>
                        <!-- end::Aside -->
                        <!--begin::Content-->
                        <div class="flex-row-fluid py-lg-5 px-lg-15">
                            <!--begin::Form-->
                            <VForm @submit="submit()" :model="itemUnitData" ref="formRef" class="mx-auto mw-600px w-100 py-10" id="kt_modal_add_branch_job_position_form">
                                <!--begin::Step 1-->
                                <div v-if="currentStep === 1">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900">Add Item</h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">Please add both the item and item unit to continue.
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!-- Type Option -->
                                            <div class="mb-6">
                                                <!--begin::Label-->
                                                <label class="required form-label mb-3">
                                                    Item Type
                                                </label>
                                                <!--end::Label-->
                                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Item type" name="type" v-model="itemData.type" readonly/>
                                                <ErrorMessage :errorMessage="itemData.errors.type" />
                                            </div>

                                            <!-- Item Category name -->
                                            <div class="mb-6">
                                                <label class="form-label mb-3">
                                                    Item Category
                                                </label>
                                                <Multiselect
                                                    placeholder="Item Category Name"
                                                    v-model="itemData.category_id"
                                                    :searchable="true"
                                                    label="text"
                                                    trackBy="value"
                                                    :options="props?.categories"
                                                />
                                                <ErrorMessage :errorMessage="itemData.errors.category_id" />
                                            </div>

                                            <div class="mb-6">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                Parent Item Name
                                                </label>
                                                <!--end::Label-->
                                                <Multiselect
                                                    placeholder="Parent Item Name"
                                                    v-model="itemData.parent_id"
                                                    :searchable="true"
                                                    label="text"
                                                    trackBy="value"
                                                    :options="allParentItems"
                                                />
                                                <ErrorMessage :errorMessage="itemData.errors.parent_id" />
                                            </div>

                                            <div class="mb-6">
                                                <!--begin::Label-->
                                                <label class="required form-label mb-3">
                                                Name
                                                </label>
                                                <!--end::Label-->
                                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Item Name" name="name" v-model="itemData.name"/>
                                                <ErrorMessage :errorMessage="itemData.errors.name" />
                                            </div>
                                            <div class="mb-6">
                                                <!--begin::Label-->
                                                <label class="required form-label mb-3">
                                                    Slug
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Item Slug" name="slug" v-model="itemData.slug"/>
                                                <ErrorMessage :errorMessage="itemData.errors.slug" />
                                            </div>
                                            <div class="mb-6">
                                                <label class="form-label mb-3">
                                                Description
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Description" name="description" v-model="itemData.description"/>
                                                <ErrorMessage :errorMessage="itemData.errors.description" />
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div v-if="currentStep === 2">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-gray-900">Add Item Unit for {{ itemName }}</h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">Please create both the Item and Item Unit to continue.
                                            <!-- <a href="#" class="link-primary fw-bold">Help Page</a>. -->
                                        </div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Input group-->
                                        <div class="mb-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label mb-3">Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <Field type="text" placeholder="Item Unit Name" class="form-control form-control-lg form-control-solid" name="name" v-model="itemUnitData.name"/>
                                            <ErrorMessage :errorMessage="itemUnitData.errors.name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label mb-3">Value</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <Field type="text" placeholder="Item Unit Name" class="form-control form-control-lg form-control-solid" name="value" v-model="itemUnitData.value"/>
                                            <ErrorMessage :errorMessage="itemUnitData.errors.value" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label mb-3">Display Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <Field type="text" placeholder="Item Unit Name" class="form-control form-control-lg form-control-solid" name="display_name" v-model="itemUnitData.display_name"/>
                                            <ErrorMessage :errorMessage="itemUnitData.errors.display_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label mb-3">Form Display Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <Field type="text" placeholder="Item Unit Name" class="form-control form-control-lg form-control-solid" name="form_display_name" v-model="itemUnitData.form_display_name"/>
                                            <ErrorMessage :errorMessage="itemUnitData.errors.form_display_name" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->


                                        <button @click="addItemUnit" type="button" class="btn btn-light-primary">
                                            Save
                                        </button>

                                        <div class="mt-10 mb-5" v-if="addedItemUnits.length">
                                            <h5>Added Unit Item</h5>
                                            <div v-for="itemUnit in addedItemUnits" :key="itemUnit?.id" class="mb-6">
                                                <p>Name: {{ itemUnit?.name }}</p>
                                                <p>Value: {{ itemUnit?.value }}</p>
                                                <p>Display Name: {{ itemUnit?.display_name }}</p>
                                                <p>From Display Name: {{ itemUnit?.form_display_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 2-->

                                <!--begin::Step 3-->
                                    <div v-if="currentStep === 3">
                                        <!--begin::Wrapper-->
                                        <div class="w-100">
                                            <!--begin::Heading-->
                                            <div class="pb-8 pb-lg-10 text-center">
                                                <!--begin::Title-->
                                                <h2 class="fw-bold text-gray-900">You Are Done!</h2>
                                                <!--end::Title-->
                                                <!--begin::Notice-->
                                                <div class="text-muted fw-semibold fs-6">
                                                    You can now see
                                                </div>
                                                  <div class="text-muted fw-semibold fs-6 mt-3">
                                                  <a :href="route('items.index', { itemType: props.itemType })" class="btn btn btn-primary me-3 ms-auto">Done</a>
                                                </div>
                                                <!--end::Notice-->
                                            </div>
                                            <!--end::Heading-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Step 3-->

                                <!--begin::Actions-->
                                <div class="d-flex flex-stack pt-15">
                                    <div>
                                        <button @click="nextStep" type="button" class="btn btn-primary" v-if="currentStep < 2">
                                            Next
                                        </button>
                                        <SubmitButton v-if="currentStep === 2" buttonValue="Next" />
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Actions-->
                            </VForm>
                        </div>
                        <!-- end::Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import { onMounted, ref, watch } from "vue";
import { Field, Form as VForm } from "vee-validate";
import { useForm } from '@inertiajs/vue3';
import { Modal } from 'bootstrap';
import axios from "axios";
import Multiselect from '@vueform/multiselect';

const formRef = ref<null | HTMLFormElement>(null);
const addItemUnitItemModalRef = ref<any | HTMLElement>(null);

const props = defineProps({
    items: Object,
    categories: Array,
    itemType: String,
    allParentItems: Object,
});

const itemData = useForm({
    category_id: props.items?.category_id || '',
    type: props.itemType,
    parent_id: props.items?.name || '',
    name: props.items?.name || '',
    slug: props.items?.slug || '',
    description: props.items?.description || '',
});

const itemUnitData = useForm({
    name: '',
    value: '',
    display_name: '',
    form_display_name: ''
});

interface Item {
    id: number;
    category_id: number;
    type: string;
    parent_id: string;
    name: string;
    slug: string;
    description: string;
}

interface ItemUnit {
    id: number;
    name: string;
    value: number,
    display_name: string,
    form_display_name: string
}

const currentStep = ref(1);
const addedItems = ref<Item[]>([]);
const addedItemUnits = ref<ItemUnit[]>([]);

const loadAddedItems = async () => {
    try {
        const response = await axios.get(`/items/get-by-type/${itemData?.type}`);
        addedItems.value = response.data as Item[];
        itemData.parent_id = '';
    } catch (error) {
        console.error('Failed to load Items:', error);
    }
};

let itemId = ref<number>(0);
let itemName = ref<string>('');

const loadAddedItemUnits = async () => {
    try {
        const response = await axios.get(`/items/${itemId.value}/item-units`);
        addedItemUnits.value = response.data as ItemUnit[];
    } catch (error) {
        console.error('Failed to load Item Unit:', error);
    }
};

const addItemUnit = () => {
    if(!itemId.value){
        console.log('First Item Id set');
    }
    itemUnitData.post(route('items.storeItemUnit', itemId.value), {
        preserveScroll: true,
        onSuccess: () => {
            itemUnitData.reset();
            loadAddedItemUnits();
        }
    });
};

watch(currentStep, (newStep) => {
    localStorage.setItem('currentStep', newStep.toString());
    if (currentStep.value === 3) {
        localStorage.removeItem('currentStep');
    }
});

const nextStep = () => {
    itemData.post(route('items.store'), {
        preserveScroll: true,
        onSuccess: () => {
            currentStep.value++;
            const item = props.items?.find((item: any) => item.parent_id == itemData.parent_id);
            itemId.value = item.id;
            itemName.value = item.name;
            itemData.reset();
            loadAddedItems();
        }
    });
};

const showModal = () => {
    if (addItemUnitItemModalRef.value) {
        const modal = new Modal(addItemUnitItemModalRef.value, {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    }
};

onMounted(() => {
    loadAddedItems();
    loadAddedItemUnits();
    const savedStep = localStorage.getItem('currentStep');
    if (savedStep) {
        currentStep.value = parseInt(savedStep);
    }

    if(currentStep.value !== 1){
            showModal();
    }
});

const submit = async () => {
    const itemUnitExists = addedItemUnits.value.some(itemUnit => itemUnit.name === itemUnitData.name);

    if (currentStep.value === 2) {
        if ((!itemUnitData.name && addedItemUnits.value.length > 0) ||
            (itemUnitData.name && addedItemUnits.value.length === 0) ||
            (itemUnitData.name && addedItemUnits.value.length !== 0 && !itemUnitExists)) {
            currentStep.value++;
        }
        addItemUnit();
    }
};
</script>

