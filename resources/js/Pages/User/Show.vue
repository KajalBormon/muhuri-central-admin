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
                                        <!-- <img :src="getAssetPath('media/avatars/300-1.jpg')" alt="Emma Smith" class="w-100" /> -->
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(props?.user) }}</div>
                                    </div>
                                    <!--end::Avatar-->

                                    <!--begin::Name-->
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ props.user?.name }}</a>
                                    <!--end::Name-->

                                    <!--begin::Position-->
                                    <div class="mb-9">
                                        <div v-for="role in props.user?.roles" :key="role.id"  class="badge badge-lg badge-light-primary d-inline me-3">{{ role.name }}</div>
                                    </div>
                                    <!--end::Position-->
                                </div>
                                <!--end::Summary-->

                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details" @click="toggleDetails">{{ $t('user.header.details') }}
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span></div>
                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" :title="$t('tooltip.title.editDetails')">
                                        <!--begin::Update User Details-->
                                        <button v-if="checkPermission('can-edit-user')" type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">{{ $t('buttonValue.edit') }}</button>
                                        <!--end::Update User Details-->
                                    </span>
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator"></div>

                                <!--begin::Details content-->
                                <div id="kt_user_view_details" class="collapse show" v-show="isDetailsVisible">
                                    <div class="pb-5 fs-6">
                                        <!--begin::Details item-->
                                        <div class="fw-bold mt-5">{{ $t('user.label.email') }}</div>
                                        <div class="text-gray-600">
                                            <a href="#" class="text-gray-600 text-hover-primary">{{ props.user?.email }}</a>
                                        </div>
                                        <!--begin::Details item-->
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
                                    <a id="kt_referrals_employee_list_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)" @click="activeTab = 2"
                                    :class="{ 'active': activeTab === 2 }">
                                        {{ $t('user.header.security') }}
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a id="kt_referrals_branch_details_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)"  @click="activeTab = 3"
                                    :class="{ 'active': activeTab === 3 }">
                                        {{ $t('user.header.authenticationLogs') }}
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a id="kt_referrals_employee_list_tab" class="nav-link text-active-primary" data-bs-toggle="tab" role="tab" href="javascript:void(0)" @click="activeTab = 4"
                                    :class="{ 'active': activeTab === 4 }">
                                        {{ $t('user.header.activityLogs') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Nav Tab-->

                        <!-- Start: Overview Section -->
                        <div id="kt_referred_employees_tab_content" class="tab-content">
                            <div id="branch_details" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 1">
                                <div class="card card-flush mb-6 mb-xl-9">
                                    <div class="card-header mt-6">
                                        <div class="card-title flex-column">
                                            <h2 class="mb-1">{{ $t('user.header.overview') }}</h2>
                                            <div class="fs-6 fw-semibold text-muted">{{ $t('user.header.show.upcomingMeetings') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Overview Section -->

                        <!-- Start: Security Section -->
                        <div id="kt_referred_employees_tab_content" class="tab-content">
                            <div id="branch_details" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 2">
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <div class="card-header border-0">
                                        <div class="card-title">
                                            <h2>{{ $t('user.header.show.profile') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 pb-5">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                                <tbody class="fs-6 fw-semibold text-gray-600">
                                                    <!-- Email -->
                                                    <tr>
                                                        <td>{{ $t('user.label.email') }}</td>
                                                        <td>{{ props.user?.email }}</td>
                                                        <td class="text-end">
                                                            <!-- Start: Update User Email -->
                                                            <button v-if="checkPermission('can-edit-user')" type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                                                <i class="ki-duotone ki-pencil fs-3">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </button>
                                                            <!-- End: Update User Email -->
                                                        </td>
                                                    </tr>

                                                    <!-- Password -->
                                                    <tr>
                                                        <td>{{ $t('user.label.password') }}</td>
                                                        <td>******</td>
                                                        <td class="text-end">
                                                            <!-- Start: Update User Password -->
                                                            <button v-if="checkPermission('can-edit-user')" type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                                <i class="ki-duotone ki-pencil fs-3">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </button>
                                                            <!-- End: Update User Password -->
                                                        </td>
                                                    </tr>

                                                    <!-- Role -->
                                                    <tr>
                                                        <td>{{ $t('user.label.role') }}</td>
                                                        <td>
                                                            <span v-for="(role, index) in props.user?.roles" :key="role.id">{{ role.name }}
                                                                <span v-if="index < (props.user?.roles.length - 1)">, </span>
                                                            </span>
                                                        </td>
                                                        <td class="text-end" >
                                                            <button v-if="checkPermission('can-edit-user')" type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                                                                <i class="ki-duotone ki-pencil fs-3">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- Status -->
                                                    <tr>
                                                        <td>{{ $t('user.label.status') }}</td>
                                                        <td><span class = "badge" :class="{'badge-success': props.user?.is_active, 'badge-danger': !props.user?.is_active}">{{ props.user?.is_active ? 'Active' : 'Inactive' }}</span></td>
                                                        <td class="text-end">
                                                            <div  class="d-flex justify-content-end align-items-center">

                                                                <div class="form-check form-check-solid form-switch">
                                                                    <ChangeStatusButton v-if="checkPermission('can-edit-user')" :obj="props?.user" confirmRoute="users.changeStatus" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Security Section -->

                        <!-- Start: Authentication Logs Section -->
                        <div id="kt_referred_employees_tab_content" class="tab-content">
                            <div id="branch_details" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 3">
                                <div class="card card-flush mb-6 mb-xl-9">
                                    <div class="card-header mt-6">
                                        <div class="card-title flex-column">
                                            <h2 class="mb-1">{{ $t('user.header.authenticationLogs') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pb-5 pt-0">
                                        <Datatable @on-sort="sortData" :data="tableDataAuthentication" :header="tableHeaderAuthentication" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                                            <!-- IP Address -->
                                            <template v-slot:ip_address="{ row: authenticationLog }" >
                                                <span class = "text-muted">{{ authenticationLog.ip_address }}</span>
                                            </template>

                                            <!-- IP Address -->
                                            <template v-slot:user_agent="{ row: authenticationLog }" >
                                                <span class = "text-muted">{{ authenticationLog.user_agent }}</span>
                                            </template>

                                            <!-- Login -->
                                            <template v-slot:login_at="{ row: authenticationLog }">
                                                <span class = "text-muted">{{ new Date(authenticationLog.login_at).toISOString().slice(0, 10) + ' ' + new Date(authenticationLog.login_at).toISOString().slice(11, 19) }}</span>
                                            </template>

                                            <!-- Logout -->
                                            <template v-slot:logout_at="{ row: authenticationLog }">
                                                <span class = "text-muted">{{ new Date(authenticationLog.logout_at).toISOString().slice(0, 10) + ' ' + new Date(authenticationLog.logout_at).toISOString().slice(11, 19) }}</span>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Authentication Logs Section -->

                        <!-- Start: Activity Logs Section -->
                        <div id="kt_referred_employees_tab_content" class="tab-content">
                            <div id="branch_details" class="py-4 tab-pane fade active show" role="tabpanel" v-show="activeTab === 4">
                                <div class="card card-flush mb-6 mb-xl-9">
                                    <div class="card-header mt-6">
                                        <div class="card-title flex-column">
                                            <h2 class="mb-1">{{ $t('user.header.activityLogs') }}</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pb-5 pt-0">
                                        <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                                            <!-- Activity Log Description -->
                                            <template v-slot:description="{ row: activityLog }" >
                                                <span class = "text-muted">{{ activityLog.description }}</span>
                                            </template>

                                            <!-- Activity Log Created Time -->
                                            <template v-slot:created_at="{ row: activityLog }">
                                                <span class = "text-muted">{{ new Date(activityLog.created_at).toISOString().slice(0, 10) + ' ' + new Date(activityLog.created_at).toISOString().slice(11, 19) }}</span>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Activity Logs Section -->
                    </div>
                </div>
            </div>
        </div>

        <EditUserDetailsModal :user="props?.user"></EditUserDetailsModal>
        <EditUserEmailModal :user="props?.user"></EditUserEmailModal>
        <EditUserPasswordModal :user="props?.user"></EditUserPasswordModal>
        <EditUserRolesModal :user="props?.user" :activeRoles="roles"></EditUserRolesModal>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EditUserDetailsModal from "@/Pages/User/Modals/EditUserDetailsModal.vue";
import EditUserEmailModal from "@/Pages/User/Modals/EditUserEmailModal.vue";
import EditUserPasswordModal from "@/Pages/User/Modals/EditUserPasswordModal.vue";
import EditUserRolesModal from "@/Pages/User/Modals/EditUserRolesModal.vue";
import { ref, watch, onMounted, onBeforeMount } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { checkPermission } from "@/Core/helpers/Permission";
import arraySort from "array-sort";
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import { getInitials } from '@/Core/helpers/Helper';
import i18n from '@/Core/plugins/i18n';
import ChangeStatusButton from "@/Components/Button/ChangeStatusButton.vue";

const { t } = i18n.global;

const props = defineProps({
    user: Object,
    roles: Object,
    activityLogs: Object as() => IActivityLog[] | undefined,
    authenticationLogs: Object as() => IAuthenticationLog[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
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
watch(activeTab, (newValue) => {
    if(activeTab.value == 1) {
        tabTitle.value = "Overview";
    } else if(activeTab.value == 2) {
        tabTitle.value = "Security";
    }
    else if(activeTab.value == 3) {
        tabTitle.value = "Authentication Logs";
    } else {
        tabTitle.value = "Activity Logs";
    }
});

// If a user status is changed, the following code be will be able to keep in the same tab.
onBeforeMount(() => {
    const flash = usePage().props.flash;
    let {success} = flash as any;

    if(flash && success) {
        activeTab.value = 2;
    }
});

interface IActivityLog {
    description: string;
    created_at: string;
}

interface IAuthenticationLog {
    ip_address: string;
    user_agent: string;
    login_at: string;
    logout_at: string;
}

const tableHeader = ref([
    {
        columnName: t('user.header.show.message'),
        columnLabel: "description",
        sortEnabled: false,
        columnWidth: 100
    },
    {
        columnName: t('user.header.show.date'),
        columnLabel: "created_at",
        sortEnabled: false,
        columnWidth: 100
    },
]);

const tableHeaderAuthentication = ref([
    {
        columnName: t('user.header.show.ipAddress'),
        columnLabel: "ip_address",
        sortEnabled: false,
        columnWidth: 100
    },
    {
        columnName: t('user.header.show.userAgent'),
        columnLabel: "user_agent",
        sortEnabled: false,
        columnWidth: 100
    },
    {
        columnName: t('buttonValue.login'),
        columnLabel: "login_at",
        sortEnabled: false,
        columnWidth: 100
    },
    {
        columnName: t('buttonValue.logout'),
        columnLabel: "logout_at",
        sortEnabled: false,
        columnWidth: 100
    },
]);

const tableData = ref < IActivityLog[] > ([]);
const initActivityLogs = ref < IActivityLog[] > ([]);

const tableDataAuthentication = ref < IAuthenticationLog[] > ([]);
const initAuthenticationLogs = ref < IAuthenticationLog[] > ([]);

onMounted(() => {
    if (props.activityLogs) {
        initActivityLogs.value = props.activityLogs.map((activityLog: any) => ({
            description: activityLog.description,
            created_at: activityLog.created_at,
        }));
        tableData.value = initActivityLogs.value;
    }

    if (props.authenticationLogs) {
        initAuthenticationLogs.value = props.authenticationLogs.map((authenticationLog: any) => ({
            ip_address: authenticationLog.ip_address,
            user_agent: authenticationLog.user_agent,
            login_at: authenticationLog.login_at,
            logout_at: authenticationLog.logout_at,
        }));
        tableDataAuthentication.value = initAuthenticationLogs.value;
    }
});

const sortData = (sort: Sort) => {
    const reverse: boolean = sort.order === "asc";
    if (sort.label) {
        arraySort(tableData.value, sort.label, {
            reverse
        });
    }
};
</script>

