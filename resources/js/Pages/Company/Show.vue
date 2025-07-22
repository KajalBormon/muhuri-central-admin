<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
            <div class="content flex-row-fluid" id="kt_content">
                <div class="d-flex flex-column flex-lg-row">
                    <!-- User Information Section -->
                    <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body">
                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column py-5">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px symbol-circle mb-7">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(props?.company) }}</div>
                                    </div>
                                    <!--end::Avatar-->

                                    <!--begin::Name-->
                                    <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-1">
                                        {{ props.company?.name }}
                                        <span v-if="props.company?.mobile_number_verified_at">
                                            <KTIcon
                                                icon-name="verify"
                                                icon-class="fs-1 text-primary"
                                                title="Verified"
                                            />
                                        </span>
                                        <span v-else>
                                            <i class="fas fa-exclamation-circle text-warning fs-2" title="Not Verified"></i>
                                        </span>
                                    </a>
                                </div>
                                <!--end::Summary-->

                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details" @click="toggleDetails">{{ $t('user.header.details') }}
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span></div>
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator"></div>

                                <!--begin::Details content-->
                                <div id="kt_user_view_details" class="collapse show" v-show="isDetailsVisible">
                                    <div class="pb-5 fs-6">
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">Mobile Number</div>
                                        <div class="text-gray-600 d-flex justify-content-between">
                                            <span class="d-flex align-items-center">
                                                <span class="text-gray-600 text-hover-primary me-2">{{ props.company?.mobile_number }}</span>
                                                <i v-if="props.company?.mobile_number_verified_at" class="fas fa-check-circle text-primary fs-2 me-2" title="Verified"></i>
                                                <i v-else class="fas fa-exclamation-circle text-warning fs-2 me-2" title="Not Verified"></i>
                                            </span>
                                            <span class="d-flex align-items-center">
                                                <button
                                                    v-if="checkPermission('can-edit-company') && !props.company?.mobile_number_verified_at"
                                                    @click="handleOTP(props.company, 'send')"
                                                    class="btn btn-primary text-xs px-2 py-1 me-2"
                                                >
                                                    Send OTP
                                                </button>
                                                <button
                                                    v-if="checkPermission('can-edit-company') && !props.company?.mobile_number_verified_at && props.company?.otp && props.company?.otp_expire_at"
                                                    @click="handleOTP(props.company, 'verify')"
                                                    class="btn btn-primary text-xs px-2 py-1 me-2"
                                                >
                                                    Verify OTP
                                                </button>
                                                <i class="fas fa-pen text-muted fs-4 ms-2" title="Edit Mobile Number"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                        </div>
                    </div>

                    <!-- Tab Sections -->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <!--begin::Nav Tab-->
                        <div class="card-toolbar m-0">
                            <ul class="nav nav-stretch fs-5 fw-semibold nav-line-tabs nav-line-tabs-2x border-transparent" role="tablist" >
                                <li class="nav-item" role="presentation">
                                    <a id="kt_referrals_branch_details_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)"  @click="activeTab = 1"
                                    :class="{ 'active': activeTab === 1 }">
                                        {{ $t('user.header.overview') }}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="kt_referrals_company_onboarding_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)"  @click="activeTab = 2"
                                    :class="{ 'active': activeTab === 2 }">
                                        Company Onboarding Step
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Nav Tab-->

                        <!-- Start: Overview Section -->
                        <div id="kt_referred_employees_tab_content" class="tab-content">
                            <div id="branch_details" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 1">
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <div class="card-header border-0">
                                        <div class="card-title">
                                            <h2>Company Information</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 pb-5">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                                <tbody class="fs-6 fw-semibold text-gray-600">
                                                    <!-- Company Name -->
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{ props.company?.name }}</td>
                                                    </tr>

                                                    <!-- Workspace -->
                                                    <tr>
                                                        <td>Workspace</td>
                                                        <td>{{ props.company?.workspace }}</td>
                                                    </tr>

                                                    <!-- Address -->
                                                    <tr>
                                                        <td>Address</td>
                                                        <td>
                                                            {{ props.address }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Overview Section -->

                        <!-- Start: Company Onboarding Step Section -->
                        <div id="kt_referred_company_onboarding_tab_content" class="tab-content">
                            <div id="company_onboarding" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 2">
                                <div class="card card-flush mb-6 mb-xl-9">
                                    <div class="card-header mt-6">
                                        <div class="card-title flex-column">
                                            <h2 class="mb-1">Company Onboarding Step</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pb-5 pt-0">
                                        <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                                            <!-- Company Created -->
                                            <template v-slot:company_created="{ row: companyOnboardingStep }" >
                                                <span class = "text-muted d-block text-center">
                                                    {{ companyOnboardingStep.company_created ? '✅' : 'Run' }}
                                                </span>
                                            </template>

                                            <!-- Database Created -->
                                            <template v-slot:database_created="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.database_created">✅</template>
                                                    <button v-else @click="runOnboardingStep('database_created')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Database Migrated -->
                                            <template v-slot:database_migrated="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.database_migrated">✅</template>
                                                    <button v-else @click="runOnboardingStep('database_migrated')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Initial Data Loaded -->
                                            <template v-slot:initial_data_loaded="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.initial_data_loaded">✅</template>
                                                    <button v-else @click="runOnboardingStep('initial_data_loaded')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Tenant Permission Synced -->
                                            <template v-slot:tenant_permission_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.tenant_permission_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('tenant_permission_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Tenant Role Synced -->
                                            <template v-slot:tenant_role_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.tenant_role_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('tenant_role_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- User Created -->
                                            <template v-slot:user_created="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.user_created">✅</template>
                                                    <button v-else @click="runOnboardingStep('user_created')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Subscription Synced -->
                                            <template v-slot:subscription_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.subscription_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('subscription_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Item Synced -->
                                            <template v-slot:item_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.item_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('item_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Brand Synced -->
                                            <template v-slot:brand_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.brand_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('brand_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Fiscal Year Synced -->
                                            <template v-slot:fiscal_year_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.fiscal_year_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('fiscal_year_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Free SMS Added -->
                                            <template v-slot:free_sms_added="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.free_sms_added">✅</template>
                                                    <button v-else @click="runOnboardingStep('free_sms_added')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Payment Method Synced -->
                                            <template v-slot:payment_method_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.payment_method_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('payment_method_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Job Position Synced -->
                                            <template v-slot:job_position_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.job_position_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('job_position_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>

                                            <!-- Departure Reason Synced -->
                                            <template v-slot:departure_reason_synced="{ row: companyOnboardingStep }">
                                                <span class="text-muted d-block text-center">
                                                    <template v-if="companyOnboardingStep.departure_reason_synced">✅</template>
                                                    <button v-else @click="runOnboardingStep('departure_reason_synced')" class="btn btn-sm btn-danger">Run</button>
                                                </span>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Company Onboarding Step Section -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from '@inertiajs/vue3';
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import { checkPermission } from "@/Core/helpers/Permission";
import { getInitials } from '@/Core/helpers/Helper';
import i18n from '@/Core/plugins/i18n';
import arraySort from "array-sort";
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { usePage } from '@inertiajs/vue3';
import toastr from 'toastr';
import 'toastr/toastr.scss';

const { t } = i18n.global;

const props = defineProps({
    company: Object,
    address: Object,
    breadcrumbs: Array as () => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const isDetailsVisible = ref(true);
const toggleDetails = () => {
    isDetailsVisible.value = !isDetailsVisible.value;
};

const activeTab = ref(1);
const tabTitle = ref(props?.pageTitle);
const tableData = ref<ICompanyOnboardingStep[]>([]);

watch(activeTab, (newValue) => {
    tabTitle.value = newValue === 1 ? "Overview" : "Onboarding Step";
});

interface ICompanyOnboardingStep {
    company_created: boolean;
    database_created: boolean;
    database_migrated: boolean;
    initial_data_loaded: boolean;
    tenant_permission_synced: boolean;
    tenant_role_synced: boolean;
    user_created: boolean;
    subscription_synced: boolean;
    item_synced: boolean;
    brand_synced: boolean;
    fiscal_year_synced: boolean;
    free_sms_added: boolean;
    payment_method_synced: boolean;
    job_position_synced: boolean;
    departure_reason_synced: boolean;
}

const tableHeader = ref([
    { columnName: 'Company Created', columnLabel: "company_created", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Database Created', columnLabel: "database_created", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Database Migrated', columnLabel: "database_migrated", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Initial Data Load', columnLabel: "initial_data_loaded", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Tenant Permission Synced', columnLabel: "tenant_permission_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Tenant Role Synced', columnLabel: "tenant_role_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'User Created', columnLabel: "user_created", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Subscription Synced', columnLabel: "subscription_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Item Synced', columnLabel: "item_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Brand Synced', columnLabel: "brand_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Fiscal Year Synced', columnLabel: "fiscal_year_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Free SMS Added', columnLabel: "free_sms_added", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Payment Method Synced', columnLabel: "payment_method_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Job Position Synced', columnLabel: "job_position_synced", sortEnabled: false, columnWidth: 100, align: "center" },
    { columnName: 'Departure Reason Synced', columnLabel: "departure_reason_synced", sortEnabled: false, columnWidth: 100, align: "center" },
]);

onMounted(() => {
    if (props.company?.company_onboarding_step) {
        tableData.value = [{ ...props.company.company_onboarding_step }];
    }
});

const runOnboardingStep = async (step: string) => {
    const result = await Swal.fire({
        title: `Are you sure you want to run ${formatStepName(step)}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, run it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (!result.isConfirmed) return;

    Swal.fire({
        title: 'Running...',
        html: `Processing <b>${formatStepName(step)}</b>. Please wait...`,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        await router.patch(route("companies.onboarding.status.update", props?.company?.id), {
            onboarding_step: step,
            value: !props.company?.company_onboarding_step?.[step]
        });
        await fetchStatus(step);

        Swal.fire({ title: "Success!", text: `${formatStepName(step)} completed successfully.`, icon: "success" })
            .then(() => router.visit(route("companies.show", props.company?.id), { replace: true }));
    } catch (error) {
        Swal.fire({ title: "Error", text: `Failed to update the process of ${formatStepName(step)}.`, icon: "error" });
    }
};

const fetchStatus = async (step: string) => {
    let isCompleted = false;
    while (!isCompleted) {
        try {
            const { data } = await axios.get(`/companies/${props.company?.id}/onboarding/status`);
            isCompleted = data[step];
            if (!isCompleted) await new Promise(resolve => setTimeout(resolve, 500));
        } catch (error) {
            Swal.fire({ title: "Error", text: `Failed to fetch onboarding status for ${formatStepName(step)}.`, icon: "error" });
        }
    }
};

const formatStepName = (step: string) => step
    .replace(/_/g, ' ')
    .replace(/created|migrated|loaded/g, match => ({ created: 'create', migrated: 'migration', loaded: 'load' }[match] || match))
    .replace(/\b\w/g, char => char.toUpperCase());

const sortData = (sort: Sort) => {
    if (sort.label) arraySort(tableData.value, sort.label, { reverse: sort.order === "asc" });
};

const handleOTP = async (company: any, action: 'send' | 'verify') => {
    if (action === 'send') {
        const result = await Swal.fire({
            title: `Send OTP to ${company.mobile_number}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, send it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        });

        if (!result.isConfirmed) return;

        Swal.fire({
            title: 'Sending OTP...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        router.post(
            route("companies.onboarding.otp.send", company?.id),
            { mobile_number: company?.mobile_number },
            {
                preserveScroll: true,
                replace: true,
                onSuccess: () => {
                    Swal.close();

                    const { success, error } = usePage().props.flash as any;
                    if (success) {
                        toastr.success(success);
                        handleOTP(company, 'verify');
                    } else if (error) {
                        toastr.error(error);
                    }
                }
            }
        );
    } else {
        const { value: otp } = await Swal.fire({
            title: 'Enter OTP',
            input: 'text',
            inputPlaceholder: 'Enter your OTP',
            showCancelButton: true,
            confirmButtonText: 'Verify OTP',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        });

        if (!otp) return;

        Swal.fire({
            title: 'Verifying OTP...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        router.post(
            route("companies.onboarding.otp.verify", company?.id),
            { mobile_number: company?.mobile_number, otp },
            {
                preserveScroll: true,
                replace: true,
                onSuccess: () => {
                    Swal.close();

                    const { success, error } = usePage().props.flash as any;
                    if (success) {
                        toastr.success(success);
                    } else if (error) {
                        toastr.error(error);
                    }
                }
            }
        );
    }
};
</script>
