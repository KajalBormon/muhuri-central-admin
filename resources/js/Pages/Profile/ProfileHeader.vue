<template>
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img :src="getAssetPath('/media/avatars/300-1.jpg')" alt="image"/>
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border-4 border-white h-20px w-20px"></div>
                    </div>
                </div>
                <!--end::Pic-->

                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-1">
                                    {{ props.user?.name }}
                                </a>
                                <a href="#">
                                    <KTIcon icon-name="verify" icon-class="fs-1 text-primary"/>
                                </a>
                            </div>
                            <!--end::Name-->

                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <KTIcon icon-name="sms" icon-class="fs-4 me-1"/>
                                    {{ props.user?.email }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->

                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <KTIcon icon-name="arrow-up" icon-class="fs-3 text-success me-2"/>
                                        <div class="fs-2 fw-bold">4500$</div>
                                    </div>
                                    <!--end::Number-->

                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-500">Earnings</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->

                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <KTIcon icon-name="arrow-down" icon-class="fs-3 text-danger me-2"/>
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="75">
                                            75
                                        </div>
                                    </div>
                                    <!--end::Number-->

                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-500">Projects</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->

                                <!--begin::Stat-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <KTIcon icon-name="arrow-up" icon-class="fs-3 text-success me-2"/>
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60"
                                            data-kt-countup-prefix="%">
                                            60%
                                        </div>
                                    </div>
                                    <!--end::Number-->

                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-500">Success Rate</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap">
                    <li class="nav-item">
                        <Link :href="route('profile.edit')" :class="{ active: isActive('myProfile') }"
                            class="nav-link text-active-dark me-6">{{ $t('user.header.profile.edit') }}
                        </Link>
                    </li>
                </ul>
            </div>
            <!--end::Navs-->
        </div>
    </div>
    <slot></slot>
    <!--end::Navbar-->
</template>

<script lang="ts" setup>
import {getAssetPath} from "@/Core/helpers/Assets";
import { Link } from '@inertiajs/vue3'
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";

const props = defineProps({
    activeLink: String,
    user: Object,
});

const headerActiveLink = props.activeLink;

const isActive = (linkName: String) => {
    return headerActiveLink == linkName;
};
</script>
